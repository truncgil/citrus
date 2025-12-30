<header class="relative wrapper bg-soft-primary !bg-[#edf2fc]">
      <nav class="navbar navbar-expand-lg center-nav transparent navbar-light">
        <div class="container xl:!flex-row lg:!flex-row !flex-nowrap items-center">
          <div class="navbar-brand w-full">
            <a href='index.html'>
              <img src="assets/img/truncgil-yatay.svg" alt="image">
            </a>
          </div>
          <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
            <div class="offcanvas-header xl:!hidden lg:!hidden flex items-center justify-between flex-row p-6">
              
              
            </div>
            <div class="offcanvas-body xl:!ml-auto lg:!ml-auto flex  flex-col !h-full">
              <ul class="navbar-nav">
                @php
                    $productCategories = \App\Models\ProductCategory::with(['products' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get();
                @endphp
                <li class="nav-item dropdown dropdown-mega">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ürün ve Hizmetler</a>
                  <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
                    <li class="mega-menu-content mega-menu-scroll">
                      <ul class="grid grid-cols-1 xl:grid-cols-5 lg:grid-cols-5 mx-0 xl:mx-[-10px] lg:mx-[-10px] xl:!mt-[-10px] lg:!mt-[-10px] !pl-0 list-none">
                        @foreach($productCategories as $category)
                        <li class="xl:!px-[10px] xl:!mt-[10px] lg:!px-[10px] lg:!mt-[10px]">
                            <h6 class="dropdown-header !text-white !mb-2">{{ $category->title }}</h6>
                            <ul class="list-none pl-0">
                                @foreach($category->products as $product)
                                <li>
                                    <a class="dropdown-item !text-[#cacaca] hover:!text-white" href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                      </ul>
                      <!--/.row -->
                    </li>
                    <!--/.mega-menu-content-->
                  </ul>
                  <!--/.dropdown-menu -->
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Pages</a>
                  <ul class="dropdown-menu">
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Services</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='services.html'>Services I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='services2.html'>Services II</a></li>
                      </ul>
                    </li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">About</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='about.html'>About I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='about2.html'>About II</a></li>
                      </ul>
                    </li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Shop</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='shop.html'>Shop I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='shop2.html'>Shop II</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='shop-product.html'>Product Page</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='shop-cart.html'>Shopping Cart</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='shop-checkout.html'>Checkout</a></li>
                      </ul>
                    </li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Contact</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='contact.html'>Contact I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='contact2.html'>Contact II</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='contact3.html'>Contact III</a></li>
                      </ul>
                    </li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Career</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='career.html'>Job Listing I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='career2.html'>Job Listing II</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='career-job.html'>Job Description</a></li>
                      </ul>
                    </li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Utility</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='404.html'>404 Not Found</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='page-loader.html'>Page Loader</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='signin.html'>Sign In I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='signin2.html'>Sign In II</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='signup.html'>Sign Up I</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='signup2.html'>Sign Up II</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='terms.html'>Terms</a></li>
                      </ul>
                    </li>
                    <li class="nav-item"><a class='dropdown-item' href='pricing.html'>Pricing</a></li>
                    <li class="nav-item"><a class='dropdown-item' href='onepage.html'>One Page</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Projects</a>
                  <div class="dropdown-menu dropdown-lg">
                    <div class="dropdown-lg-content">
                      <div>
                        <h6 class="dropdown-header">Project Pages</h6>
                        <ul class="pl-0 list-none">
                          <li><a class='dropdown-item' href='projects.html'>Projects I</a></li>
                          <li><a class='dropdown-item' href='projects2.html'>Projects II</a></li>
                          <li><a class='dropdown-item' href='projects3.html'>Projects III</a></li>
                          <li><a class='dropdown-item' href='projects4.html'>Projects IV</a></li>
                        </ul>
                      </div>
                      <!-- /.column -->
                      <div>
                        <h6 class="dropdown-header">Single Projects</h6>
                        <ul class="pl-0 list-none">
                          <li><a class='dropdown-item' href='single-project.html'>Single Project I</a></li>
                          <li><a class='dropdown-item' href='single-project2.html'>Single Project II</a></li>
                          <li><a class='dropdown-item' href='single-project3.html'>Single Project III</a></li>
                          <li><a class='dropdown-item' href='single-project4.html'>Single Project IV</a></li>
                        </ul>
                      </div>
                      <!-- /.column -->
                    </div>
                    <!-- /auto-column -->
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Blog</a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a class='dropdown-item' href='blog.html'>Blog without Sidebar</a></li>
                    <li class="nav-item"><a class='dropdown-item' href='blog2.html'>Blog with Sidebar</a></li>
                    <li class="nav-item"><a class='dropdown-item' href='blog3.html'>Blog with Left Sidebar</a></li>
                    <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Blog Posts</a>
                      <ul class="dropdown-menu">
                        <li class="nav-item"><a class='dropdown-item' href='blog-post.html'>Post without Sidebar</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='blog-post2.html'>Post with Sidebar</a></li>
                        <li class="nav-item"><a class='dropdown-item' href='blog-post3.html'>Post with Left Sidebar</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown dropdown-mega">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Blocks</a>
                  <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
                    <li class="mega-menu-content">
                      <ul class="grid grid-cols-1 xl:grid-cols-6 lg:grid-cols-6 mx-0 xl:mx-[-15px] lg:mx-[-15px] xl:!mt-[-20px] lg:!mt-[-20px] !pl-0 list-none">
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/about.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block1.svg" alt="image"></div>
                            <span>About</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/blog.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block2.svg" alt="image"></div>
                            <span>Blog</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/call-to-action.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block3.svg" alt="image"></div>
                            <span>Call to Action</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/clients.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block4.svg" alt="image"></div>
                            <span>Clients</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/contact.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block5.svg" alt="image"></div>
                            <span>Contact</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/facts.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block6.svg" alt="image"></div>
                            <span>Facts</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/faq.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block7.svg" alt="image"></div>
                            <span>FAQ</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/features.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block8.svg" alt="image"></div>
                            <span>Features</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/footer.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block9.svg" alt="image"></div>
                            <span>Footer</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/hero.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block10.svg" alt="image"></div>
                            <span>Hero</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/misc.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block17.svg" alt="image"></div>
                            <span>Misc</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/navbar.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block11.svg" alt="image"></div>
                            <span>Navbar</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/portfolio.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block12.svg" alt="image"></div>
                            <span>Portfolio</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/pricing.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block13.svg" alt="image"></div>
                            <span>Pricing</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/process.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block14.svg" alt="image"></div>
                            <span>Process</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/team.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block15.svg" alt="image"></div>
                            <span>Team</span>
                          </a>
                        </li>
                        <li class="xl:!px-[15px] xl:!mt-[20px] lg:!px-[15px] lg:!mt-[20px]"><a class='dropdown-item' href='docs/blocks/testimonials.html'>
                            <div class="rounded img-svg hidden xl:block lg:block p-4 xl:!mb-2 lg:!mb-2"><img class="rounded-none" src="assets/img/demos/block16.svg" alt="image"></div>
                            <span>Testimonials</span>
                          </a>
                        </li>
                      </ul>
                      <!--/.row -->
                    </li>
                    <!--/.mega-menu-content-->
                  </ul>
                  <!--/.dropdown-menu -->
                </li>
                <li class="nav-item dropdown dropdown-mega">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Documentation</a>
                  <ul class="dropdown-menu mega-menu">
                    <li class="mega-menu-content">
                      <div class="flex flex-wrap mx-0 xl:mx-[-7.5px] lg:mx-[-7.5px]">
                        <div class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] max-w-full">
                          <h6 class="dropdown-header">Usage</h6>
                          <ul class="pl-0 list-none  xl:columns-2 lg:columns-2  xl:pb-1 lg:pb-1">
      <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/index.html'>Get Started</a></li>
      <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/forms.html'>Forms</a></li>
      <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/faq.html'>FAQ</a></li>
      <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/changelog.html'>Changelog</a></li>
      <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/credits.html'>Credits</a></li>
                          </ul>
                          <h6 class="dropdown-header xl:!mt-6 lg:!mt-6">Styleguide</h6>
                          <ul class="pl-0 list-none  xl:columns-2 lg:columns-2 ">
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/colors.html'>Colors</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/fonts.html'>Fonts</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/icons-svg.html'>SVG Icons</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/icons-font.html'>Font Icons</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/illustrations.html'>Illustrations</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/backgrounds.html'>Backgrounds</a></li>
    <li class=" xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item' href='docs/styleguide/misc.html'>Misc</a></li>
                          </ul>
                        </div>
                        <!--/column -->
                        <div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] max-w-full xl:border-l-[rgba(164,174,198,0.2)] xl:border-l xl:border-solid lg:border-l-[rgba(164,174,198,0.2)] lg:border-l lg:border-solid">
                          <h6 class="dropdown-header">Elements</h6>
                          <ul class="pl-0 list-none  xl:columns-3 lg:columns-3 ">
                            <li><a class='dropdown-item' href='docs/elements/accordion.html'>Accordion</a></li>
                            <li><a class='dropdown-item' href='docs/elements/alerts.html'>Alerts</a></li>
                            <li><a class='dropdown-item' href='docs/elements/animations.html'>Animations</a></li>
                            <li><a class='dropdown-item' href='docs/elements/avatars.html'>Avatars</a></li>
                            <li><a class='dropdown-item' href='docs/elements/background.html'>Background</a></li>
                            <li><a class='dropdown-item' href='docs/elements/badges.html'>Badges</a></li>
                            <li><a class='dropdown-item' href='docs/elements/buttons.html'>Buttons</a></li>
                            <li><a class='dropdown-item' href='docs/elements/card.html'>Card</a></li>
                            <li><a class='dropdown-item' href='docs/elements/carousel.html'>Carousel</a></li>
                            <li><a class='dropdown-item' href='docs/elements/dividers.html'>Dividers</a></li>
                            <li><a class='dropdown-item' href='docs/elements/form-elements.html'>Form Elements</a></li>
                            <li><a class='dropdown-item' href='docs/elements/image-hover.html'>Image Hover</a></li>
                            <li><a class='dropdown-item' href='docs/elements/image-mask.html'>Image Mask</a></li>
                            <li><a class='dropdown-item' href='docs/elements/lightbox.html'>Lightbox</a></li>
                            <li><a class='dropdown-item' href='docs/elements/player.html'>Media Player</a></li>
                            <li><a class='dropdown-item' href='docs/elements/modal.html'>Modal</a></li>
                            <li><a class='dropdown-item' href='docs/elements/pagination.html'>Pagination</a></li>
                            <li><a class='dropdown-item' href='docs/elements/progressbar.html'>Progressbar</a></li>
                            <li><a class='dropdown-item' href='docs/elements/shadows.html'>Shadows</a></li>
                            <li><a class='dropdown-item' href='docs/elements/shapes.html'>Shapes</a></li>
                            <li><a class='dropdown-item' href='docs/elements/tables.html'>Tables</a></li>
                            <li><a class='dropdown-item' href='docs/elements/tabs.html'>Tabs</a></li>
                            <li><a class='dropdown-item' href='docs/elements/text-animations.html'>Text Animations</a></li>
                            <li><a class='dropdown-item' href='docs/elements/text-highlight.html'>Text Highlight</a></li>
                            <li><a class='dropdown-item' href='docs/elements/tiles.html'>Tiles</a></li>
                            <li><a class='dropdown-item' href='docs/elements/tooltips-popovers.html'>Tooltips & Popovers</a></li>
                            <li><a class='dropdown-item' href='docs/elements/typography.html'>Typography</a></li>
                          </ul>
                        </div>
                        <!--/column -->
                      </div>
                      <!--/.row -->
                    </li>
                    <!--/.mega-menu-content-->
                  </ul>
                  <!--/.dropdown-menu -->
                </li>
              </ul>
              <!-- /.navbar-nav -->
              <div class="offcanvas-footer xl:!hidden lg:!hidden">
                <div>
                  <a href="mailto:first.last@email.com" class="link-inverse">info@truncgil.com</a>
                  <br> 00 (123) 456 78 90 <br>
                  <nav class="nav social social-white !mt-4">
                  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-twitter before:content-['\ed59'] !text-white text-[1rem]"></i></a>
                  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-facebook-f before:content-['\eae2'] !text-white text-[1rem]"></i></a>
                  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-dribbble before:content-['\eaa2'] !text-white text-[1rem]"></i></a>
                  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-instagram before:content-['\eb9c'] !text-white text-[1rem]"></i></a>
                  <a class="!text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="#"><i class="uil uil-youtube before:content-['\edb5'] !text-white text-[1rem]"></i></a>
                  </nav>
                  <!-- /.social -->
                </div>
              </div>
              <!-- /.offcanvas-footer -->
            </div>
            <!-- /.offcanvas-body -->
          </div>
          <!-- /.navbar-collapse -->
          <div class="navbar-other w-full !flex !ml-auto">
            <ul class="navbar-nav !flex-row !items-center !ml-auto">
              <li class="nav-item dropdown language-select uppercase group">
                <a class="nav-link dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">En</a>
                <ul class="dropdown-menu group-hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">
                  <li class="nav-item"><a class="dropdown-item hover:!text-[#3f78e0] hover:bg-[inherit] " href="#">En</a></li>
                  <li class="nav-item"><a class="dropdown-item hover:!text-[#3f78e0] hover:bg-[inherit] " href="#">De</a></li>
                  <li class="nav-item"><a class="dropdown-item hover:!text-[#3f78e0] hover:bg-[inherit] " href="#">Es</a></li>
                </ul>
              </li>
              <li class="nav-item hidden xl:block lg:block md:block">
                <a class='btn btn-sm btn-primary !text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:!border-[#3f78e0]   active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]' href='contact.html'>Contact</a>
              </li>
              <li class="nav-item xl:!hidden lg:!hidden">
                <button class="hamburger offcanvas-nav-btn"><span></span></button>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
    </header>