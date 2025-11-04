@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? 'overflow-hidden' }}">
  <div class="container pt-24 xl:pt-32 lg:pt-32 md:pt-32 pb-24 xl:pb-32 lg:pb-32 md:pb-32 !text-center !relative">
    @if(!empty($data['background_image']))
    <div class="absolute" style="top: -7%; left: 50%; transform: translateX(-50%);">
      <img src="{{ asset($data['background_image']) }}" alt="background">
    </div>
    @endif
    
    <div class="flex flex-wrap mx-[-15px] !relative">
      <div class="lg:w-10/12 xl:w-9/12 xxl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        @if(!empty($data['icon']))
        <div class="!mb-5">
          <img class="m-[0_auto] !w-[4rem] !h-[4rem]" src="{{ asset($data['icon']) }}" alt="icon">
        </div>
        @endif
        
        @if(!empty($data['title']))
        <h1 class="font-semibold !leading-[1.15] xl:!text-[3.2rem] !text-[calc(1.445rem_+_2.34vw)] !mb-5">
          {!! $data['title'] !!}
        </h1>
        @endif
        
        @if(!empty($data['subtitle']))
        <p class="lead !text-[1.2rem] !leading-[1.6] !mb-8 lg:!px-14 xl:!px-[4.5rem] xxl:!px-10">
          {{ $data['subtitle'] }}
        </p>
        @endif
        
        @if(!empty($data['button_text']))
        <div class="flex justify-center">
          <span>
            <a href="{{ $data['button_url'] ?? '#' }}" 
               class="btn btn-lg btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] btn-icon btn-icon-end !rounded-[0.8rem]">
              {{ $data['button_text'] }}
              @if(!empty($data['button_icon']))
              <i class="{{ $data['button_icon'] }}"></i>
              @endif
            </a>
          </span>
        </div>
        @endif
      </div>
    </div>
    
    @if(!empty($data['cta_image']))
    <div class="container !text-center !mt-10">
      <img class="max-w-full h-auto !relative m-[0_auto]" style="z-index: 2;" src="{{ asset($data['cta_image']) }}" alt="cta">
    </div>
    @endif
  </div>
</section>

