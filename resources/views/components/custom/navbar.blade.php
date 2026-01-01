<div class="navbar-other w-full !flex !ml-auto">
            <ul class="navbar-nav !flex-row !items-center !ml-auto">
              <li class="nav-item">
                <nav class="nav social social-muted justify-end text-right">
                  <?php $social_media = json_decode(setting('social_links'), true); ?>
                  <a class="m-[0_0_0_.7rem] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ !empty($social_media['Twitter']) ? $social_media['Twitter'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-twitter before:content-['\ed59'] text-[1rem] !text-[#5daed5]"></i></a>
                  <a class="m-[0_0_0_.7rem] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ !empty($social_media['Facebook']) ? $social_media['Facebook'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-facebook-f before:content-['\eae2'] text-[1rem] !text-[#4470cf]"></i></a>
                  <a class="m-[0_0_0_.7rem] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ !empty($social_media['Github']) ? $social_media['Github'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-github before:content-['\eb40'] text-[1rem] !text-[#e94d88]"></i></a>
                  <a class="m-[0_0_0_.7rem] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 hover:translate-y-[-0.15rem]" href="{{ !empty($social_media['Instagram']) ? $social_media['Instagram'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-instagram before:content-['\eb9c'] text-[1rem] !text-[#d53581]"></i></a>
                </nav>
                <!-- /.social -->
              </li>
              <li class="nav-item xl:!hidden lg:!hidden">
                <button class="hamburger offcanvas-nav-btn"><span></span></button>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>