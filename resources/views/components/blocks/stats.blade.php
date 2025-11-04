@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#ffffff]' }}">
  <div class="container py-16 xl:py-20 lg:py-20 md:py-20">
    @if(!empty($data['stats']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-35px] lg:mx-[-35px] counter-wrapper !text-center">
      @foreach($data['stats'] as $stat)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-3/12' }} xl:w-3/12 w-full flex-[0_0_auto] xl:!px-[35px] lg:!px-[35px] !px-[15px] max-w-full">
        <div class="!mb-4">
          @if(!empty($stat['icon']))
          <img src="{{ asset($stat['icon']) }}" class="!w-[3rem] !h-[3rem] m-[0_auto] !mb-3" alt="icon">
          @endif
          
          @if(!empty($stat['number']))
          <h3 class="counter xl:!text-[2.5rem] !text-[calc(1.375rem_+_1.5vw)] !leading-none !mb-2 text-[#e31e24]">
            {{ $stat['number'] }}
          </h3>
          @endif
          
          @if(!empty($stat['label']))
          <p class="text-[0.9rem] font-medium !mb-0">{{ $stat['label'] }}</p>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

