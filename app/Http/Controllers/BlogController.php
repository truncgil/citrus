<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Post;

class BlogController extends Controller
{
	public function index()
	{
		$settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;
		$posts = class_exists(Post::class)
			? Post::query()->where('status', 'published')->latest('published_at')->paginate(12)
			: collect();

		return view('blog.index', [
			'settings' => $settings,
			'posts' => $posts,
			'meta' => [
				'title' => __('blog.meta-index-title'),
				'description' => __('blog.meta-index-description'),
			],
		]);
	}

	public function show(string $slug)
	{
		$settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;
		if (!class_exists(Post::class)) {
			abort(404);
		}
		$post = Post::query()->where('slug', $slug)->where('status', 'published')->firstOrFail();

		return view('blog.show', [
			'settings' => $settings,
			'post' => $post,
			'meta' => [
				'title' => method_exists($post, 'translate') ? ($post->translate('meta_title') ?: $post->translate('title')) : ($post->meta_title ?? $post->title),
				'description' => method_exists($post, 'translate') ? ($post->translate('meta_description') ?: $post->translate('excerpt')) : ($post->meta_description ?? $post->excerpt),
				'image' => $post->featured_image ?? null,
			],
		]);
	}
}


