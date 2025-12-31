<header class="relative wrapper bg-soft-primary !bg-[#edf2fc]">
      <nav class="navbar navbar-expand-lg center-nav transparent navbar-light">
        <div class="container xl:!flex-row lg:!flex-row !flex-nowrap items-center">
          <div class="navbar-brand w-full">
            <a href="./">
              <img src="assets/img/truncgil-yatay.svg" alt="image">
            </a>
          </div>
          <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
            <div class="offcanvas-header xl:!hidden lg:!hidden flex items-center justify-between flex-row p-6">
              @include('components.custom.menu')
              
            </div>
            <div class="offcanvas-body xl:!ml-auto lg:!ml-auto flex  flex-col !h-full">
              @include('components.custom.menu')
              
            <!-- /.navbar-nav -->
          </div>
          <!-- /.navbar-other -->
          @include('components.custom.language-selector')
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
    </header>