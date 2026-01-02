
@extends('layouts.site', ['headerTemplate' => 'Demo29 Header'])

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', $product->translate('title') ?? 'Ürün Detayı')
@section('meta_description', Str::limit(strip_tags($product->translate('content')), 160))
@php
    $landingData = $product->landing_page_data ?? [];
    $hero = $landingData['hero'] ?? [];
    $features = $landingData['features'] ?? [];
    $howItWorks = $landingData['how_it_works'] ?? [];
    $steps = $howItWorks['steps'] ?? [];
    $video = $landingData['video'] ?? [];
    $faqs = $landingData['faqs'] ?? [];
    $currentLang = app()->getLocale();
    
    // Helper function to get translated value with fallback
    $getTranslated = function($item, $key, $default = '') {
        global $currentLang;
        if (isset($item["{$key}_{$currentLang}"])) {
            return $item["{$key}_{$currentLang}"];
        }
        return $item[$key] ?? $default;
    };
@endphp

@section('content')
    {{-- Hero Section --}}
    @if(!empty($hero))
    <section class="wrapper image-wrapper bg-full bg-image bg-overlay bg-overlay-light-600 [background-size:100%] bg-[center_center] bg-no-repeat bg-scroll relative z-0 before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(255,255,255,.6)]" data-image-src="{{ !empty($hero['background_image']) ? asset($hero['background_image']) : asset('assets/img/photos/bg23.png') }}">
        <div class="container pt-24 xl:pt-32 lg:pt-32 md:pt-32 pb-9">
            <div class="flex flex-wrap mx-0 !mt-[-50px] items-center text-center lg:text-left xl:text-left">
                <div class="xl:w-6/12 lg:w-6/12 xxl:w-5/12 w-full flex-[0_0_auto] max-w-full !relative !mt-[50px]" data-cues="slideInDown" data-group="page-title" data-delay="700">
                    @if(!empty($hero['slogan']))
                    <h1 class="xl:!text-[2.5rem] !text-[calc(1.375rem_+_1.5vw)] font-semibold !leading-[1.15] !mb-4">
                        {!! nl2br(e($hero['slogan'])) !!}
                    </h1>
                    @endif
                    @if(!empty($hero['sub_slogan']))
                    <p class="lead !text-[1.2rem] !leading-[1.5] !font-normal !mb-7">{{ $hero['sub_slogan'] }}</p>
                    @endif
                    <div class="flex justify-center lg:!justify-start xl:!justify-start" data-cues="slideInDown" data-group="page-title-buttons" data-delay="1800">
                        @if(!empty($hero['app_store_link']))
                        <span class="inline-flex"><a href="{{ $hero['app_store_link'] }}" target="_blank" class="!mr-2 inline-block">
                            <img src="{{ asset('assets/img/photos/button-appstore.svg') }}" class="!h-[3rem] !rounded-[0.8rem]" alt="App Store">
                        </a></span>
                        @endif
                        @if(!empty($hero['google_play_link']))
                        <span class="inline-flex"><a href="{{ $hero['google_play_link'] }}" target="_blank" class="inline-block">
                            <img src="{{ asset('assets/img/photos/button-google-play.svg') }}" class="!h-[3rem] !rounded-[0.8rem]" alt="Google Play">
                        </a></span>
                        @endif
                    </div>
                </div>
                <!-- /column -->
                @if(!empty($hero['featured_image']))
                <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full !ml-auto !mb-[-10rem] xxl:!mb-[-15rem] !mt-[50px]" data-cues="slideInDown" data-delay="600">
                    <figure class="m-0 p-0">
                        <img class="w-full max-w-full !h-auto" src="{{ Storage::url($hero['featured_image']) }}" alt="{{ $product->translate('title') }}">
                    </figure>
                </div>
                <!-- /column -->
                @endif
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
        <div class="overflow-hidden" style="z-index:1;">
            <div class="divider !text-[#fefefe] mx-[-0.5rem]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
                    <g fill="currentColor">
                        <polygon points="1440 100 0 100 0 85 1440 0 1440 100" />
                    </g>
                </svg>
            </div>
        </div>
        <!-- /.overflow-hidden -->
    </section>
    <!-- /section -->
    @endif

    {{-- App Features Section --}}
    @if(!empty($features))
    <section class="wrapper !bg-[#ffffff]">
        <div class="container pt-32 xl:pt-40 lg:pt-40 md:pt-40 pb-[4.5rem] xl:pb-24 lg:pb-24 md:pb-24">
            <div class="flex flex-wrap mx-[-15px] !text-center">
                <div class="lg:w-10/12 xl:w-9/12 xxl:w-8/12 flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !relative">
                    <h2 class="!text-[0.8rem] !leading-[1.35] !tracking-[0.02rem] uppercase !text-[#aab0bc] !mb-3">App Features</h2>
                    <h3 class="xl:!text-[2rem] !text-[calc(1.325rem_+_0.9vw)] font-semibold !leading-[1.2] !mb-12 lg:!px-5 xl:!px-0 xxl:!px-6">
                        {{ $product->translate('title') }} makes your experience <span class="text-gradient gradient-7">better</span> for you to have the perfect control.
                    </h3>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="flex flex-wrap mx-[-15px] !mb-40">
                <div class="xxl:w-11/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                    <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-50px] !text-center">
                        @foreach($features as $index => $feature)
                        <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[50px] max-w-full">
                            @if(!empty($feature['icon']))
                            <div class="svg-bg svg-bg-lg !bg-[#fef3e4] !rounded-[0.8rem] !mb-4">
                                @php
                                    $iconPath = public_path('docs/styleguide/_/assets/img/icons/solid/' . $feature['icon'] . '.svg');
                                    $iconUrl = file_exists($iconPath) 
                                        ? asset('docs/styleguide/_/assets/img/icons/solid/' . $feature['icon'] . '.svg')
                                        : null;
                                @endphp
                                @if($iconUrl)
                                    <img src="{{ $iconUrl }}" class="icon-svg solid text-[#343f52] text-navy" alt="{{ $feature['title'] ?? '' }}" style="width: 48px; height: 48px;">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">{{ substr($feature['icon'], 0, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                            @endif
                            @if(!empty($feature['title']))
                            <h4 class="!text-[1rem]">{{ $feature['title'] }}</h4>
                            @endif
                        </div>
                        <!--/column -->
                        @endforeach
                    </div>
                    <!--/.row -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    @endif

    {{-- How It Works Section --}}
    @if(!empty($howItWorks) && !empty($steps))
    <section class="wrapper !bg-[#ffffff]">
        <div class="container pt-32 xl:pt-40 lg:pt-40 md:pt-40 pb-[4.5rem] xl:pb-24 lg:pb-24 md:pb-24">
            <div class="flex flex-wrap mx-[-15px] !text-center">
                <div class="md:w-10/12 lg:w-7/12 xl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !relative">
                    <h2 class="!text-[0.8rem] !tracking-[0.02rem] uppercase !text-[#aab0bc] !mb-3 !leading-[1.35]">How It Works</h2>
                    @if(!empty($howItWorks['download_form_label']))
                    <h3 class="!text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:!text-[2rem] !mb-8 xl:!px-6">
                        {{ $howItWorks['download_form_label'] }}
                    </h3>
                    @endif
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="flex flex-wrap mx-[-15px] lg:!mb-40 xl:!mb-[17.5rem]">
                <div class="xxl:w-11/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                    <div class="flex flex-wrap mx-[-15px] !mt-[-50px] xl:!mt-0 lg:!mt-0 !text-center items-center">
                        @if(!empty($howItWorks['download_image']))
                        <div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !mb-[-2.5rem] lg:!mb-0 xl:!mb-0 !mt-[50px] xl:!mt-0 lg:!mt-0">
                            <figure class="mx-auto">
                                <img src="{{ Storage::url($howItWorks['download_image']) }}" alt="How It Works">
                            </figure>
                        </div>
                        <!-- /column -->
                        @endif
                        <div class="w-full xl:!hidden lg:!hidden !px-[15px] !mt-[50px] xl:!mt-0 lg:!mt-0"></div>
                        <div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full lg:!-order-1 xl:!-order-1 !mt-[50px] xl:!mt-0 lg:!mt-0">
                            @foreach($steps as $index => $step)
                                @if($index < 2)
                                <div class="{{ $index === 0 ? '!mb-8' : '' }}">
                                    <span class="xl:!text-[3rem] !text-[calc(1.425rem_+_2.1vw)] !leading-none !mb-3 font-medium text-gradient gradient-3">{{ str_pad($step['number'] ?? ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    @if(!empty($step['title']))
                                    <h4 class="!text-[1rem]">{{ $step['title'] }}</h4>
                                    @endif
                                    @if(!empty($step['description']))
                                    <p class="!mb-0 xl:!px-7">{{ $step['description'] }}</p>
                                    @endif
                                </div>
                                <!-- /div -->
                                @endif
                            @endforeach
                        </div>
                        <!-- /column -->
                        <div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[50px] xl:!mt-0 lg:!mt-0">
                            @foreach($steps as $index => $step)
                                @if($index >= 2)
                                <div class="{{ $index === 2 ? '!mb-8' : '' }}">
                                    <span class="xl:!text-[3rem] !text-[calc(1.425rem_+_2.1vw)] !leading-none !mb-3 font-medium text-gradient gradient-3">{{ str_pad($step['number'] ?? ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    @if(!empty($step['title']))
                                    <h4 class="!text-[1rem]">{{ $step['title'] }}</h4>
                                    @endif
                                    @if(!empty($step['description']))
                                    <p class="!mb-0 xl:!px-7">{{ $step['description'] }}</p>
                                    @endif
                                </div>
                                <!-- /div -->
                                @endif
                            @endforeach
                        </div>
                        <!-- /column -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    @endif

    {{-- Video Section --}}
    @if(!empty($video['youtube_video_id']))
    <section class="wrapper image-wrapper bg-full bg-image bg-overlay bg-overlay-light-600 bg-content [background-size:100%] bg-[center_center] bg-no-repeat bg-scroll relative z-0 before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(255,255,255,.6)]" data-image-src="{{ !empty($hero['background_image']) ? asset($hero['background_image']) : asset('assets/img/photos/bg23.png') }}">
        <div class="container py-[4.5rem] md:pt-24 lg:pt-0 xl:pt-0 xl:pb-[7rem] lg:pb-[7rem] md:pb-[7rem] !relative" style="z-index: 2;">
            <div class="flex flex-wrap mx-[-15px]">
                <div class="xl:w-11/12 xxl:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                    <div class="lg:!mt-[-10rem] xl:!mt-[-15rem] !mb-[4.5rem] xl:!mb-[6rem] lg:!mb-[6rem] md:!mb-[6rem] !rounded-[0.8rem]">
                        <div class="player relative z-[2] rounded-[0.4rem]">
                            <iframe src="https://www.youtube.com/embed/{{ $video['youtube_video_id'] }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    style="width: 100%; height: 600px; border-radius: 0.4rem;">
                            </iframe>
                        </div>
                    </div>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    @endif

    {{-- FAQ Section --}}
    @if(!empty($faqs))
    <section class="wrapper image-wrapper bg-full bg-image bg-overlay bg-overlay-light-600 bg-content [background-size:100%] bg-[center_center] bg-no-repeat bg-scroll relative z-0 before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(255,255,255,.6)]" data-image-src="{{ !empty($hero['background_image']) ? asset($hero['background_image']) : asset('assets/img/photos/bg23.png') }}">
        <div class="container py-[4.5rem] md:pt-24 lg:pt-0 xl:pt-0 xl:pb-[7rem] lg:pb-[7rem] md:pb-[7rem] !relative" style="z-index: 2;">
            <div class="flex flex-wrap mx-[-15px]">
                <div class="xl:w-11/12 xxl:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                    <div class="!relative">
                        <h2 class="!text-[0.8rem] uppercase !text-[#aab0bc] !mb-3 !text-center !leading-[1.35]">FAQ</h2>
                        <h3 class="!text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:!text-[2rem] !mb-12 lg:!px-8 xl:!px-12 !text-center">
                            If you don't see an <span class="text-gradient gradient-7">answer</span> to your question, you can send us an email from our contact form.
                        </h3>
                    </div>
                    <div class="flex flex-wrap mx-[-15px]">
                        <div class="xl:w-10/12 lg:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                            <div id="accordion-faq" class="accordion-wrapper">
                                @foreach($faqs as $index => $faq)
                                <div class="card accordion-item !mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-faq-{{ $index }}">
                                        <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#e31e24] before:!text-[#e31e24] collapsed" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#accordion-collapse-faq-{{ $index }}" 
                                                aria-expanded="false" 
                                                aria-controls="accordion-collapse-faq-{{ $index }}">
                                            {{ $faq['question'] ?? '' }}
                                        </button>
                                    </div>
                                    <!-- /.card-header -->
                                    <div id="accordion-collapse-faq-{{ $index }}" 
                                         class="collapse" 
                                         aria-labelledby="accordion-heading-faq-{{ $index }}" 
                                         data-bs-target="#accordion-faq">
                                        <div class="card-body flex-[1_1_auto] p-[0_1.25rem_.25rem_2.35rem]">
                                            <p>{!! nl2br(e($faq['answer'] ?? '')) !!}</p>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.collapse -->
                                </div>
                                <!-- /.card -->
                                @endforeach
                            </div>
                            <!-- /.accordion-wrapper -->
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    @endif
@endsection

