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
    
    @if(!empty($data['testimonials']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-50px]">
      @foreach($data['testimonials'] as $testimonial)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-4/12' }} w-full flex-[0_0_auto] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !px-[15px] max-w-full !mt-[50px]">
        <div class="card !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)] !rounded-[0.8rem] !bg-white p-6">
          @if(!empty($testimonial['rating']))
          <div class="!mb-3">
            @for($i = 0; $i < ($testimonial['rating'] ?? 5); $i++)
            <i class="uil uil-star text-[#ffc107] text-[1rem]"></i>
            @endfor
          </div>
          @endif
          
          @if(!empty($testimonial['quote']))
          <blockquote class="!border-0 !mb-4">
            <p class="!mb-0">"{{ $testimonial['quote'] }}"</p>
          </blockquote>
          @endif
          
          <div class="flex items-center">
            @if(!empty($testimonial['avatar']))
            <img class="!rounded-[50%] !w-12 !h-12 !mr-4" src="{{ asset($testimonial['avatar']) }}" alt="avatar">
            @endif
            <div>
              @if(!empty($testimonial['name']))
              <h6 class="!mb-0">{{ $testimonial['name'] }}</h6>
              @endif
              @if(!empty($testimonial['position']))
              <p class="!mb-0 text-[0.85rem]">{{ $testimonial['position'] }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

