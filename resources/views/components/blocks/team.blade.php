@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#ffffff]' }}">
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
    
    @if(!empty($data['members']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-50px]">
      @foreach($data['members'] as $member)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-3/12' }} w-full flex-[0_0_auto] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !px-[15px] max-w-full !mt-[50px]">
        <div class="!text-center">
          @if(!empty($member['photo']))
          <figure class="!mb-4">
            <img class="!rounded-[50%] !w-[10rem] !h-[10rem] m-[0_auto] object-cover" 
                 src="{{ asset($member['photo']) }}" 
                 alt="{{ $member['name'] ?? '' }}">
          </figure>
          @endif
          
          @if(!empty($member['name']))
          <h4 class="!mb-1">{{ $member['name'] }}</h4>
          @endif
          
          @if(!empty($member['position']))
          <p class="!mb-3 text-[0.9rem]">{{ $member['position'] }}</p>
          @endif
          
          @if(!empty($member['bio']))
          <p class="!mb-3 text-[0.85rem]">{{ $member['bio'] }}</p>
          @endif
          
          @if(!empty($member['social']))
          <nav class="nav social justify-center !text-center !mb-0">
            @if(!empty($member['social']['twitter']))
            <a class="m-[0_.35rem_0_0] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ $member['social']['twitter'] }}">
              <i class="uil uil-twitter before:content-['\ed59'] text-[1rem] text-[#5daed5]"></i>
            </a>
            @endif
            @if(!empty($member['social']['linkedin']))
            <a class="m-[0_.35rem_0_0] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ $member['social']['linkedin'] }}">
              <i class="uil uil-linkedin before:content-['\ebd1'] text-[1rem] text-[#0077b5]"></i>
            </a>
            @endif
            @if(!empty($member['social']['facebook']))
            <a class="m-[0_.35rem_0_0] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ $member['social']['facebook'] }}">
              <i class="uil uil-facebook-f before:content-['\eae2'] text-[1rem] text-[#4470cf]"></i>
            </a>
            @endif
          </nav>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

