@props(['data' => []])

<section class="wrapper overflow-hidden">
  <div class="container pt-36 xl:pt-[12.5rem] lg:pt-[12.5rem] md:pt-[12.5rem] pb-24 xl:pb-32 lg:pb-32 md:pb-32 !text-center !relative">
    @if(!empty($data['background_image']))
    <div class="absolute" style="top: -12%; left: 50%; transform: translateX(-50%);" data-cue="fadeIn">
      <img src="{{ asset($data['background_image']) }}" alt="background">
    </div>
    @endif
    
    <div class="flex flex-wrap mx-[-15px] !relative">
      <div class="lg:w-8/12 xl:w-8/12 xxl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !relative">
        @if(!empty($data['badge']))
        <h2 class="text-[0.8rem] tracking-[0.02rem] uppercase text-[#e31e24] !mb-3 !leading-[1.35]">{{ $data['badge'] }}</h2>
        @endif
        
        @if(!empty($data['title']))
        <h1 class="!text-[calc(1.445rem_+_2.34vw)] font-semibold !leading-[1.15] xl:!text-[3.2rem] !mb-6">
          {!! $data['title'] !!}
        </h1>
        @endif
        
        @if(!empty($data['subtitle']))
        <p class="lead text-[1.2rem] !leading-[1.6] !mb-8">{{ $data['subtitle'] }}</p>
        @endif
        
        <div class="flex justify-center flex-wrap gap-3">
          @if(!empty($data['primary_button_text']))
          <a href="{{ $data['primary_button_url'] ?? '#' }}" 
             class="btn btn-lg btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] !rounded-[0.8rem]">
            {{ $data['primary_button_text'] }}
          </a>
          @endif
          
          @if(!empty($data['secondary_button_text']))
          <a href="{{ $data['secondary_button_url'] ?? '#' }}" 
             class="btn btn-lg btn-outline-grape !text-[#e31e24] !border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] !rounded-[0.8rem]">
            {{ $data['secondary_button_text'] }}
          </a>
          @endif
        </div>
      </div>
    </div>
    
    @if(!empty($data['hero_image']))
    <div class="!mt-10">
      <img class="max-w-full h-auto !relative m-[0_auto]" src="{{ asset($data['hero_image']) }}" alt="hero">
    </div>
    @endif
  </div>
</section>

