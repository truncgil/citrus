@extends('layouts.site')

@section('content')
<section class="wrapper !bg-[#edf2fc]">
  <div class="container pt-10 pb-36 xl:pt-[4.5rem] lg:pt-[4.5rem] md:pt-[4.5rem] xl:pb-40 lg:pb-40 md:pb-40 !text-center">
    <div class="flex flex-wrap mx-[-15px]">
      <div class="md:w-10/12 lg:w-10/12 xl:w-8/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        <div class="post-header !mb-[.9rem]">
          @if($post->category)
            <div class="inline-flex uppercase !tracking-[0.02rem] text-[0.7rem] font-bold !text-[#aab0bc] !mb-[0.4rem] text-line relative align-top !pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#e31e24]">
              <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="hover" rel="category">{{ $post->category->name }}</a>
            </div>
          @endif
          <!-- /.post-category -->
          <h1 class="!text-[calc(1.365rem_+_1.38vw)] font-bold !leading-[1.2] xl:!text-[2.4rem] !mb-4">
            {{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}
          </h1>
          <ul class="!text-[0.8rem] !text-[#aab0bc] m-0 p-0 list-none !mb-5">
            <li class="post-date inline-block">
              <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
              <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            </li>
            @if($post->author)
              <li class="post-author inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0_.4rem] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                <a class="!text-[0.8rem] !text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="#">
                  <i class="uil uil-user pr-[0.2rem] align-[-.05rem] before:content-['\ed6f']"></i>
                  <span>{{ __('blog.by') }} {{ $post->author->name }}</span>
                </a>
              </li>
            @endif
            <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0_.4rem] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
              <a class="!text-[0.8rem] !text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="#comments">
                <i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>
                <span>{{ $post->comments_count ?? 0 }} {{ __('blog.comments') }}</span>
              </a>
            </li>
          </ul>
          <!-- /.post-meta -->
        </div>
        <!-- /.post-header -->
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</section>

<section class="wrapper !bg-[#ffffff]">
  <div class="container !pb-[4.5rem] xl:!pb-24 lg:!pb-24 md:!pb-24">
    <div class="flex flex-wrap mx-[-15px]">
      <div class="xl:w-10/12 lg:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        <div class="blog single !mt-[-7rem]">
          <div class="card">
            @if($post->featured_image_url)
              <figure class="card-img-top">
                <img src="{{ $post->featured_image_url }}" alt="{{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}">
              </figure>
            @endif
            <div class="card-body flex-[1_1_auto] p-[40px] xl:!p-[2.8rem_3rem_2.8rem] lg:!p-[2.8rem_3rem_2.8rem] md:!p-[2.8rem_3rem_2.8rem]">
              <div class="classic-view">
                <article class="post !mb-8">
                  <div class="relative !mb-5">
                    <div class="post-content">
                      {!! method_exists($post, 'translate') ? $post->translate('content') : ($post->content ?? '') !!}
                    </div>
                  </div>
                  <!-- /.post-content -->
                  <div class="post-footer xl:!flex xl:!flex-row xl:!justify-between lg:!flex lg:!flex-row lg:!justify-between md:!flex md:!flex-row md:!justify-between !items-center !mt-8">
                    @if($post->tags && count($post->tags) > 0)
                      <div>
                        <ul class="pl-0 list-none tag-list !mb-0">
                          @foreach($post->tags as $tag)
                            <li class="!mt-0 !mb-[0.45rem] !mr-[0.2rem] inline-block">
                              <a href="{{ route('blog.index', ['tag' => $tag]) }}" class="btn btn-soft-ash btn-sm !rounded-[50rem] flex items-center hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,.05)] before:not-italic before:content-['#'] before:font-normal before:!pr-[0.2rem]">
                                {{ $tag }}
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                    <div class="!mb-0 xl:!mb-2 lg:!mb-2 md:!mb-2">
                      <div class="dropdown share-dropdown btn-group">
                        <button class="btn btn-sm btn-red !text-white !bg-[#e2626b] border-[#e2626b] hover:text-white hover:bg-[#e2626b] hover:!border-[#e2626b] active:text-white active:bg-[#e2626b] active:border-[#e2626b] disabled:text-white disabled:bg-[#e2626b] disabled:border-[#e2626b] !rounded-[50rem] btn-icon btn-icon-start dropdown-toggle !mb-0 !mr-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="uil uil-share-alt !mr-[0.3rem] text-[0.8rem] before:content-['\ecb0']"></i> {{ __('blog.share') }}
                        </button>
                        <div class="dropdown-menu !shadow-[rgba(30,34,40,0.06)_0px_0px_25px_0px]">
                          <a class="dropdown-item text-[0.7rem] !p-[.25rem_1.15rem]" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode(method_exists($post, 'translate') ? $post->translate('title') : $post->title) }}" target="_blank">
                            <i class="uil uil-twitter w-4 text-[0.8rem] pr-[0.4rem] align-[-.1rem] before:content-['\ed59']"></i>Twitter
                          </a>
                          <a class="dropdown-item text-[0.7rem] !p-[.25rem_1.15rem]" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <i class="uil uil-facebook-f w-4 text-[0.8rem] pr-[0.4rem] align-[-.1rem] before:content-['\eae2']"></i>Facebook
                          </a>
                          <a class="dropdown-item text-[0.7rem] !p-[.25rem_1.15rem]" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <i class="uil uil-linkedin w-4 text-[0.8rem] pr-[0.4rem] align-[-.1rem] before:content-['\ebd1']"></i>Linkedin
                          </a>
                        </div>
                        <!--/.dropdown-menu -->
                      </div>
                      <!--/.share-dropdown -->
                    </div>
                  </div>
                  <!-- /.post-footer -->
                </article>
                <!-- /.post -->
              </div>
              <!-- /.classic-view -->
              <hr>
              @if($post->author)
                <div class="author-info xl:!flex lg:!flex md:!flex items-center !mb-3">
                  <div class="flex items-center">
                    <figure class="w-12 h-12 !relative !mr-4 rounded-[100%]">
                      @if($post->author->avatar)
                        <img class="rounded-[50%]" alt="image" src="{{ asset('storage/' . $post->author->avatar) }}">
                      @else
                        <img class="rounded-[50%]" alt="image" src="{{ asset('assets/img/avatars/u5.jpg') }}">
                      @endif
                    </figure>
                    <div>
                      <h6>
                        <a href="#" class="!text-[#343f52] hover:!text-[#e31e24]">{{ $post->author->name }}</a>
                      </h6>
                      <span class="!text-[0.75rem] !text-[#aab0bc] m-0 p-0 list-none">{{ $post->author->role ?? __('blog.author') }}</span>
                    </div>
                  </div>
                  <div class="!mt-3 xl:!mt-0 lg:!mt-0 md:!mt-0 !ml-auto">
                    <a href="{{ route('blog.index', ['author' => $post->author->id]) }}" class="btn btn-sm btn-soft-ash !rounded-[50rem] btn-icon btn-icon-start !mb-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">
                      <i class="uil uil-file-alt !mr-[0.3rem] before:content-['\eaec'] text-[.8rem]"></i> {{ __('blog.all_posts') }}
                    </a>
                  </div>
                </div>
                <!-- /.author-info -->
                <p>{{ method_exists($post, 'translate') ? $post->translate('excerpt') : ($post->excerpt ?? '') }}</p>
                
                @if($post->author->social_links ?? false)
                  <nav class="nav social">
                    @if(isset($post->author->social_links['twitter']))
                      <a class="text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ $post->author->social_links['twitter'] }}" target="_blank">
                        <i class="text-[1rem] !text-[#5daed5] before:content-['\ed59'] uil uil-twitter"></i>
                      </a>
                    @endif
                    @if(isset($post->author->social_links['facebook']))
                      <a class="text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ $post->author->social_links['facebook'] }}" target="_blank">
                        <i class="text-[1rem] !text-[#4470cf] before:content-['\eae2'] uil uil-facebook-f"></i>
                      </a>
                    @endif
                    @if(isset($post->author->social_links['dribbble']))
                      <a class="text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ $post->author->social_links['dribbble'] }}" target="_blank">
                        <i class="text-[1rem] !text-[#e94d88] before:content-['\eaa2'] uil uil-dribbble"></i>
                      </a>
                    @endif
                    @if(isset($post->author->social_links['instagram']))
                      <a class="text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ $post->author->social_links['instagram'] }}" target="_blank">
                        <i class="text-[1rem] !text-[#d53581] before:content-['\eb9c'] uil uil-instagram"></i>
                      </a>
                    @endif
                    @if(isset($post->author->social_links['youtube']))
                      <a class="text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ $post->author->social_links['youtube'] }}" target="_blank">
                        <i class="text-[1rem] !text-[#c8312b] before:content-['\edb5'] uil uil-youtube"></i>
                      </a>
                    @endif
                  </nav>
                  <!-- /.social -->
                @endif
              @endif
              <hr>
              @if($relatedPosts && $relatedPosts->count() > 0)
                <h3 class="!mb-6">{{ __('blog.you_might_also_like') }}</h3>
                <div class="swiper-container blog grid-view !mb-24 relative z-10" data-margin="30" data-dots="true" data-items-md="2" data-items-xs="1">
                  <div class="swiper">
                    <div class="swiper-wrapper">
                      @foreach($relatedPosts as $relatedPost)
                        @php
                          $relatedTitle = method_exists($relatedPost, 'translate') ? $relatedPost->translate('title') : $relatedPost->title;
                          $relatedCategoryName = $relatedPost->category ? $relatedPost->category->name : '';
                          $relatedImageUrl = $relatedPost->featured_image ? asset('storage/' . $relatedPost->featured_image) : asset('assets/img/photos/b4.jpg');
                          $relatedUrl = route('blog.show', $relatedPost->slug);
                          $relatedDate = $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y');
                          $relatedCommentCount = $relatedPost->comments_count ?? 0;
                        @endphp
                        <div class="swiper-slide">
                          <article>
                            <figure class="overlay overlay-1 hover-scale group rounded !mb-5">
                              <a href="{{ $relatedUrl }}">
                                <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="{{ $relatedImageUrl }}" alt="{{ $relatedTitle }}">
                                <span class="bg"></span>
                              </a>
                              <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                                <h5 class="from-top !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">{{ __('blog.read_more') }}</h5>
                              </figcaption>
                            </figure>
                            <div class="post-header !mb-[.9rem]">
                              @if($relatedPost->category)
                                <div class="inline-flex !mb-[.4rem] uppercase !tracking-[0.02rem] text-[0.7rem] font-bold !text-[#aab0bc] relative align-top !pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#e31e24]">
                                  <a href="{{ route('blog.index', ['category' => $relatedPost->category->slug]) }}" class="hover" rel="category">{{ $relatedCategoryName }}</a>
                                </div>
                              @endif
                              <!-- /.post-category -->
                              <h2 class="post-title h3 !mt-1 !mb-3">
                                <a class="!text-[#343f52] hover:!text-[#e31e24]" href="{{ $relatedUrl }}">{{ $relatedTitle }}</a>
                              </h2>
                            </div>
                            <!-- /.post-header -->
                            <div class="post-footer">
                              <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none !mb-0">
                                <li class="post-date inline-block">
                                  <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                                  <span>{{ $relatedDate }}</span>
                                </li>
                                <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]">
                                  <a class="!text-[#aab0bc] hover:!text-[#e31e24] hover:!border-[#e31e24]" href="{{ $relatedUrl }}#comments">
                                    <i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>{{ $relatedCommentCount }}
                                  </a>
                                </li>
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
                  <div class="swiper-controls">
                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"></div>
                  </div>
                </div>
                <!-- /.swiper-container -->
              @endif
              <hr>
              @if($post->allow_comments)
                <div id="comments" class="relative !m-0">
                  <h3 class="!mb-6">{{ $comments->count() }} {{ __('blog.comments') }}</h3>
                  @if($comments->count() > 0)
                    <ol id="singlecomments" class="commentlist m-0 p-0 list-none">
                      @foreach($comments as $comment)
                        <li class="comment !mt-8">
                          <div class="comment-header xl:!flex lg:!flex md:!flex items-center !mb-[.5rem]">
                            <div class="flex items-center">
                              <figure class="w-12 h-12 !relative !mr-4 rounded-[100%]">
                                <img class="rounded-[50%]" alt="image" src="{{ asset('assets/img/avatars/u1.jpg') }}">
                              </figure>
                              <div>
                                <h6 class="m-0 !mb-[0.2rem]">
                                  <a href="#" class="!text-[#343f52] hover:!text-[#e31e24]">{{ $comment->name }}</a>
                                </h6>
                                <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none">
                                  <li>
                                    <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                                    {{ $comment->created_at->format('d M Y') }}
                                  </li>
                                </ul>
                                <!-- /.post-meta -->
                              </div>
                              <!-- /div -->
                            </div>
                            <!-- /div -->
                            <div class="!mt-3 xl:!mt-0 lg:!mt-0 md:!mt-0 !ml-auto">
                              <a href="#comment-form" class="btn btn-soft-ash btn-sm !rounded-[50rem] btn-icon btn-icon-start !mb-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]" onclick="document.getElementById('parent_id').value = {{ $comment->id }}">
                                <i class="uil uil-comments !mr-[0.3rem] before:content-['\ea56'] text-[.8rem]"></i> {{ __('blog.reply') }}
                              </a>
                            </div>
                            <!-- /div -->
                          </div>
                          <!-- /.comment-header -->
                          <p>{{ $comment->content }}</p>
                          @if($comment->replies && $comment->replies->count() > 0)
                            <ul class="children">
                              @foreach($comment->replies as $reply)
                                <li class="comment !mt-8">
                                  <div class="comment-header xl:!flex lg:!flex md:!flex items-center !mb-[.5rem]">
                                    <div class="flex items-center">
                                      <figure class="w-12 h-12 !relative !mr-4 rounded-[100%]">
                                        <img class="rounded-[50%]" alt="image" src="{{ asset('assets/img/avatars/u3.jpg') }}">
                                      </figure>
                                      <div>
                                        <h6 class="m-0 !mb-[0.2rem]">
                                          <a href="#" class="!text-[#343f52] hover:!text-[#e31e24]">{{ $reply->name }}</a>
                                        </h6>
                                        <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none">
                                          <li>
                                            <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                                            {{ $reply->created_at->format('d M Y') }}
                                          </li>
                                        </ul>
                                        <!-- /.post-meta -->
                                      </div>
                                      <!-- /div -->
                                    </div>
                                    <!-- /div -->
                                    <div class="!mt-3 xl:!mt-0 lg:!mt-0 md:!mt-0 !ml-auto">
                                      <a href="#comment-form" class="btn btn-soft-ash btn-sm !rounded-[50rem] btn-icon btn-icon-start !mb-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]" onclick="document.getElementById('parent_id').value = {{ $comment->id }}">
                                        <i class="uil uil-comments !mr-[0.3rem] before:content-['\ea56'] text-[.8rem]"></i> {{ __('blog.reply') }}
                                      </a>
                                    </div>
                                    <!-- /div -->
                                  </div>
                                  <!-- /.comment-header -->
                                  <p>{{ $reply->content }}</p>
                                  @if($reply->replies && $reply->replies->count() > 0)
                                    <ul class="children">
                                      @foreach($reply->replies as $nestedReply)
                                        <li class="comment !mt-8">
                                          <div class="comment-header xl:!flex lg:!flex md:!flex items-center !mb-[.5rem]">
                                            <div class="flex items-center">
                                              <figure class="w-12 h-12 !relative !mr-4 rounded-[100%]">
                                                <img class="rounded-[50%]" alt="image" src="{{ asset('assets/img/avatars/u2.jpg') }}">
                                              </figure>
                                              <div>
                                                <h6 class="m-0 !mb-[0.2rem]">
                                                  <a href="#" class="!text-[#343f52] hover:!text-[#e31e24]">{{ $nestedReply->name }}</a>
                                                </h6>
                                                <ul class="!text-[0.7rem] !text-[#aab0bc] m-0 p-0 list-none">
                                                  <li>
                                                    <i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i>
                                                    {{ $nestedReply->created_at->format('d M Y') }}
                                                  </li>
                                                </ul>
                                                <!-- /.post-meta -->
                                              </div>
                                              <!-- /div -->
                                            </div>
                                            <!-- /div -->
                                            <div class="!mt-3 xl:!mt-0 lg:!mt-0 md:!mt-0 !ml-auto">
                                              <a href="#comment-form" class="btn btn-soft-ash btn-sm !rounded-[50rem] btn-icon btn-icon-start !mb-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]" onclick="document.getElementById('parent_id').value = {{ $comment->id }}">
                                                <i class="uil uil-comments !mr-[0.3rem] before:content-['\ea56'] text-[.8rem]"></i> {{ __('blog.reply') }}
                                              </a>
                                            </div>
                                            <!-- /div -->
                                          </div>
                                          <!-- /.comment-header -->
                                          <p>{{ $nestedReply->content }}</p>
                                        </li>
                                      @endforeach
                                    </ul>
                                  @endif
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                    </ol>
                  @endif
                </div>
                <!-- /#comments -->
                <hr>
                <h3 class="!mb-3">{{ __('blog.share_thoughts') }}</h3>
                <p class="!mb-7">{{ __('blog.comment_form_description') }}</p>
                @if(session('success'))
                  <div class="alert alert-success !mb-4">
                    {{ session('success') }}
                  </div>
                @endif
                @if(session('error'))
                  <div class="alert alert-danger !mb-4">
                    {{ session('error') }}
                  </div>
                @endif
                <form class="comment-form" id="comment-form" method="POST" action="{{ route('blog.comment.store', $post->slug) }}">
                  @csrf
                  <input type="hidden" name="parent_id" id="parent_id" value="">
                  <div class="form-floating relative !mb-4">
                    <input type="text" class="form-control relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus-visible:!border-[rgba(63,120,224,0.5)] placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" id="c-name" name="name" value="{{ old('name') }}" required>
                    <label class="inline-block !text-[#959ca9] text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope" for="c-name">{{ __('blog.name') }} *</label>
                  </div>
                  <div class="form-floating relative !mb-4">
                    <input type="email" class="form-control relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus-visible:!border-[rgba(63,120,224,0.5)] placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" id="c-email" name="email" value="{{ old('email') }}" required>
                    <label class="inline-block !text-[#959ca9] text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope" for="c-email">{{ __('blog.email') }} *</label>
                  </div>
                  <div class="form-floating relative !mb-4">
                    <textarea name="content" class="form-control relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus-visible:!border-[rgba(63,120,224,0.5)] placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" style="height: 150px" required>{{ old('content') }}</textarea>
                    <label class="inline-block !text-[#959ca9] text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">{{ __('blog.comment') }} *</label>
                  </div>
                  @if($errors->any())
                    <div class="alert alert-danger !mb-4">
                      <ul class="!mb-0">
                        @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  <button type="submit" class="btn btn-primary !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !rounded-[50rem] !mb-0 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">
                    {{ __('blog.submit') }}
                  </button>
                </form>
                <!-- /.comment-form -->
              @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.blog -->
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</section>
@endsection
