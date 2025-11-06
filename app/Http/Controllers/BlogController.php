<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Blog;
use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Services\TemplateService;

class BlogController extends Controller
{
	public function index()
	{
		$settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;
		$posts = class_exists(Blog::class)
			? Blog::with(['category', 'author'])
				->withCount('comments')
				->published()
				->latest('published_at')
				->paginate(12)
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
			'renderedHeader' => $renderedHeader,
			'renderedFooter' => $renderedFooter,
			'meta' => [
				'title' => method_exists($post, 'translate') ? ($post->translate('meta_title') ?: $post->translate('title')) : ($post->meta_title ?? $post->title),
				'description' => method_exists($post, 'translate') ? ($post->translate('meta_description') ?: $post->translate('excerpt')) : ($post->meta_description ?? $post->excerpt),
				'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : null,
			],
		]);
	}
}


