@extends('layouts.site')

@section('content')
<section class="wrapper !bg-[#edf2fc]">
  <div class="container !pt-10 !pb-36 xl:!pt-[4.5rem] lg:!pt-[4.5rem] md:!pt-[4.5rem] xl:!pb-40 lg:!pb-40 md:!pb-40 !text-center">
    <div class="flex flex-wrap mx-[-15px]">
      <div class="md:w-7/12 lg:w-6/12 xl:w-5/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        <h1 class="!text-[calc(1.365rem_+_1.38vw)] font-bold !leading-[1.2] xl:!text-[2.4rem] !mb-3">{{ __('blog.meta-index-title') }}</h1>
        <p class="lead lg:!px-[1.25rem] xl:!px-[1.25rem] xxl:!px-[2rem] !leading-[1.65] text-[0.9rem] font-medium">{{ __('blog.meta-index-description') }}</p>
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</section>
<!-- /section -->

<div class="wrapper !bg-[#ffffff]">
  <div class="container !pb-[4.5rem] xl:!pb-24 lg:!pb-24 md:!pb-24">
    <div class="flex flex-wrap mx-[-15px]">
      <div class="xl:w-10/12 lg:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        <div class="blog classic-view !mt-[-7rem]">
          @forelse($posts as $index => $post)
            @php
              $title = method_exists($post, 'translate') ? $post->translate('title') : $post->title;
              $excerpt = method_exists($post, 'translate') ? $post->translate('excerpt') : ($post->excerpt ?? '');
              $categoryName = $post->category ? $post->category->name : '';
              $categorySlug = $post->category ? $post->category->slug : '';
              $publishedDate = $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y');
              $imageUrl = $post->featured_image ? asset('storage/' . $post->featured_image) : asset('assets/img/photos/b1.jpg');
              $blogUrl = route('blog.show', $post->slug);
              $commentCount = $post->comments_count ?? 0;
              $authorName = $post->author ? $post->author->name : '';
            @endphp

            @if($index < 3)
              {{-- İlk 3 blog yazısı classic-view formatında --}}
              <article class="post !mb-8">
                <div class="card">
                  @if($post->featured_image_url)
                    <figure class="card-img-top overlay overlay-1 hover-scale group">
                      <a class="!text-[#343f52] hover:!text-[#e31e24]" href="{{ $blogUrl }}">
                        <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="{{ $imageUrl }}" alt="{{ $title }}">
                      </a>
                      <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                        <h5 class="from-top !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">{{ __('blog.read_more') }}</h5>
                      </figcaption>
                    </figure>
                  @endif
                  <div class="card-body flex-[1_1_auto] p-[40px] xl:!p-[2rem_2.5rem_1.25rem] lg:!p-[2rem_2.5rem_1.25rem] md:!p-[2rem_2.5rem_1.25rem] max-md:pb-4">
                    <div class="post-header !mb-[.9rem]">
                      @if($categoryName)
                        <div class="inline-flex !mb-[.4rem] uppercase !tracking-[0.02rem] text-[0.7rem] font-bold !text-[#aab0bc] relative align-top !pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#e31e24]">
                          <a href="{{ route('blog.index', ['category' => $categorySlug]) }}" class="hover" rel="category">{{ $categoryName }}</a>
                        </div>
                      @endif
                      <!-- /.post-category -->
                      <h2 class="post-title !mt-1 !leading-[1.35] !mb-0">
                        <a class="!text-[#343f52] hover:!text-[#e31e24]" href="{{ $blogUrl }}">{{ $title }}</a>
                      </h2>
                    </div>
                    <!-- /.post-header -->
                    <div class="!relative">
                      <p>{{ $excerpt }}</p>
                    </div>
                    <!-- /.post-content -->
                  </div>
                  <!--/.card-body -->
                  <div class="card-footer xl:!p-[1.25rem_2.5rem_1.25rem] lg:!p-[1.25rem_2.5rem_1.25rem] md:!p-[1.25rem_2.5rem_1.25rem] p-[18px_40px]">
                    <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none flex !mb-0">
                      <li class="post-date inline-block">
                        <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                        <span>{{ $publishedDate }}</span>
                      </li>
                      @if($authorName)
                        <li class="post-author inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                          <a class="!text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="{{ route('blog.index', ['author' => $post->author_id]) }}">
                            <i class="uil uil-user pr-[0.2rem] align-[-.05rem] before:content-['\ed6f']"></i>
                            <span>{{ __('blog.by') }} {{ $authorName }}</span>
                          </a>
                        </li>
                      @endif
                      @if($post->allow_comments)
                        <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                          <a class="!text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="{{ $blogUrl }}#comments">
                            <i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>
                            <span>{{ $commentCount }} {{ __('blog.comments') }}</span>
                          </a>
                        </li>
                      @endif
                    </ul>
                    <!-- /.post-meta -->
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </article>
              <!-- /.post -->
            @endif
          @empty
            <div class="text-center py-12">
              <p class="text-[#aab0bc]">{{ __('blog.empty') }}</p>
            </div>
          @endforelse
        </div>
        <!-- /.blog -->
        
        @if($posts->count() > 3)
          <div class="blog itemgrid grid-view">
            <div class="flex flex-wrap mx-[-15px] isotope xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-40px] !mb-8">
              @foreach($posts as $index => $post)
                @if($index >= 3)
                  @php
                    $title = method_exists($post, 'translate') ? $post->translate('title') : $post->title;
                    $excerpt = method_exists($post, 'translate') ? $post->translate('excerpt') : ($post->excerpt ?? '');
                    $categoryName = $post->category ? $post->category->name : '';
                    $categorySlug = $post->category ? $post->category->slug : '';
                    $publishedDate = $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y');
                    $imageUrl = $post->featured_image ? asset('storage/' . $post->featured_image) : asset('assets/img/photos/b4.jpg');
                    $blogUrl = route('blog.show', $post->slug);
                    $commentCount = $post->comments_count ?? 0;
                  @endphp
                  
                  <article class="item post xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] !px-[15px] max-w-full">
                    <div class="card">
                      <figure class="card-img-top overlay overlay-1 hover-scale group">
                        <a href="{{ $blogUrl }}">
                          <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="{{ $imageUrl }}" alt="{{ $title }}">
                        </a>
                        <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                          <h5 class="from-top !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">{{ __('blog.read_more') }}</h5>
                        </figcaption>
                      </figure>
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:!p-[1.75rem_1.75rem_1rem_1.75rem] lg:!p-[1.75rem_1.75rem_1rem_1.75rem] md:!p-[1.75rem_1.75rem_1rem_1.75rem] max-md:pb-4">
                        <div class="post-header !mb-[.9rem]">
                          @if($categoryName)
                            <div class="inline-flex !mb-[.4rem] uppercase !tracking-[0.02rem] text-[0.7rem] font-bold !text-[#aab0bc] relative align-top !pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#e31e24]">
                              <a href="{{ route('blog.index', ['category' => $categorySlug]) }}" class="hover" rel="category">{{ $categoryName }}</a>
                            </div>
                          @endif
                          <!-- /.post-category -->
                          <h2 class="post-title h3 !mt-1 !mb-3">
                            <a class="!text-[#343f52] hover:!text-[#e31e24]" href="{{ $blogUrl }}">{{ $title }}</a>
                          </h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="!relative">
                          <p>{{ \Illuminate\Support\Str::limit($excerpt, 120) }}</p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:!p-[1.25rem_1.75rem_1.25rem] lg:!p-[1.25rem_1.75rem_1.25rem] md:!p-[1.25rem_1.75rem_1.25rem] p-[18px_40px]">
                        <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none flex !mb-0">
                          <li class="post-date inline-block">
                            <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                            <span>{{ $publishedDate }}</span>
                          </li>
                          @if($post->allow_comments)
                            <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                              <a class="!text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="{{ $blogUrl }}#comments">
                                <i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>{{ $commentCount }}
                              </a>
                            </li>
                          @endif
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                  <!-- /.post -->
                @endif
              @endforeach
            </div>
            <!-- /.isotope -->
          </div>
          <!-- /.blog itemgrid -->
        @endif

        {{-- Pagination --}}
        @if(method_exists($posts, 'links') && $posts->hasPages())
          <div class="mt-8">
            {{ $posts->links() }}
          </div>
        @endif
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
@endsection
