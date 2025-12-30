@extends('layouts.site')

@section('title', 'Anasayfa')

@section('content')
	<section class="wrapper !bg-[#f0f0f8]">
		<div class="container pt-10 lg:pt-14 xl:!pt-14 xxl:!pt-10 lg:pb-10 xl:pb-10 xxl:pb-0">
			<div class="flex flex-wrap mx-[-15px] md:mx-[-20px] lg:mx-[-20px] xl:mx-[-35px] !mt-[-50px] items-center text-center lg:text-left xl:text-left">
			<div class="lg:w-6/12 xl:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full md:!px-[20px] lg:!px-[20px] xl:!px-[35px] !mt-[50px]" data-cues="slideInDown" data-group="page-title" data-delay="900" data-disabled="true">
				<h1 class="xl:!text-[2.5rem] !text-[calc(1.375rem_+_1.5vw)] !leading-[1.15] font-semibold !mb-4 xl:!mr-5 xl:!mt-[-2.5rem] lg:!mt-[-2.5rem]" data-cue="slideInDown" data-group="page-title" data-delay="900" data-show="true" style="animation-name: slideInDown; animation-duration: 700ms; animation-timing-function: ease; animation-delay: 900ms; animation-direction: normal; animation-fill-mode: both;">{!! t('İnsan odaklı <br class="hidden md:block xl:!hidden lg:!hidden"><span class="!text-[#e31e24] ">akılcı ve sade</span>') !!}</h1>
				<p class="lead !text-[1.2rem] !leading-[1.5] !mb-7 xxl:!pr-20" data-cue="slideInDown" data-group="page-title" data-delay="900" data-show="true" style="animation-name: slideInDown; animation-duration: 700ms; animation-timing-function: ease; animation-delay: 1200ms; animation-direction: normal; animation-fill-mode: both;">{!! t('Hayatı kolaylaştırabilecek uygulamaları insan odaklı, akılcı, sade ve estetik  <br class="hidden md:block xl:!hidden lg:!hidden"> bir biçimde gerçekleştirmek için var gücümüzle çalışıyoruz.') !!}</p>
				<div class="inline-flex !mr-2" data-cue="slideInDown" data-group="page-title" data-delay="900" data-show="true" style="animation-name: slideInDown; animation-duration: 700ms; animation-timing-function: ease; animation-delay: 1500ms; animation-direction: normal; animation-fill-mode: both;"><a href="#" class="btn btn-lg btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24]   active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] rounded">{!! t('Ürün ve Hizmetlerimiz') !!}</a></div>
				<div class="inline-flex" data-cue="slideInDown" data-group="page-title" data-delay="900" data-show="true" style="animation-name: slideInDown; animation-duration: 700ms; animation-timing-function: ease; animation-delay: 1800ms; animation-direction: normal; animation-fill-mode: both;"><a href="#" class="btn btn-lg btn-outline-grape !text-[#e31e24] bg-[#e31e24] !border-[#e31e24] !border-[2px] hover:!text-white hover:!bg-[#e31e24] hover:!border-[#e31e24] focus:shadow-[rgba(96,93,186,1)] active:!text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:!text-white disabled:bg-transparent disabled:border-[#e31e24] rounded">{!! t('Neler Yapıyoruz?') !!}</a></div>
			</div>
			<!--/column -->
			<div class="w-10/12 md:w-7/12 lg:w-6/12 xl:w-5/12 !mx-auto flex-[0_0_auto] !px-[15px] max-w-full xl:!ml-5 md:!px-[20px] lg:!px-[20px] xl:!px-[35px] !mt-[50px]">
				<img class="max-w-full h-auto !mb-[-3.5rem] md:!mb-[-4.5rem] lg:!mb-[-9rem] xl:!mb-[-9rem]" src="{{ setting('home_hero', asset('assets/img/illustrations/3d11.png')) }}" data-cue="fadeIn" data-delay="300" alt="image" data-show="true" style="animation-name: fadeIn; animation-duration: 700ms; animation-timing-function: ease; animation-delay: 300ms; animation-direction: normal; animation-fill-mode: both;">
			</div>
			<!--/column -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
		<figure class="m-0 p-0"><img class="w-full max-w-full !h-auto" src="{{ asset('assets/img/photos/clouds.png') }}" alt="image"></figure>
	</section>
	<section class="wrapper bg-[rgba(255,255,255)] opacity-100">
	<div class="container pt-20 pb-20 xl:pb-28 lg:pb-28 md:pb-28">
		<div class="flex flex-wrap mx-[-15px] !text-center">
		<div class="md:w-10/12 md:!ml-[8.33333333%] lg:w-10/12 lg:!ml-[8.33333333%] xl:w-10/12 xl:!ml-[8.33333333%] xxl:w-8/12 xxl:!ml-[16.66666667%] flex-[0_0_auto] !px-[15px] max-w-full">
			<h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35 !tracking-[0.02rem]">{!! t('Neler Yapıyoruz?') !!}</h2>
			<h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-9">{!! t('Şirket ihtiyaçlarınızı en iyi şekilde karşılamak için çeşitli hizmetler sunuyoruz.') !!}</h3>
		</div>
		<!-- /column -->
		</div>
		<!-- /.row -->
		<div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-40px] !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem] !text-center">
		<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
			<div class="md:!px-3 lg:!px-0 xl:!px-3">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256.01 256" data-inject-url="{{ asset('assets/img/icons/solid/globe-2.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]"><path class="fill-secondary" d="M128.11 256h-.24a126.37 126.37 0 01-22-1.84 8 8 0 112.72-15.76A114.68 114.68 0 00128 240a8.06 8.06 0 018.07 8 8 8 0 01-7.94 8zm33.52-12.5a8 8 0 014.77-10.25 112.18 112.18 0 0017.66-8.25 8 8 0 018 13.85 128.36 128.36 0 01-20.19 9.46 8 8 0 01-10.26-4.79zm-97.5-4.56a128.83 128.83 0 01-18.27-12.78 8 8 0 1110.25-12.27 114.33 114.33 0 0016 11.2 8 8 0 11-8 13.85zm150.69-27.71a8 8 0 01-1-11.26A112.91 112.91 0 00225 184a8 8 0 0113.86 8 130.3 130.3 0 01-12.78 18.26 8 8 0 01-11.28 1zm-197.59-19A128.41 128.41 0 017.76 172a8 8 0 1115-5.49 112.8 112.8 0 008.29 17.67 8 8 0 11-13.84 8zM244.8 156.7a8 8 0 01-6.5-9.26A112.3 112.3 0 00240 128a8.23 8.23 0 018-8.26 7.81 7.81 0 018 8.76 124.89 124.89 0 01-1.92 21.72 8 8 0 01-9.26 6.48zM8 136.13a7.89 7.89 0 01-8-7.87s.61-15 1.86-22.18a8 8 0 1115.76 2.7A114.47 114.47 0 0016 128a8.09 8.09 0 01-8 8.13zm225.1-46.88a110.41 110.41 0 00-8.32-17.63 8 8 0 0113.83-8.08 129 129 0 019.52 20.17 8 8 0 01-15 5.54zM19.9 75.18A8 8 0 0117 64.26 126.41 126.41 0 0129.73 46 8 8 0 1142 56.21a112.72 112.72 0 00-11.17 16 8 8 0 01-10.93 3zm179.76-33.24a113.17 113.17 0 00-16-11.16 8 8 0 117.95-13.87 127.39 127.39 0 0118.3 12.75 8 8 0 01-10.24 12.28zM60.78 28.26a8 8 0 012.88-11 128 128 0 0120.18-9.44 8 8 0 115.52 15 112.17 112.17 0 00-17.63 8.31 8 8 0 01-11-2.88zm86.29-10.64A112.4 112.4 0 00128 16a8.17 8.17 0 01-8.19-8 7.84 7.84 0 017.81-8h.38a127.72 127.72 0 0121.8 1.86 8 8 0 01-2.71 15.76z"></path><path class="fill-primary" d="M128 32a96 96 0 1096 96 96.11 96.11 0 00-96-96zm62.61 145.66a103 103 0 00-14.49-7.76 160.22 160.22 0 005-33.9h26.48a79.47 79.47 0 01-17.01 41.66zM48.4 136h26.48a161.6 161.6 0 005 33.9 104.11 104.11 0 00-14.5 7.76A79.47 79.47 0 0148.4 136zm17-57.66a103.14 103.14 0 0014.5 7.76 160.2 160.2 0 00-5 33.9H48.4a79.47 79.47 0 0117-41.66zM120 79.7a106.49 106.49 0 01-20-3.43c5.41-13 12.6-22.11 20-26zm0 16V120H90.86A145.12 145.12 0 0195 91.49a122.72 122.72 0 0025 4.21zm0 40.3v24.3a121.26 121.26 0 00-25 4.23A144.37 144.37 0 0190.86 136H120zm0 40.3v29.48c-7.4-3.94-14.59-13-20-26a104.12 104.12 0 0120-3.44zm16 0a106.21 106.21 0 0120 3.43c-5.4 13-12.59 22.11-20 26zm0-16V136h29.1a144.37 144.37 0 01-4.16 28.51 122.49 122.49 0 00-25-4.21zm0-40.3V95.7a121.14 121.14 0 0025-4.23 142.91 142.91 0 014.1 28.53H136zm0-40.3V50.24c7.41 3.94 14.6 13 20 26a104.36 104.36 0 01-20 3.46zm27.94-23.08a80.19 80.19 0 0115.25 10 88.15 88.15 0 01-8.19 4.21 98.1 98.1 0 00-7.12-14.21zm-79 14.21a86.72 86.72 0 01-8.12-4.25 80.12 80.12 0 0115.24-10 95.14 95.14 0 00-7.12 14.25zm0 114.34a98.11 98.11 0 007.12 14.21 80.12 80.12 0 01-15.24-10 86.72 86.72 0 018.12-4.21zm86.1 0a88.15 88.15 0 018.13 4.25 80.19 80.19 0 01-15.25 10 99.14 99.14 0 007.08-14.25zM181.1 120a161 161 0 00-5-33.9 104.57 104.57 0 0014.49-7.76 79.47 79.47 0 0117 41.66z"></path></svg>
			<h4>{!! t('Yapay Zeka') !!}</h4>
			<p class="!mb-2">{!! t('Yapay zeka teknolojilerini kullanarak işlerinizi otomatikleştirebiliriz.') !!}</p>
			<a href="#" class="more hover !text-[#e31e24]">{!! t('Daha fazla bilgi edin') !!}</a>
			</div>
		</div>
		<!--/column -->
		<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
			<div class="md:!px-3 lg:!px-0 xl:!px-3">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255.98 213.34" data-inject-url="{{ asset('assets/img/icons/solid/code.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]"><path class="fill-secondary" d="M104 213.34a11 11 0 01-2.59-.32 10.64 10.64 0 01-7.76-12.93l48-192a10.66 10.66 0 0120.68 5.17l-48 192a10.66 10.66 0 01-10.33 8.08z"></path><path class="fill-primary" d="M74.66 181.34a10.57 10.57 0 01-7.54-3.12l-64-64a10.67 10.67 0 010-15.08l64-64a10.67 10.67 0 0115.09 15.08l-56.46 56.47 56.46 56.46a10.65 10.65 0 01-7.55 18.19zm106.65 0a10.55 10.55 0 01-7.53-3.12 10.67 10.67 0 010-15.08l56.46-56.47-56.46-56.46a10.67 10.67 0 1115.08-15.09l64 64a10.68 10.68 0 010 15.09l-64 64a10.58 10.58 0 01-7.55 3.13z"></path></svg>
			<h4>{!! t('Web Uygulamaları') !!}</h4>
			<p class="!mb-2">{!! t('Web uygulamaları geliştirmek için gerekli olan tüm hizmetleri sunuyoruz.') !!}</p>
			<a href="#" class="more hover !text-[#e31e24]">{!! t('Daha fazla bilgi edin') !!}</a>
			</div>
		</div>
		<!--/column -->
		<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
			<div class="md:!px-3 lg:!px-0 xl:!px-3">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255.98 256" data-inject-url="{{ asset('assets/img/icons/solid/team.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]"><circle class="fill-primary" cx="128" cy="26.67" r="26.67"></circle><circle class="fill-primary" cx="202.67" cy="176" r="26.67"></circle><circle class="fill-primary" cx="53.33" cy="176" r="26.67"></circle><path class="fill-primary" d="M173.33 106.67H82.66a8 8 0 01-8-8v-5.33A29.35 29.35 0 01104 64h48a29.35 29.35 0 0129.33 29.32v5.33a8 8 0 01-8 8.02zM248 256h-90.67a8 8 0 01-8-8v-5.33a29.36 29.36 0 0129.33-29.33h48A29.36 29.36 0 01256 242.67V248a8 8 0 01-8 8zm-149.33 0H8a8 8 0 01-8-8v-5.33a29.36 29.36 0 0129.33-29.33h48a29.37 29.37 0 0129.33 29.33V248a8 8 0 01-8 8z"></path><path class="fill-secondary" d="M29.33 136.13a8 8 0 01-8-8 107.1 107.1 0 0161.73-96.77 8 8 0 116.73 14.51 91 91 0 00-52.48 82.26 8 8 0 01-7.98 8zm197.34 0a8 8 0 01-8-8 91 91 0 00-52.48-82.26 8 8 0 116.74-14.51 107.09 107.09 0 0161.73 96.77 8 8 0 01-8 8zM128 234.8a105.08 105.08 0 01-11.15-.58 8 8 0 011.66-15.9 93.73 93.73 0 0019.6-.06 8 8 0 011.76 15.9 110.68 110.68 0 01-11.87.64z"></path></svg>
			<h4>{!! t('Sosyal Etkileşim') !!}</h4>
			<p class="!mb-2">{!! t('Sosyal etkileşime dayalı .') !!}</p>
			<a href="#" class="more hover !text-[#e31e24]">{!! t('Daha fazla bilgi edin') !!}</a>
			</div>
		</div>
		<!--/column -->
		<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
			<div class="md:!px-3 lg:!px-0 xl:!px-3">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" data-inject-url="{{ asset('assets/img/icons/solid/devices.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]"><path class="fill-primary" d="M226.67 0H80a29.35 29.35 0 00-29.33 29.33v13.33H72v-8a13.34 13.34 0 0113.33-13.33h136a13.34 13.34 0 0113.33 13.33v186.67a13.35 13.35 0 01-13.33 13.33h-82.74A44.07 44.07 0 01132.7 256h94a29.33 29.33 0 0029.3-29.33V29.33A29.35 29.35 0 00226.67 0z"></path><path class="fill-secondary" d="M97.17 64h-77C9 64 0 73.87 0 86v148c0 12.13 9 22 20.16 22h77c11.12 0 20.16-9.87 20.16-22V86c.01-12.13-9.03-22-20.15-22zm5.5 168c0 4.42-3.28 8-7.33 8H22c-4.05 0-7.33-3.58-7.33-8V85.33c0-4.42 3.28-8 7.33-8h3.66c4.05 0 7.33 3.58 7.33 8s3.28 8 7.33 8H77c4.05 0 7.33-3.59 7.33-8s3.28-8 7.33-8h3.66c4 0 7.33 3.58 7.33 8V232z"></path><path class="fill-primary" d="M154.67 186.67A13.33 13.33 0 10168 200a13.35 13.35 0 00-13.33-13.33z"></path></svg>
			<h4>{!! t('Uygulama Geliştirme') !!}</h4>
			<p class="!mb-2">{!! t('Android, iOS, MacOS, Windows uygulamaları geliştiriyoruz.') !!}</p>
			<a href="#" class="more hover !text-[#e31e24]">{!! t('Daha fazla bilgi edin') !!}</a>
			</div>
		</div>
		<!--/column -->
		</div>
		<!--/.row -->
		<div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] !mb-[4.5rem] xl:!mb-[6rem] lg:!mb-[6rem] md:!mb-[6rem] items-center">
		<div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full px-[7.5px] !mt-[50px]">
			<figure class="m-0 p-0"><img class="w-auto" src="{{ setting('home_why_choose_us_image', asset('assets/img/illustrations/3d8.png')) }}" alt="image"></figure>
		</div>
		<!--/column -->
		<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !ml-auto px-[7.5px] !mt-[50px]">
			<h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35 !tracking-[0.02rem]">{!! t('Bizi Neden Tercih Etmelisiniz') !!}</h2>
			<h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-8">{!! t('Siz değerli müşterilerimizin bizi tercih etmesinin yalnızca birkaç nedeni.') !!}</h3>
			<div class="flex flex-wrap mx-[-15px] !mt-[-30px]">
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<div class="flex flex-row">
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" data-inject-url="{{ asset('assets/img/icons/solid/lamp.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-mono text-[#e31e24] text-grape !mr-4"><path class="fill-secondary" d="M128 36.86a8 8 0 01-8-8V8a8 8 0 0116 0v20.86a8 8 0 01-8 8zm70.1 29.04a8 8 0 01-5.67-13.64l14.77-14.77a8 8 0 1111.31 11.31l-14.77 14.77a8 8 0 01-5.64 2.33zM248 136h-20.86a8 8 0 010-16H248a8 8 0 010 16zm-35.15 84.85a8.06 8.06 0 01-5.67-2.34l-14.76-14.77a8 8 0 0111.31-11.31l14.77 14.77a8 8 0 010 11.31 7.92 7.92 0 01-5.65 2.34zm-169.7 0a8 8 0 01-5.66-13.65l14.77-14.77a8 8 0 0111.31 11.31L48.8 218.51a7.93 7.93 0 01-5.65 2.34zM28.86 136H8a8 8 0 010-16h20.86a8 8 0 110 16zM57.9 65.9a8 8 0 01-5.66-2.33L37.47 48.8a8 8 0 1111.31-11.31l14.77 14.77A8 8 0 0157.9 65.9z"></path><path class="fill-primary" d="M160 224v13.33A18.76 18.76 0 01141.33 256h-26.67c-9 0-18.66-6.83-18.66-21.76V224zm15-154a74.93 74.93 0 00-63-15c-28.27 5.91-51.2 29-57.07 57.21a74.74 74.74 0 0028.16 75.41A32.19 32.19 0 0195.25 208v.12A2 2 0 0196 208h64a.93.93 0 01.53.11V208c1.49-8.11 6.29-15.57 13.65-21.33A74.72 74.72 0 00175 70zm-7 63.36a8.06 8.06 0 01-8-8A29.32 29.32 0 00130.67 96a8 8 0 110-16A45.43 45.43 0 01176 125.33a8.06 8.06 0 01-8 8z"></path><path class="fill-secondary" d="M95.25 208H96a1.8 1.8 0 00-.75.11z"></path><path class="fill-primary" d="M160.53 208v.11a.93.93 0 00-.53-.11z"></path></svg>
				</div>
				<div>
					<h4 class="!mb-1">{!! t('Yaratıcılık') !!}</h4>
					<p class="!mb-0">{!! t('Seçkin içeriklerle daima fark yaratan fikirler.') !!}</p>
				</div>
				</div>
			</div>
			<!--/column -->
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<div class="flex flex-row">
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 255.98" data-inject-url="{{ asset('assets/img/icons/solid/bulb.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-mono text-[#e31e24] text-grape !mr-4"><circle class="fill-primary" cx="58.67" cy="149.31" r="32"></circle><path class="fill-primary" d="M88 202.65H29.33A29.36 29.36 0 000 232v16a8 8 0 008 8h101.33a8 8 0 008-8v-16A29.36 29.36 0 0088 202.65z"></path><circle class="fill-primary" cx="197.33" cy="149.31" r="32"></circle><path class="fill-primary" d="M226.67 202.65H168A29.36 29.36 0 00138.67 232v16a8 8 0 008 8H248a8 8 0 008-8v-16a29.36 29.36 0 00-29.33-29.35z"></path><path class="fill-secondary" d="M149.76 108.48v7.68A11.9 11.9 0 01137.81 128h-19.63c-5.76 0-12-4.27-12-13.76v-5.76zM176 47.68a47.26 47.26 0 01-17.6 36.91 22.89 22.89 0 00-8.32 13.23H106a20 20 0 00-7.79-12.69A47.13 47.13 0 0180 46.73C80.53 21.34 101.76.33 127.25 0a47.34 47.34 0 0134.56 13.88A46.82 46.82 0 01176 47.68z"></path></svg>
				</div>
				<div>
					<h4 class="!mb-1">{!! t('Yenilikçi Düşünce') !!}</h4>
					<p class="!mb-0">{!! t('Geleceği hedefleyen modern ve özgün yaklaşımlar.') !!}</p>
				</div>
				</div>
			</div>
			<!--/column -->
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<div class="flex flex-row">
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255.97 256" data-inject-url="{{ asset('assets/img/icons/solid/puzzle.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-mono text-[#e31e24] text-grape !mr-4"><path class="fill-secondary" d="M221.86 91a33.65 33.65 0 01-22.72-8.75v40.21h-27.2a43.26 43.26 0 003.73-17.71 44.8 44.8 0 10-86 17.71H56.85v-111A11.42 11.42 0 0168.26 0h119.47a11.42 11.42 0 0111.41 11.41v20.05A34.1 34.1 0 11221.86 91z"></path><path class="fill-primary" d="M142.79 181.25a34.13 34.13 0 0033.55 40.62 33.66 33.66 0 0022.75-8.77v31.52A11.41 11.41 0 01187.72 256H68.28a11.41 11.41 0 01-11.38-11.38V213.1a34.12 34.12 0 11-22.75-59.5 33.71 33.71 0 0122.75 8.77v-29.2H112a34.12 34.12 0 1137.76 0h49.37v29.2a34.09 34.09 0 00-56.3 18.88z"></path></svg>
				</div>
				<div>
					<h4 class="!mb-1">{!! t('Hızlı Çözümler') !!}</h4>
					<p class="!mb-0">{!! t('İhtiyaç anında anında sunulan pratik cevaplar.') !!}</p>
				</div>
				</div>
			</div>
			<!--/column -->
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<div class="flex flex-row">
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 244.09" data-inject-url="{{ asset('assets/img/icons/solid/headphone.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-mono text-[#e31e24] text-grape !mr-4"><path class="fill-secondary" d="M35.72 92.28a92.28 92.28 0 01184.56 0v47.63a8.93 8.93 0 01-17.86 0V92.28a74.42 74.42 0 10-148.84 0v47.63a8.93 8.93 0 11-17.86 0zm175.63 62.51a8.93 8.93 0 018.93 8.93v35.72a32.75 32.75 0 01-32.75 32.75h-35.72a8.94 8.94 0 010-17.87h35.72a14.88 14.88 0 0014.89-14.88v-35.72a8.93 8.93 0 018.93-8.93z"></path><path class="fill-secondary" d="M107.16 223.26A20.84 20.84 0 01128 202.42h11.91a20.84 20.84 0 010 41.67H128a20.84 20.84 0 01-20.84-20.83zm20.84-3a3 3 0 100 5.95h11.91a3 3 0 000-5.95z"></path><path class="fill-primary" d="M32.74 107.16A32.74 32.74 0 000 139.91v23.81a32.75 32.75 0 0032.74 32.75h11.91a8.93 8.93 0 008.93-8.94v-71.44a8.93 8.93 0 00-8.93-8.93zm190.52 0A32.74 32.74 0 01256 139.91v23.81a32.75 32.75 0 01-32.74 32.75h-11.91a8.93 8.93 0 01-8.93-8.94v-71.44a8.93 8.93 0 018.93-8.93z"></path></svg>
				</div>
				<div>
					<h4 class="!mb-1">{!! t('Üst Düzey Destek') !!}</h4>
					<p class="!mb-0">{!! t('Her adımda yanınızda olan kusursuz bir hizmet.') !!}</p>
				</div>
				</div>
			</div>
			<!--/column -->
			</div>
			<!--/.row -->
		</div>
		<!--/column -->
		</div>
		<!--/.row -->
		<div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] xl:!mt-0 lg:!mt-0 !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem] items-center">
		<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !mx-auto xl:!order-2 lg:!order-2 px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0">
			<figure class="m-0 p-0"><img class="w-auto" src="{{ setting('home_solutions_image', asset('assets/img/illustrations/3d5.png')) }}" alt="image"></figure>
		</div>
		<!--/column -->
		<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !mr-auto px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0">
			<h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35 !tracking-[0.02rem] !mb-3">{!! t('Çözümlerimiz') !!}</h2>
			<h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-5 xxl:!pr-5">{!! t('İşletmenizin ihtiyaçlarını biz karşılarken siz arkanıza yaslanın ve rahatlayın.') !!}</h3>
			<p class="!mb-6">{!! t('Siz sadece işinize odaklanın, biz dijital dönüşüm süreçlerinizi yönetelim.
Teknoloji ve yazılım odaklı bir güç olarak, işletmenizin dijital çağa tam uyum sağlaması için uçtan uca inovatif çözümler geliştiriyoruz. İhtiyaçlarınıza özel yazılım mimarileri ve modern altyapılar kurarak, manuel süreçlerinizi tam otomatik ve verimli sistemlere dönüştürüyoruz. Sektörel tecrübemizle markanızın teknolojik dönüşümünü gerçekleştirirken, sürdürülebilir başarı ve ölçeklenebilir büyüme için en ileri yazılım teknolojilerini işinizin merkezine yerleştiriyoruz.') !!}</p>
			<div class="flex flex-wrap mx-[-15px] items-center counter-wrapper !mt-[-30px]">
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none xl:!text-[2.2rem] !mb-1" style="visibility: visible;">99.7%</h3>
				<h6 class="!text-[0.85rem] !mb-1">{!! t('Müşteri Memnuniyeti') !!}</h6>
				<span class="ratings  inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five"></span>
			</div>
			<!--/column -->
			<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				<h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none xl:!text-[2.2rem] !mb-1" style="visibility: visible;">4x</h3>
				<h6 class="!text-[0.85rem] !mb-1">{!! t('Verimlilik artışı') !!}</h6>
				<span class="ratings  inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five"></span>
			</div>
			<!--/column -->
			</div>
			<!--/.row -->
		</div>
		<!--/column -->
		</div>
		<!--/.row -->
		<div class="flex flex-wrap mx-[-15px] xl:mx-0 lg:mx-0 !mt-[-50px] !mb-[5rem] xl:!mb-[8rem] lg:!mb-[8rem] md:!mb-[8rem] items-center">
			<div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] xl:px-0 lg:px-0 !px-[15px] max-w-full !mt-[50px]">
			  <div class="flex flex-wrap mx-[-15px] !mt-[-30px] !text-center">
				<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				  <div class="flex flex-wrap mx-[-15px]">
					<div class="w-full flex-[0_0_auto] !px-[15px] max-w-full">
					  <figure class="!rounded-[.4rem] !mb-6"><img class="!rounded-[.4rem]" src="assets/img/photos/se1.jpg" alt="image"></figure>
					</div>
					<!-- /column -->
					<div class="w-full flex-[0_0_auto] !px-[15px] max-w-full">
					  <div class="card !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
						<div class="card-body flex-[1_1_auto] p-[40px]">
						  <div class="icon btn btn-circle btn-lg btn-soft-purple pointer-events-none !mb-3 xl:!text-[1.3rem] w-12 h-12 lg:!text-[calc(1.255rem_+_0.06vw)] md:!text-[calc(1.255rem_+_0.06vw)] max-md:!text-[calc(1.255rem_+_0.06vw)] !inline-flex !items-center !justify-center !leading-none !p-0 !rounded-[100%]"> <i class="uil uil-monitor before:content-['\ec19']"></i> </div>
						  <h4 class="!text-[1rem] !leading-[1.45]">{!! t('Web Tasarım') !!}</h4>
						  <p class="!mb-2">{!! t('İşinizi bir üst seviyeye taşıyacak özgün ve modern web tasarımları üretiyoruz.') !!}</p>
						  <a href="#" class="more hover !text-[#e31e24] focus:!text-[#e31e24] hover:!text-[#e31e24]">{!! t('Detaylı Bilgi') !!}</a>
						</div>
						<!--/.card-body -->
					  </div>
					  <!--/.card -->
					</div>
					<!-- /column -->
				  </div>
				  <!-- /.row -->
				</div>
				<!-- /column -->
				<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
				  <div class="flex flex-wrap mx-[-15px]">
					<div class="w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!order-2 lg:!order-2 md:!order-2">
					  <figure class="!rounded-[.4rem] !mb-6 xl:!mb-0 lg:!mb-0 md:!mb-0"><img class="!rounded-[.4rem]" src="assets/img/photos/se2.jpg" alt="image"></figure>
					</div>
					<!-- /column -->
					<div class="w-full flex-[0_0_auto] !px-[15px] max-w-full">
					  <div class="card !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)] xl:!mb-6 lg:!mb-6 md:!mb-6 lg:!mt-6 xl:!mt-6">
						<div class="card-body flex-[1_1_auto] p-[40px]">
						  <div class="icon btn btn-circle btn-lg btn-danger pointer-events-none !mb-3 xl:!text-[1.3rem] w-12 h-12 lg:!text-[calc(1.255rem_+_0.06vw)] md:!text-[calc(1.255rem_+_0.06vw)] max-md:!text-[calc(1.255rem_+_0.06vw)] !inline-flex !items-center !justify-center !leading-none !p-0 !rounded-[100%]"> <i class="uil uil-mobile-android before:content-['\ec0a']"></i> </div>
						  <h4 class="!text-[1rem] !leading-[1.45]">{!! t('Mobil Tasarım') !!}</h4>
						  <p class="!mb-2">{!! t('Mobil cihazlara uygun yenilikçi ve kullanıcı dostu tasarımlar geliştiriyoruz.') !!}</p>
						  <a href="#" class="more hover !text-[#e31e24] focus:!text-[#e31e24] hover:!text-[#e31e24]">{!! t('Detaylı Bilgi') !!}</a>
						</div>
						<!--/.card-body -->
					  </div>
					  <!--/.card -->
					</div>
					<!-- /column -->
				  </div>
				  <!-- /.row -->
				</div>
				<!-- /column -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /column -->
			<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] xl:px-0 lg:px-0 !px-[15px] max-w-full xl:!ml-[8.33333333%] lg:!ml-[8.33333333%] !mt-[50px]">
			  <h2 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-bold !mb-3">{!! t('Ne Yapıyoruz?') !!}</h2>
			  <p class="lead !text-[1.1rem] !leading-[1.5] font-medium">{!! t('Sunduğumuz tüm hizmetler, iş gereksinimlerinizi en iyi şekilde karşılamak için özel olarak tasarlandı.') !!}</p>
			  <p>{!! t('Ekibimiz, markanız için uçtan uca dijital çözümler sunar. Akıllı teknolojiler ve kullanıcı deneyimini ön planda tutarak, işinize değer katıyoruz.') !!}</p>
			  <a href="#" class="btn btn-danger !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !text-[.85rem] !rounded-[50rem] !mt-3">{!! t('Daha Fazla Detay') !!}</a>
			</div>
			<!-- /column -->
		  </div>
		<div class="card !bg-[#f0f0f8] !rounded-[0.8rem] !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem]">
		<div class="card-body py-[4.5rem] xl:!px-0 lg:!px-0 px-[40px]">
			<div class="flex flex-wrap mx-[-15px] !text-center">
			<div class="lg:w-8/12 xl:w-8/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!ml-[16.66666667%] lg:!ml-[16.66666667%]">
				<h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem]">{!! t('Mutlu Müşteriler') !!}</h2>
				<h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-10 xxl:!px-10">{!! t('Sadece bizim sözümüze güvenmeyin, müşterilerimizin hakkımızda söylediklerini görün.') !!}</h3>
			</div>
			<!-- /column -->
			</div>
			<!-- /.row -->
			<div class="flex flex-wrap mx-[-15px] xl:mx-[-35px] lg:mx-[-20px] items-center">
			<div class="lg:w-5/12 xl:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !ml-auto hidden xl:!flex lg:!flex xl:!px-[35px] lg:!px-[20px]">
				<div class="img-mask mask-3"><img src="{{ setting('home_testimonials_image', asset('assets/img/photos/about28.jpg')) }}" alt="image"></div>
			</div>
			<!--/column -->
			<div class="lg:w-6/12 xl:w-6/12 xxl:w-5/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mr-auto xl:!px-[35px] lg:!px-[20px]">
				<div class="swiper-container dots-start dots-closer !mb-6 relative z-10 swiper-container-0" data-margin="30" data-dots="true">
				<div class="swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<span class="ratings inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five !mb-3"></span>
							<blockquote class="pl-0 text-[1.05rem] !mb-0 border-0 !leading-[1.7] font-medium m-[0_0_1rem]">
								<p>“{!! t('Dijital dönüşüm yolculuğumuzda yanımızda oldukları için mutluyuz. Profesyonel yaklaşımları ve çözüm odaklı çalışmaları ile projelerimize değer kattılar.') !!}”</p>
								<div class="flex items-center text-left">
									<div class="info !pl-0">
										<h5 class="!mb-1 text-[.95rem] !leading-[1.5]">Kerem Can Azak</h5>
										<p class="!mb-0 text-[.85rem]">Stellar Construction</p>
									</div>
								</div>
							</blockquote>
						</div>
						<!--/.swiper-slide -->
						<div class="swiper-slide">
							<span class="ratings inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five !mb-3"></span>
							<blockquote class="pl-0 text-[1.05rem] !mb-0 border-0 !leading-[1.7] font-medium m-[0_0_1rem]">
								<p>“{!! t('Eğitim teknolojileri alanındaki vizyoner bakış açıları ve teknik altyapı konusundaki uzmanlıkları sayesinde hedeflediğimiz kitleye çok daha etkili bir şekilde ulaştık.') !!}”</p>
								<div class="flex items-center text-left">
									<div class="info !pl-0">
										<h5 class="!mb-1 text-[.95rem] !leading-[1.5]">Servet Demir</h5>
										<p class="!mb-0 text-[.85rem]">Dijimind Akademi</p>
									</div>
								</div>
							</blockquote>
						</div>
						<!--/.swiper-slide -->
						<div class="swiper-slide">
							<span class="ratings inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five !mb-3"></span>
							<blockquote class="pl-0 text-[1.05rem] !mb-0 border-0 !leading-[1.7] font-medium m-[0_0_1rem]">
								<p>“{!! t('Akademik yayıncılık süreçlerimizi dijitalleştirirken sundukları yenilikçi çözümler ve hızlı destekleri için teşekkür ederiz. Güvenilir bir iş ortağı.') !!}”</p>
								<div class="flex items-center text-left">
									<div class="info !pl-0">
										<h5 class="!mb-1 text-[.95rem] !leading-[1.5]">A. Cezmi Savaş</h5>
										<p class="!mb-0 text-[.85rem]">Rhapsode Akademik Yayınevi</p>
									</div>
								</div>
							</blockquote>
						</div>
						<!--/.swiper-slide -->
					</div>
					<!--/.swiper-wrapper -->
				<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
				<!-- /.swiper -->
				<div class="swiper-controls"><div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span></div></div></div>
				<!-- /.swiper-container -->
			</div>
			<!--/column -->
			</div>
			<!--/.row -->
		</div>
		<!--/.card-body -->
		</div>
		<!--/.card -->
		
		<!--/.row -->
		
		<!-- /.row -->
		<div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] !mb-[5rem] xl:!mb-[8rem] lg:!mb-[8rem] md:!mb-[8rem]  items-center">
			<div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] px-[7.5px] !mt-[50px] max-w-full">
			  <figure class="m-0 p-0"><img class="w-auto" src="assets/img/illustrations/3d3.png" alt="image"></figure>
			</div>
			<!--/column -->
			<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] px-[7.5px] !mt-[50px] max-w-full xl:!ml-[8.33333333%] lg:!ml-[8.33333333%]">
			  <h2 class="!text-[0.8rem] !tracking-[0.02rem] !leading-[1.35] uppercase text-gradient gradient-1 !mb-3">{{ t('İletişim') }}</h2>
			  <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] font-semibold !leading-[1.25] !tracking-[normal] !mb-8">{{ t('Bir sorunuz mu var? Bizimle iletişime geçmekten çekinmeyin.') }}</h3>
			  <div class="flex flex-row">
				<div>
				  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 255.84" data-inject-url="https://Trunçgil-tailwind-template.netlify.app/assets/img/icons/solid/pin.svg" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-duo text-grape-fuchsia !mt-1 !mr-4"><path class="fill-secondary" d="M10.67 255.84a10.68 10.68 0 01-7.54-18.23l86.08-86a10.67 10.67 0 1115.08 15.1l-86.08 86a10.61 10.61 0 01-7.54 3.13z"></path><path class="fill-primary" d="M250.54 80.72L175.12 5.29a19.12 19.12 0 00-26.4 0L138.3 15.71a27.18 27.18 0 00-6.61 27.93A11.25 11.25 0 01129 55.21L98.38 85.79a13.3 13.3 0 01-9.38 3.9H76.46a29.11 29.11 0 00-20.73 8.59l-5.06 5.06a18.66 18.66 0 000 26.4l75.42 75.42a18.64 18.64 0 0026.4 0l5.06-5.07a29.12 29.12 0 008.59-20.73v-12.5a13.43 13.43 0 013.91-9.42l30.57-30.58a11.24 11.24 0 0111.57-2.74 27.14 27.14 0 0027.92-6.6l10.42-10.42a18.65 18.65 0 000-26.38z"></path></svg>
				</div>
				<div>
				  <h5 class="!mb-0">{{ t('Adres') }}</h5>
				  <address class=" not-italic !leading-[inherit] !mb-4">{{ t(setting('contact_address', 'Adres bilgisi yakında')) }}</address>
				</div>
			  </div>
			  <div class="flex flex-row">
				<div>
				  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256.01 256" data-inject-url="https://Trunçgil-tailwind-template.netlify.app/assets/img/icons/solid/rotary.svg" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-duo text-grape-fuchsia !mt-1 !mr-4"><path class="fill-secondary" d="M128 106.67a128.15 128.15 0 00-128 128A21.36 21.36 0 0021.34 256h213.32A21.36 21.36 0 00256 234.67c0-70.57-57.42-128-128-128zM128 224a42.67 42.67 0 1142.67-42.67A42.71 42.71 0 01128 224z"></path><path class="fill-primary" d="M33.45 117.34a22.89 22.89 0 01-12.56-3.69 50.7 50.7 0 01-6.61-5.12A43.84 43.84 0 01.74 68.3C5.45 43.31 33.27 27.06 53.8 17A169.32 169.32 0 01128 0c34.77 0 69.86 10.62 96.26 29.14 11.95 8.4 26.22 20.11 30.4 36.41a44 44 0 01-12.93 43 49.9 49.9 0 01-6.49 5 23.84 23.84 0 01-26.87-.76L171.1 86.18c-8.32-5.94-11.64-16.42-8.08-25.52.19-.53.41-1 .64-1.56a113 113 0 00-71.33 0l.67 1.54c3.57 9.1.22 19.6-8.08 25.52l-37.3 26.61a24.15 24.15 0 01-14.14 4.57z"></path></svg>
				</div>
				<div>
				  <h5 class="!mb-0">{{ t('Telefon') }}</h5>
				  <p>{{ t(setting('contact_phone', 'Telefon bilgisi yakında')) }}</p>
				</div>
			  </div>
			  <div class="flex flex-row">
				<div>
				  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 202.66" data-inject-url="https://Trunçgil-tailwind-template.netlify.app/assets/img/icons/solid/emails.svg" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem]  solid-duo text-grape-fuchsia !mt-1 !mr-4"><path class="fill-primary" d="M192 0H21.33A21.36 21.36 0 000 21.33v96a21.36 21.36 0 0021.33 21.33H192a21.36 21.36 0 0021.33-21.33v-96A21.36 21.36 0 00192 0zm0 48l-73.6 37.12A25.12 25.12 0 01106.67 88a24.39 24.39 0 01-11.84-3L21.34 48V30.08l80.85 40.75a9.64 9.64 0 008.85.11l81-40.86z"></path><path class="fill-secondary" d="M234.67 64v53.33A42.72 42.72 0 01192 160H42.67v21.33A21.36 21.36 0 0064 202.66h170.67A21.36 21.36 0 00256 181.33v-96A21.36 21.36 0 00234.67 64z"></path></svg>
				</div>
				<div>
				  <h5 class="!mb-0">{{ t('E-mail') }}</h5>
				  <p class="!mb-0"><a href="mailto:{{ t(setting('contact_email', 'E-mail bilgisi yakında')) }}" class="!text-[#60697b] hover:!text-[#60697b]">{{ t(setting('contact_email', 'E-mail bilgisi yakında')) }}</a></p>
				</div>
			  </div>
			</div>
			<!--/column -->
		  </div>
		<!-- /.row -->
	</div>
	<!-- /.container -->
	
	</section>
@endsection
