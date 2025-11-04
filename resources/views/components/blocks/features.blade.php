@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#f0f0f8]' }}">
  <div class="container py-24 xl:py-32 lg:py-32 md:py-32">
    @if(!empty($data['section_title']) || !empty($data['section_subtitle']))
    <div class="flex flex-wrap mx-[-15px] !mb-12 !text-center">
      <div class="md:w-10/12 lg:w-9/12 xl:w-8/12 xxl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
        @if(!empty($data['section_badge']))
        <h2 class="text-[0.8rem] tracking-[0.02rem] uppercase text-[#e31e24] !mb-3 !leading-[1.35]">{{ $data['section_badge'] }}</h2>
        @endif
        
        @if(!empty($data['section_title']))
        <h2 class="!text-[calc(1.345rem_+_1.14vw)] font-bold !leading-[1.2] xl:!text-[2.2rem] !mb-3">
          {{ $data['section_title'] }}
        </h2>
        @endif
        
        @if(!empty($data['section_subtitle']))
        <p class="lead text-[1.05rem] !leading-[1.6]">{{ $data['section_subtitle'] }}</p>
        @endif
      </div>
    </div>
    @endif
    
    @if(!empty($data['features']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-50px]">
      @foreach($data['features'] as $feature)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-4/12' }} w-full flex-[0_0_auto] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !px-[15px] max-w-full !mt-[50px]">
        <div class="flex flex-row">
          @if(!empty($feature['icon']))
          <div>
            <img src="{{ asset($feature['icon']) }}" class="!w-[2.2rem] !h-[2.2rem] !mr-4" alt="icon">
          </div>
          @endif
          <div>
            @if(!empty($feature['title']))
            <h4 class="!mb-1">{{ $feature['title'] }}</h4>
            @endif
            @if(!empty($feature['description']))
            <p class="!mb-0">{{ $feature['description'] }}</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

