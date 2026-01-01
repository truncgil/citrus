@php
    // Blog modelinden published içerikleri çek
    $blogs = \App\Models\Blog::with(['category', 'author'])
        ->withCount('comments')
        ->published()
        ->latest('published_at')
        ->limit(6)
        ->get();
@endphp

<section class="wrapper !bg-[#ffffff] ">
    <div class="container pt-20 xl:pt-28 lg:pt-28 md:pt-28 pb-16 xl:pb-20 lg:pb-20 md:pb-20">
      
      @if($blogs->count() > 0)
        <div class="swiper-container blog grid-view !mb-6" data-margin="30" data-dots="true" data-items-xl="3" data-items-md="2" data-items-xs="1">
          <div class="swiper">
            <div class="swiper-wrapper">
              @foreach($blogs as $blog)
                @php
                  $title = method_exists($blog, 'translate') ? $blog->translate('title') : $blog->title;
                  $excerpt = method_exists($blog, 'translate') ? $blog->translate('excerpt') : ($blog->excerpt ?? '');
                  $categoryName = $blog->category ? ($blog->category->name ?? '') : '';
                  $publishedDate = $blog->published_at ? $blog->published_at->format('d M Y') : '';
                  $imageUrl = $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/img/photos/b4.jpg');
                  $blogUrl = route('blog.show', $blog->slug);
                  $commentCount = $blog->comments_count ?? 0;
                @endphp
                
                <div class="swiper-slide">
                  <article>
                    <figure class="overlay overlay-1 hover-scale group rounded !mb-5">
                      <a href="{{ $blogUrl }}">
                        <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="{{ $imageUrl }}" alt="{{ $title }}">
                      </a>
                      <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                        <h5 class="from-top  !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">{{ __('blog.read_more', ['default' => 'Read More']) }}</h5>
                      </figcaption>
                    </figure>
                    <div class="post-header">
                      @if($categoryName)
                        <div class="inline-flex !mb-[.4rem] uppercase !tracking-[0.02rem] text-[0.7rem] font-bold !text-[#aab0bc] relative align-top !pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#e31e24]">
                          <a href="{{ route('blog.index', ['category' => $blog->category->slug ?? '']) }}" class="hover" rel="category">{{ $categoryName }}</a>
                        </div>
                      @endif
                      <!-- /.post-category -->
                      <h2 class="post-title h3 !mt-1 !mb-3">
                        <a class="!text-[#343f52] hover:!text-[#e31e24]" href="{{ $blogUrl }}">{{ $title }}</a>
                      </h2>
                    </div>
                    <!-- /.post-header -->
                    <div class="post-footer">
                      <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none  !mb-0">
                        @if($publishedDate)
                          <li class="post-date inline-block">
                            <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                            <span>{{ $publishedDate }}</span>
                          </li>
                        @endif
                        @if($blog->allow_comments)
                          <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                            <a class="!text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="{{ $blogUrl }}#comments">
                              <i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>{{ $commentCount }}
                            </a>
                          </li>
                        @endif
                      </ul>
                      <!-- /.post-meta -->
                    </div>
                    <!-- /.post-footer -->
                  </article>
                  <!-- /article -->
                </div>
                <!--/.swiper-slide -->
              @endforeach
            </div>
            <!--/.swiper-wrapper -->
          </div>
          <!-- /.swiper -->
        </div>
        <!-- /.swiper-container -->
      @else
        <div class="text-center py-12">
          <p class="text-[#aab0bc]">{{ __('blog.empty', ['default' => 'No blog posts available at the moment.']) }}</p>
        </div>
      @endif
    </div>
</section>
<!-- /section -->