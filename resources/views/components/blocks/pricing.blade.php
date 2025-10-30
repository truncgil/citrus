@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#ffffff]' }}">
  <div class="container py-24 xl:py-32 lg:py-32 md:py-32">
    @if(!empty($data['section_title']) || !empty($data['section_subtitle']))
    <div class="flex flex-wrap mx-[-15px] !mb-12 !text-center">
      <div class="md:w-10/12 lg:w-9/12 xl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
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
    
    @if(!empty($data['plans']))
    <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-50px] justify-center">
      @foreach($data['plans'] as $plan)
      <div class="{{ $data['column_class'] ?? 'md:w-6/12 lg:w-4/12' }} w-full flex-[0_0_auto] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !px-[15px] max-w-full !mt-[50px]">
        <div class="pricing card {{ !empty($plan['featured']) ? '!shadow-[0_0.5rem_2rem_rgba(30,34,40,0.15)] !border-[#e31e24] !border-2' : '!shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]' }} !rounded-[0.8rem]">
          <div class="card-body p-10">
            @if(!empty($plan['featured']))
            <div class="!mb-3 !text-center">
              <span class="badge bg-[#e31e24] !rounded-[0.8rem] !px-3 !py-1 text-white text-[0.75rem]">{{ $data['featured_label'] ?? 'Önerilen' }}</span>
            </div>
            @endif
            
            @if(!empty($plan['name']))
            <h4 class="!mb-2 !text-center">{{ $plan['name'] }}</h4>
            @endif
            
            <div class="!text-center !mb-6">
              @if(!empty($plan['currency']))
              <span class="text-[1.2rem] text-muted">{{ $plan['currency'] }}</span>
              @endif
              @if(!empty($plan['price']))
              <span class="!text-[2.5rem] font-bold text-[#343f52]">{{ $plan['price'] }}</span>
              @endif
              @if(!empty($plan['period']))
              <span class="text-[1rem] text-muted">/{{ $plan['period'] }}</span>
              @endif
            </div>
            
            @if(!empty($plan['features']))
            <ul class="list-none !pl-0 !mb-6">
              @foreach($plan['features'] as $feature)
              <li class="flex items-start !mb-3">
                <i class="uil uil-check text-[#e31e24] text-[1.2rem] !mr-2 !mt-1"></i>
                <span>{{ $feature }}</span>
              </li>
              @endforeach
            </ul>
            @endif
            
            @if(!empty($plan['button_text']))
            <a href="{{ $plan['button_url'] ?? '#' }}" 
               class="btn {{ !empty($plan['featured']) ? 'btn-grape !text-white !bg-[#e31e24]' : 'btn-outline-grape !text-[#e31e24]' }} !w-full !rounded-[0.8rem]">
              {{ $plan['button_text'] }}
            </a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

