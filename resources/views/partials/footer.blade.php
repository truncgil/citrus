<footer class=" bg-[#21262c] opacity-100  !text-[#cacaca]">
	<div class="container py-16 xl:!py-20 lg:!py-20 md:!py-20">
	  <div class="flex flex-wrap mx-[-15px] !mt-[-30px] xl:!mt-0 lg:!mt-0">
		<div class="md:w-4/12 xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!mt-0 lg:!mt-0 !mt-[30px]">
		  <div class="widget !text-[#cacaca]">
			<img class="!mb-4" src="../../assets/img/truncgil-yatay-dark.svg" alt="image">
			<p class="!mb-4">© {{ date('Y') }} {{ t('Trunçgil Teknoloji') }}. <br class="hidden xl:block lg:block !text-[#cacaca]">{{ t('Tüm hakları saklıdır.') }}</p>
			<?php $social_media = json_decode(setting('social_links'), true); 
			?>
			<nav class="nav social social-white">
			  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Twitter']) ? $social_media['Twitter'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-twitter before:content-['\ed59'] !text-white text-[1rem]"></i></a>
			  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Facebook']) ? $social_media['Facebook'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-facebook-f before:content-['\eae2'] !text-white text-[1rem]"></i></a>
			  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Github']) ? $social_media['Github'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-github before:content-['\eb40'] !text-white text-[1rem]"></i></a>
			  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Instagram']) ? $social_media['Instagram'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-instagram before:content-['\eb9c'] !text-white text-[1rem]"></i></a>
			  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Youtube']) ? $social_media['Youtube'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-youtube before:content-['\edb5'] !text-white text-[1rem]"></i></a>
			</nav>
			<!-- /.social -->
		  </div>
		  <!-- /.widget -->
		</div>
		<!-- /column -->
		<div class="md:w-4/12 xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!mt-0 lg:!mt-0 !mt-[30px]">
		  <div class="widget !text-[#cacaca]">
			<h4 class="widget-title !text-white !mb-3">{{ t('İletişim') }}</h4>
			<address class="xl:!pr-20 xxl:!pr-28 not-italic !leading-[inherit] block !mb-4">{{ setting('contact_address') }}</address>
			<a class="!text-[#cacaca] hover:!text-[#e31e24]" href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a><br> {{ setting('contact_phone') }}
		  </div>
		  <!-- /.widget -->
		</div>
		<!-- /column -->
		<div class="md:w-4/12 xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!mt-0 lg:!mt-0 !mt-[30px]">
		  <div class="widget !text-[#cacaca]">
			<h4 class="widget-title !text-white !mb-3">{{ t('Daha Fazla Bilgi') }}</h4>
			<ul class="pl-0 list-none   !mb-0">
			  <li><a class="!text-[#cacaca] hover:!text-[#e31e24]" href="#">{{ t('Hakkımızda') }}</a></li>
			  <li class="!mt-[0.35rem]"><a class="!text-[#cacaca] hover:!text-[#e31e24]" href="#">{{ t('Hikayemiz') }}</a></li>
			  <li class="!mt-[0.35rem]"><a class="!text-[#cacaca] hover:!text-[#e31e24]" href="#">{{ t('Projelerimiz') }}</a></li>
			  <li class="!mt-[0.35rem]"><a class="!text-[#cacaca] hover:!text-[#e31e24]" href="#">{{ t('Kullanım Koşulları') }}</a></li>
			  <li class="!mt-[0.35rem]"><a class="!text-[#cacaca] hover:!text-[#e31e24]" href="#">{{ t('Gizlilik Politikası') }}</a></li>
			</ul>
		  </div>
		  <!-- /.widget -->
		</div>
		<!-- /column -->
		<div class="md:w-full xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!mt-0 lg:!mt-0 !mt-[30px]">
		  <div class="widget !text-[#cacaca]">
			<h4 class="widget-title !text-white !mb-3">{{ t('Bizimle İletişime Geçin') }}</h4>
			<p class="!mb-5">{{ t('Yeniliklerden haberdar olmak için bize e-posta adresinizi bırakın.') }}</p>
			<div class="newsletter-wrapper">
			  <!-- Begin Mailchimp Signup Form -->
			  <div id="mc_embed_signup">
				<form action="https://elemisfreebies.us20.list-manage.com/subscribe/post?u=aa4947f70a475ce162057838d&amp;id=b49ef47a9a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate dark-fields" target="_blank" novalidate="">
				  <div id="mc_embed_signup_scroll">
					<div class="!text-left input-group form-floating !relative flex flex-wrap items-stretch w-full">
					  <input type="email" value="" name="EMAIL" class="required email form-control block w-full text-[12px] font-medium !leading-[1.7] appearance-none bg-clip-padding shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] px-4 py-[0.6rem] rounded-[0.4rem] motion-reduce:transition-none     focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] disabled:bg-[#aab0bc] disabled:opacity-100 file:!mt-[-0.6rem] file:mr-[-1rem] file:!mb-[-0.6rem] file:ml-[-1rem] file:!text-[#60697b] file:bg-[#fefefe] file:pointer-events-none file:transition-all file:duration-[0.2s] file:ease-in-out file:px-4 file:py-[0.6rem] file:rounded-none motion-reduce:file:transition-none placeholder:!text-[#959ca9] placeholder:opacity-100 border border-solid !border-[rgba(255,255,255,0.1)] !text-[#cacaca]   bg-[rgba(255,255,255,.03)] focus-visible:!border-[rgba(63,120,224,0.5)]  " placeholder="" id="mce-EMAIL">
					  <label class="!ml-[0.05rem] !text-[#959ca9] text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none origin-[0_0] px-4 py-[0.6rem] left-0 top-0" for="mce-EMAIL">{{ t('E-posta Adresiniz') }}</label>
					  <input type="submit" value="{{ t('Abone Ol') }}" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24]   active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !relative z-[2] focus:z-[5] hover:!transform-none border-0">
					</div>
					<div id="mce-responses" class="clear">
					  <div class="response" id="mce-error-response" style="display:none"></div>
					  <div class="response" id="mce-success-response" style="display:none"></div>
					</div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ddc180777a163e0f9f66ee014_4b1bcfa0bc" tabindex="-1" value=""></div>
					<div class="clear"></div>
				  </div>
				</form>
			  </div>
			  <!--End mc_embed_signup-->
			</div>
			<!-- /.newsletter-wrapper -->
		  </div>
		  <!-- /.widget -->
		</div>
		<!-- /column -->
	  </div>
	  <!--/.row -->
	</div>
	<!-- /.container -->
  </footer>