<header class="relative wrapper !bg-[#f0f0f8]">
    <nav class="navbar navbar-expand-lg center-nav transparent navbar-light">
        <div class="container xl:!flex-row lg:!flex-row !flex-nowrap items-center">
            <div class="navbar-brand w-full">
                <a href='{{ url('/') }}'>
                    <img src="{{ asset('html/assets/img/truncgil-yatay.svg') }}" alt="Trunçgil Teknoloji">
                </a>
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header xl:!hidden lg:!hidden flex items-center justify-between flex-row p-6">
                    <h3 class="text-white xl:!text-[1.5rem] !text-[calc(1.275rem_+_0.3vw)] !mb-0">Trunçgil</h3>
                    <button type="button" class="btn-close btn-close-white mr-[-0.75rem] m-0 p-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body xl:!ml-auto lg:!ml-auto flex flex-col !h-full">
                    
                    <x-custom.menu />
                    
                    <div class="offcanvas-footer xl:!hidden lg:!hidden">
                        <div>
                            <a href="mailto:info@truncgil.com" class="link-inverse">info@truncgil.com</a>
                            <br> 00 (123) 456 78 90 <br>
                            <nav class="nav social social-white !mt-4">
                                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-twitter before:content-['\ed59'] !text-white text-[1rem]"></i></a>
                                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-facebook-f before:content-['\eae2'] !text-white text-[1rem]"></i></a>
                                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-dribbble before:content-['\eaa2'] !text-white text-[1rem]"></i></a>
                                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-instagram before:content-['\eb9c'] !text-white text-[1rem]"></i></a>
                                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-youtube before:content-['\edb5'] !text-white text-[1rem]"></i></a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-other w-full !flex !ml-auto">
                <ul class="navbar-nav !flex-row !items-center !ml-auto">
                    <li class="nav-item hidden xl:block lg:block md:block">
                        <a href="#" class="btn btn-sm btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] rounded">Hemen Teklif Al</a>
                    </li>
                    <li class="nav-item xl:!hidden lg:!hidden">
                        <button class="hamburger offcanvas-nav-btn"><span></span></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>



