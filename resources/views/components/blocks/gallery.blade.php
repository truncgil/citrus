@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#f0f0f8]' }}">
  <div class="container py-24 xl:py-32 lg:py-32 md:py-32">
    @if(!empty($data['section_title']) || !empty($data['section_subtitle']))
    <div class="flex flex-wrap mx-[-15px] !mb-12 !text-center">
      <div class="md:w-10/12 lg:w-8/12 xl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
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
    
    @if(!empty($data['items']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-12px] lg:mx-[-12px] md:mx-[-12px] !mt-[-24px]">
      @foreach($data['items'] as $item)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-4/12' }} w-full flex-[0_0_auto] xl:!px-[12px] lg:!px-[12px] md:!px-[12px] !px-[15px] max-w-full !mt-[24px]">
        <figure class="!rounded-[0.8rem] !mb-6 group overflow-hidden">
          <a href="{{ $item['link'] ?? '#' }}">
            <img class="!rounded-[0.8rem] !transition-all !duration-[0.3s] !ease-in-out group-hover:!scale-105" 
                 src="{{ asset($item['image']) }}" 
                 alt="{{ $item['title'] ?? '' }}">
          </a>
        </figure>
        @if(!empty($item['category']))
        <span class="badge bg-[#e31e24] !rounded-[0.8rem] !mb-2 text-white text-[0.7rem]">{{ $item['category'] }}</span>
        @endif
        @if(!empty($item['title']))
        <h4 class="!mb-1">
          <a href="{{ $item['link'] ?? '#' }}" class="hover:text-[#e31e24]">{{ $item['title'] }}</a>
        </h4>
        @endif
        @if(!empty($item['description']))
        <p class="!mb-0">{{ $item['description'] }}</p>
        @endif
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

