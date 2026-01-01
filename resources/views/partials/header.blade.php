@php 
// Get menu items from Pages with nested children
$menuItems = \App\Models\Page::with(['children' => function ($query) {
    $query->where('status', 'published')
        ->where('show_in_menu', true)
        ->orderBy('sort_order', 'asc')
        ->orderBy('title', 'asc');
    }, 'children.children' => function ($query) {
        $query->where('status', 'published')
            ->where('show_in_menu', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc');
    }])
    ->whereNull('parent_id')
    ->where('status', 'published')
    ->where('show_in_menu', true)
    ->orderBy('sort_order', 'asc')
    ->orderBy('title', 'asc')
    ->get();

$midPoint = ceil($menuItems->count() / 2);
$leftMenuItems = $menuItems->slice(0, $midPoint);
$rightMenuItems = $menuItems->slice($midPoint);
@endphp
<header class="relative wrapper !bg-[#edf2fc]">
  <nav class="navbar navbar-expand-lg center-logo transparent position-absolute navbar-dark">
    <div class="container justify-between items-center">
      <div class="flex flex-row w-full justify-between items-center xl:!hidden lg:!hidden">
        <div class="navbar-brand"><a href="./">
            <img class="logo-dark" src="assets/img/truncgil-yatay.svg" alt="image">
            <img class="logo-light" src="assets/img/truncgil-yatay-dark.svg" alt="image">
          </a></div>
        <div class="navbar-other !ml-auto">
          <ul class="navbar-nav flex-row items-center">
            <li class="nav-item xl:!hidden lg:!hidden">
              <button class="hamburger offcanvas-nav-btn"><span></span></button>
            </li>
          </ul>
          <!-- /.navbar-nav -->
        </div>
        <!-- /.navbar-other -->
      </div>
      <!-- /.flex -->
      <div class="navbar-collapse-wrapper flex flex-row items-center w-full">
        <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
          <div class="offcanvas-header lg:mx-auto xl:mx-auto order-0 lg:!order-1 lg:!px-[5rem] xl:!order-1 xl:!px-[5rem] p-[1.5rem] !flex items-center justify-between flex-row">
            <a class="transition-none hidden lg:!flex xl:!flex" href="./"><img class="logo-dark" src="assets/img/truncgil-yatay.svg" alt="image">
              <img class="logo-light" src="assets/img/truncgil-yatay-dark.svg" alt="image"></a>
              
              
          </div>
          <div class="w-full order-1 lg:!order-none lg:!flex xl:!order-none xl:!flex offcanvas-body">
            <ul class="navbar-nav lg:!ml-auto xl:!ml-auto">                  
              @foreach($leftMenuItems as $item)
                  <x-front.menu-item :item="$item" />
              @endforeach
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <div class="w-full order-3 lg:!order-2 lg:!flex xl:!order-2 xl:!flex offcanvas-body">
            <ul class="navbar-nav lg:!mr-auto xl:!mr-auto">
              @foreach($rightMenuItems as $item)
                  <x-front.menu-item :item="$item" />
              @endforeach
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <div class="offcanvas-body xl:!hidden lg:!hidden order-4 !mt-auto">
            <div class="offcanvas-footer">
              <div>
                <a href="mailto:{{setting('contact_email')}}" class="link-inverse">{{setting('contact_email')}}</a>
                <br> <a href="tel:{{setting('contact_phone')}}">{{setting('contact_phone')}}</a> <br>
                <nav class="nav social social-white !mt-4">
                  <?php $social_media = json_decode(setting('social_links'), true); ?>
                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Twitter']) ? $social_media['Twitter'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-twitter before:content-['\ed59'] !text-white text-[1rem]"></i></a>
                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Facebook']) ? $social_media['Facebook'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-facebook-f before:content-['\eae2'] !text-white text-[1rem]"></i></a>
                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Github']) ? $social_media['Github'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-github before:content-['\eb40'] !text-white text-[1rem]"></i></a>
                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Instagram']) ? $social_media['Instagram'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-instagram before:content-['\eb9c'] !text-white text-[1rem]"></i></a>
                <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{ !empty($social_media['Youtube']) ? $social_media['Youtube'] : '#' }}" target="_blank" rel="noopener"><i class="uil uil-youtube before:content-['\edb5'] !text-white text-[1rem]"></i></a>
                </nav>
                <!-- /.social -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.navbar-collapse-wrapper -->
    </div>
    <!-- /.container -->
  </nav>
  <!-- /.navbar -->
</header>
