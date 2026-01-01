@extends('layouts.site')

@section('title', 'Anasayfa')

@section('content')
<div class="grow shrink-0">
    
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-400 !text-white bg-no-repeat bg-[center_center] bg-cover relative z-0 !bg-fixed before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(30,34,40,.4)]" data-image-src="../assets/img/photos/bg3.jpg" style="background-image: url(&quot;../assets/img/photos/bg3.jpg&quot;);">
      <div class="container pt-28 pb-40 xl:pt-36 lg:pt-36 md:pt-36 xl:pb-[12.5rem] lg:pb-[12.5rem] md:pb-[12.5rem] !text-center">
        <div class="flex flex-wrap mx-[-15px]">
          <div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
            <h1 class="!text-[calc(1.365rem_+_1.38vw)] font-bold !leading-[1.2] xl:!text-[2.4rem] !mb-3 !text-white">{{ t('Bize Ulaşın') }}</h1>
            <nav class="inline-block" aria-label="breadcrumb">
              <ol class="breadcrumb  flex flex-wrap bg-[none] p-0 !rounded-none list-none !mb-[20px]">
                <li class="breadcrumb-item flex !text-[#60697b]"><a class="!text-white hover:text-white" href="./">{{ t('Anasayfa') }}</a></li>
                <li class="breadcrumb-item flex !text-white !pl-2 before:font-normal before:!flex before:items-center before:text-[rgba(255,255,255,.5)] before:content-['\e931'] before:text-[0.9rem] before:-mt-px before:!pr-2 before:font-Unicons active" aria-current="page">{{ t('İletişim') }}</li>
              </ol>
            </nav>
            <!-- /nav -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper !bg-[#ffffff]   relative border-0 upper-end before:top-[-4rem] before:border-l-transparent before:border-r-[100vw] before:border-t-[4rem] before:border-[#fefefe] before:content-[''] before:block before:absolute before:z-0 before:border-y-transparent before:border-0 before:border-solid before:right-0">
      <div class="container pb-12">
        <div class="flex flex-wrap mx-[-15px] !mb-[4.5rem] md:!mb-24">
          <div class="xl:w-10/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !mt-[-9rem]">
            <div class="card">
              <div class="flex flex-wrap mx-0">
                <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full !self-stretch">
                  <div class="map map-full rounded-t-[0.4rem] rounded-lg-start h-full min-h-[15rem]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3185.260084530038!2d37.3074315!3d37.027444599999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1531df5596352d25%3A0xdf86e451c6ee688a!2zVHJ1bsOnZ2ls!5e0!3m2!1str!2str!4v1767207015943!5m2!1str!2str" style="width:100%; height: 100%; border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                  <!-- /.map -->
                </div>
                <!--/column -->
                <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full">
                  <div class="p-10 xl:!p-[4.5rem] lg:!p-[4.5rem] md:!p-12">
                    <div class="flex flex-row">
                      <div>
                        <div class="icon !text-[#e31e24] xl:!text-[1.4rem] !text-[calc(1.265rem_+_0.18vw)] !mr-4 !mt-[-0.25rem]"> <i class="uil uil-location-pin-alt before:content-['\ebd8']"></i> </div>
                      </div>
                      <div class="!self-start !justify-start">
                        <h5 class="!mb-1">{{ t('Adres') }}</h5>
                        <address class=" not-italic !leading-[inherit] !mb-4">{{ setting('contact_address') }}</address>
                      </div>
                    </div>
                    <!--/div -->
                    <div class="flex flex-row">
                      <div>
                        <div class="icon !text-[#e31e24] xl:!text-[1.4rem] !text-[calc(1.265rem_+_0.18vw)] !mr-4 !mt-[-0.25rem]"> <i class="uil uil-phone-volume before:content-['\ec50']"></i> </div>
                      </div>
                      <div>
                        <h5 class="!mb-1">{{ t('Telefon') }}</h5>
                        <p>{{ setting('contact_phone') }}</p>
                      </div>
                    </div>
                    <!--/div -->
                    <div class="flex flex-row">
                      <div>
                        <div class="icon !text-[#e31e24] xl:!text-[1.4rem] !text-[calc(1.265rem_+_0.18vw)] !mr-4 !mt-[-0.25rem]"> <i class="uil uil-envelope before:content-['\eac8']"></i> </div>
                      </div>
                      <div>
                        <h5 class="!mb-1">{{ t('E-posta') }}</h5>
                        <p class="!mb-0"><a href="mailto:{{ setting('contact_email') }}" class="!text-[#60697b]">{{ setting('contact_email') }}</a></p>
                      </div>
                    </div>
                    <!--/div -->
                  </div>
                  <!--/div -->
                </div>
                <!--/column -->
              </div>
              <!--/.row -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
        <div class="flex flex-wrap mx-[-15px]">
          <div class="xl:w-8/12 xl:!ml-[16.66666667%] lg:w-10/12 lg:!ml-[8.33333333%] w-full flex-[0_0_auto] !px-[15px] max-w-full">
            <h2 class="!text-[calc(1.305rem_+_0.66vw)] font-bold xl:!text-[1.8rem] !leading-[1.3] !mb-3 !text-center">{{ t('Bize Ulaşın') }}</h2>
            <p class="lead !leading-[1.65] text-[0.9rem] font-medium !text-center !mb-10">{{ t('Bize ulaşmak için lütfen aşağıdaki formu doldurunuz veya bizimle iletişime geçin.') }}</p>
            <form class="contact-form needs-validation" method="post" action="https://Trunçgil-tailwind-template.netlify.app/assets/php/contact.php" novalidate="">
              <div class="messages"></div>
              <div class="flex flex-wrap mx-[-10px]">
                <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
                  <div class="form-floating relative !mb-4">
                    <input id="form_name" type="text" name="name" class=" form-control  relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out     focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset]   focus-visible:!border-[rgba(63,120,224,0.5)]   placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" required="">
                    <label for="form_name" class="!text-[#959ca9] !mb-2 !inline-block text-[.75rem] !absolute !z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">{{ t('Adınız') }} *</label>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> {{ t('Lütfen adınızı giriniz.') }} </div>
                  </div>
                </div>
                <!-- /column -->
                <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
                  <div class="form-floating relative !mb-4">
                    <input id="form_lastname" type="text" name="surname" class=" form-control  relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out     focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset]   focus-visible:!border-[rgba(63,120,224,0.5)]   placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" required="">
                    <label for="form_lastname" class="!text-[#959ca9] !mb-2 !inline-block text-[.75rem] !absolute !z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">{{ t('Soyadınız') }} *</label>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> {{ t('Lütfen soyadınızı giriniz.') }} </div>
                  </div>
                </div>
                <!-- /column -->
                <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
                  <div class="form-floating relative !mb-4">
                    <input id="form_email" type="email" name="email" class=" form-control  relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out     focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset]   focus-visible:!border-[rgba(63,120,224,0.5)]   placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" required="">
                        <label for="form_email" class="!text-[#959ca9] !mb-2 !inline-block text-[.75rem] !absolute !z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">{{ t('E-posta') }} *</label>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> {{ t('Lütfen geçerli bir e-posta adresi giriniz.') }} </div>
                  </div>
                </div>
                <!-- /column -->
                <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full">
                  <div class="form-select-wrapper !mb-4">
                    <select class="form-select" id="form-select" name="department" required="">
                      <option selected="" disabled="" value="">{{ t('Departman Seçiniz') }}</option>
                      <option value="Sales">{{ t('Satış') }}</option>
                      <option value="Marketing">{{ t('Teknik Destek') }}</option>
                      <option value="Customer Support">{{ t('Muhasebe') }}</option>
                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> {{ t('Lütfen bir departman seçiniz.') }} </div>
                  </div>
                </div>
                <!-- /column -->
                <div class="w-full flex-[0_0_auto] !px-[15px] max-w-full">
                  <div class="form-floating relative !mb-4">
                    <textarea id="form_message" name="message" class=" form-control  relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out     focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset]   focus-visible:!border-[rgba(63,120,224,0.5)]   placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" style="height: 150px" required=""></textarea>
                    <label for="form_message" class="!text-[#959ca9] !mb-2 !inline-block text-[.75rem] !absolute !z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope">{{ t('Mesajınız') }} *</label>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> {{ t('Lütfen mesajınızı giriniz.') }} </div>
                  </div>
                </div>
                <!-- /column -->
                <div class="w-full flex-[0_0_auto] !px-[15px] max-w-full !text-center">
                  <input type="submit" class="btn btn-primary !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24]   active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !rounded-[50rem] btn-send !mb-3 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]" value="{{ t('Mesaj Gönder') }}">
                  <p class="!text-[#aab0bc]"><strong>*</strong> {{ t('Bu alanlar zorunludur.') }}</p>
                </div>
                <!-- /column -->
              </div>
              <!-- /.row -->
            </form>
            <!-- /form -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper image-wrapper bg-auto no-overlay bg-image !text-center bg-map bg-[center_center] bg-no-repeat !bg-scroll relative z-[0]" data-image-src="../assets/img/map.png" style="background-image: url(&quot;../assets/img/map.png&quot;);">
      <div class="container pt-0 pb-[4.5rem] xl:pt-24 lg:pt-24 md:pt-24 xl:pb-32 lg:pb-32 md:pb-32">
        <div class="flex flex-wrap mx-[-15px]">
          <div class="lg:w-9/12 xl:w-9/12 xxl:w-8/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
            <h3 class="!text-[calc(1.305rem_+_0.66vw)] font-bold xl:!text-[1.8rem] !leading-[1.3] !mb-8 xl:!px-14">{{ t('600+ müşterimize güveniyoruz. Şimdi onlarla birlikte işinizi büyütün.') }}</h3>
          </div>
          <!-- /.row -->
        </div>
        <!-- /column -->
        <div class="flex flex-wrap mx-[-15px]">
          <div class="md:w-10/12 lg:w-9/12 xl:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
            <div class="flex flex-wrap mx-[-15px] items-center counter-wrapper !mt-[-20px] xl:!mt-0 lg:!mt-0 md:!mt-0">
              <div class="xl:w-4/12 lg:w-4/12 md:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !text-center !mt-[20px] xl:!mt-0 lg:!mt-0 md:!mt-0">
                <h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none !mb-2 xl:!text-[2.2rem]  !text-[#e31e24]" style="visibility: visible;">126</h3>
                <p class=" text-[0.8rem] font-medium !mb-0">{{ t('Tamamlanan Projeler') }}</p>
              </div>
              <!--/column -->
              <div class="xl:w-4/12 lg:w-4/12 md:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !text-center !mt-[20px] xl:!mt-0 lg:!mt-0 md:!mt-0">
                <h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none !mb-2 xl:!text-[2.2rem]  !text-[#e31e24]" style="visibility: visible;">600+</h3>
                <p class=" text-[0.8rem] font-medium !mb-0">{{ t('Memnuniyetli Müşteriler') }}</p>
              </div>
              <!--/column -->
              <div class="xl:w-4/12 lg:w-4/12 md:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !text-center !mt-[20px] xl:!mt-0 lg:!mt-0 md:!mt-0">
                <h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none !mb-2 xl:!text-[2.2rem]  !text-[#e31e24]" style="visibility: visible;">10+</h3>
                <p class=" text-[0.8rem] font-medium !mb-0">{{ t('Uzman Çalışanlar') }}</p>
              </div>
              <!--/column -->
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
  </div>
@endsection
