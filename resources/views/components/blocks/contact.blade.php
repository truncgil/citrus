@props(['data' => []])

<section class="wrapper {{ $data['bg_class'] ?? '!bg-[#f0f0f8]' }}">
  <div class="container py-24 xl:py-32 lg:py-32 md:py-32">
    <div class="flex flex-wrap mx-[-15px]">
      <div class="lg:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
        @if(!empty($data['section_badge']))
        <h2 class="text-[0.8rem] tracking-[0.02rem] uppercase text-[#e31e24] !mb-3 !leading-[1.35]">{{ $data['section_badge'] }}</h2>
        @endif
        
        @if(!empty($data['title']))
        <h2 class="!text-[calc(1.345rem_+_1.14vw)] font-bold !leading-[1.2] xl:!text-[2.2rem] !mb-3">
          {{ $data['title'] }}
        </h2>
        @endif
        
        @if(!empty($data['subtitle']))
        <p class="lead !leading-[1.6] !mb-8">{{ $data['subtitle'] }}</p>
        @endif
        
        @if(!empty($data['info']))
        <div class="!mb-8">
          @if(!empty($data['info']['address']))
          <div class="flex items-start !mb-4">
            <i class="uil uil-location-point text-[#e31e24] text-[1.3rem] !mr-3"></i>
            <p class="!mb-0">{{ $data['info']['address'] }}</p>
          </div>
          @endif
          
          @if(!empty($data['info']['phone']))
          <div class="flex items-start !mb-4">
            <i class="uil uil-phone-volume text-[#e31e24] text-[1.3rem] !mr-3"></i>
            <p class="!mb-0"><a href="tel:{{ $data['info']['phone'] }}" class="hover:text-[#e31e24]">{{ $data['info']['phone'] }}</a></p>
          </div>
          @endif
          
          @if(!empty($data['info']['email']))
          <div class="flex items-start !mb-4">
            <i class="uil uil-envelope text-[#e31e24] text-[1.3rem] !mr-3"></i>
            <p class="!mb-0"><a href="mailto:{{ $data['info']['email'] }}" class="hover:text-[#e31e24]">{{ $data['info']['email'] }}</a></p>
          </div>
          @endif
        </div>
        @endif
      </div>
      
      <div class="lg:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
        <form method="POST" action="{{ $data['form_action'] ?? route('contact.submit') }}" class="contact-form">
          @csrf
          <div class="messages"></div>
          <div class="flex flex-wrap mx-[-10px]">
            <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[10px] max-w-full">
              <div class="form-floating !mb-4">
                <input id="form_name" type="text" name="name" class="form-control !relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]" placeholder="Jane" required>
                <label for="form_name" class="text-[#959ca9] !mb-0 !ml-[0.05rem] inline-block !text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">Ad Soyad *</label>
              </div>
            </div>
            <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[10px] max-w-full">
              <div class="form-floating !mb-4">
                <input id="form_email" type="email" name="email" class="form-control !relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]" placeholder="jane.doe@example.com" required>
                <label for="form_email" class="text-[#959ca9] !mb-0 !ml-[0.05rem] inline-block !text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">E-posta *</label>
              </div>
            </div>
            <div class="w-full flex-[0_0_auto] !px-[10px] max-w-full">
              <div class="form-floating !mb-4">
                <textarea id="form_message" name="message" class="form-control !relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 !h-[calc(2.5rem_+_2px)] !min-h-[calc(8rem_+_2px)] leading-[1.25] p-[.6rem_1rem] resize-none" placeholder="Your message" required></textarea>
                <label for="form_message" class="text-[#959ca9] mb-0 ml-[0.05rem] inline-block text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">Mesajınız *</label>
              </div>
            </div>
            <div class="w-full flex-[0_0_auto] !px-[10px] max-w-full">
              <button type="submit" class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:border-[#e31e24] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !rounded-[0.8rem] btn-send !mb-3 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">
                {{ $data['button_text'] ?? 'Gönder' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

