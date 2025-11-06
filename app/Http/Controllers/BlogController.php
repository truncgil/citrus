<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;
		
		$query = class_exists(Blog::class)
			? Blog::with(['category', 'author'])
				->withCount('comments')
				->published()
			: null;

		// Author filtresi
		if ($query && $request->has('author') && $request->author) {
			$query = $query->where('author_id', $request->author);
		}

		// Category filtresi
		if ($query && $request->has('category') && $request->category) {
			$query = $query->whereHas('category', function($q) use ($request) {
				$q->where('slug', $request->category);
			});
		}

		// Tag filtresi
		if ($query && $request->has('tag') && $request->tag) {
			$query = $query->whereJsonContains('tags', $request->tag);
		}

		$posts = $query
			? $query->latest('published_at')->paginate(12)
			: collect();

		// Render Header Template - En son aktif olan header template'i kullan
		$renderedHeader = null;
		$headerTemplate = HeaderTemplate::where('is_active', true)
			->latest('updated_at')
			->first();
		
		if ($headerTemplate) {
			$templateDefaults = $headerTemplate->default_data ?? [];
			$renderedHeader = TemplateService::replacePlaceholders(
				$headerTemplate->html_content,
				$templateDefaults
			);
		}

		// Render Footer Template - En son aktif olan footer template'i kullan
		$renderedFooter = null;
		$footerTemplate = FooterTemplate::where('is_active', true)
			->latest('updated_at')
			->first();
		
		if ($footerTemplate) {
			$templateDefaults = $footerTemplate->default_data ?? [];
			$renderedFooter = TemplateService::replacePlaceholders(
				$footerTemplate->html_content,
				$templateDefaults
			);
		}

		return view('blog.index', [
			'settings' => $settings,
			'posts' => $posts,
			'renderedHeader' => $renderedHeader,
			'renderedFooter' => $renderedFooter,
			'meta' => [
				'title' => __('blog.meta-index-title'),
				'description' => __('blog.meta-index-description'),
			],
		]);
	}

	public function show(string $slug)
	{
		$settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;
		if (!class_exists(Blog::class)) {
			abort(404);
		}
		$post = Blog::with(['category', 'author'])
			->withCount('comments')
			->published()
			->where('slug', $slug)
			->firstOrFail();

		// İlgili blog gönderilerini al (aynı kategoriden, mevcut gönderi hariç)
		$relatedPosts = Blog::with(['category', 'author'])
			->withCount('comments')
			->published()
			->where('id', '!=', $post->id)
			->when($post->category_id, function($query) use ($post) {
				return $query->where('category_id', $post->category_id);
			})
			->latest('published_at')
			->limit(4)
			->get();

		// Eğer aynı kategoriden yeterli gönderi yoksa, diğer kategorilerden ekle
		if ($relatedPosts->count() < 4) {
			$additionalPosts = Blog::with(['category', 'author'])
				->withCount('comments')
				->published()
				->where('id', '!=', $post->id)
				->whereNotIn('id', $relatedPosts->pluck('id'))
				->latest('published_at')
				->limit(4 - $relatedPosts->count())
				->get();
			
			$relatedPosts = $relatedPosts->merge($additionalPosts);
		}

		// Onaylanmış yorumları al (parent yorumlar ve reply'leri ile)
		$comments = $post->comments()
			->approved()
			->whereNull('parent_id')
			->with(['replies' => function($query) {
				$query->approved()->orderBy('created_at', 'asc');
			}])
			->orderBy('created_at', 'desc')
			->get();

		// Render Header Template - En son aktif olan header template'i kullan
		$renderedHeader = null;
		$headerTemplate = HeaderTemplate::where('is_active', true)
			->latest('updated_at')
			->first();
		
		if ($headerTemplate) {
			$templateDefaults = $headerTemplate->default_data ?? [];
			$renderedHeader = TemplateService::replacePlaceholders(
				$headerTemplate->html_content,
				$templateDefaults,
				$post
			);
		}

		// Render Footer Template - En son aktif olan footer template'i kullan
		$renderedFooter = null;
		$footerTemplate = FooterTemplate::where('is_active', true)
			->latest('updated_at')
			->first();
		
		if ($footerTemplate) {
			$templateDefaults = $footerTemplate->default_data ?? [];
			$renderedFooter = TemplateService::replacePlaceholders(
				$footerTemplate->html_content,
				$templateDefaults,
				$post
			);
		}

		return view('blog.show', [
			'settings' => $settings,
			'post' => $post,
			'relatedPosts' => $relatedPosts,
			'comments' => $comments,
			'renderedHeader' => $renderedHeader,
			'renderedFooter' => $renderedFooter,
			'meta' => [
				'title' => method_exists($post, 'translate') ? ($post->translate('meta_title') ?: $post->translate('title')) : ($post->meta_title ?? $post->title),
				'description' => method_exists($post, 'translate') ? ($post->translate('meta_description') ?: $post->translate('excerpt')) : ($post->meta_description ?? $post->excerpt),
				'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
			],
		]);
	}

	public function storeComment(Request $request, string $slug)
	{
		if (!class_exists(Blog::class) || !class_exists(BlogComment::class)) {
			abort(404);
		}

		$post = Blog::published()
			->where('slug', $slug)
			->firstOrFail();

		if (!$post->allow_comments) {
			return redirect()->route('blog.show', $slug)
				->with('error', __('blog.comments_disabled'));
		}

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|email|max:255',
			'content' => 'required|string|min:10',
			'parent_id' => 'nullable|exists:blog_comments,id',
		]);

		if ($validator->fails()) {
			return redirect()->route('blog.show', $slug)
				->withErrors($validator)
				->withInput();
		}

		$comment = BlogComment::create([
			'blog_id' => $post->id,
			'name' => $request->name,
			'email' => $request->email,
			'content' => $request->content,
			'parent_id' => $request->parent_id,
			'status' => 'pending', // Yorumlar onay bekliyor olarak kaydedilir
			'ip_address' => $request->ip(),
			'user_agent' => $request->userAgent(),
		]);

		return redirect()->route('blog.show', $slug)
			->with('success', __('blog.comment_submitted'));
	}
}


