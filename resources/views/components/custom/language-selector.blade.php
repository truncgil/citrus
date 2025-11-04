@php
    $languages = available_languages();
    $currentLang = current_language_code();
@endphp

<div class="navbar-other w-full !flex !ml-auto">
    <ul class="navbar-nav !flex-row !items-center !ml-auto">
      <li class="nav-item dropdown language-select uppercase group">
        <a class="nav-link dropdown-item dropdown-toggle xl:!text-[.85rem] lg:!text-[.85rem] max-lg:!text-[1.05rem]" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @php
              $currentLanguage = $languages->firstWhere('code', $currentLang);
          @endphp
          @if($currentLanguage)
            {{ $currentLanguage->flag ?? '' }} {{ strtoupper($currentLanguage->code) }}
          @else
            {{ strtoupper($currentLang) }}
          @endif
        </a>
        <ul class="dropdown-menu group-hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">
          @foreach($languages as $language)
            <li class="nav-item">
              <a class="dropdown-item hover:!text-[#747ed1] {{ $language->code === $currentLang ? 'active' : '' }}" 
                 href="{{ route('language.switch', $language->code) }}">
                {{ $language->flag ?? '' }} {{ strtoupper($language->code) }}
              </a>
            </li>
          @endforeach
        </ul>
      </li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-info"><i class="uil uil-info-circle before:content-['\eb99'] !text-[1.1rem]"></i></a></li>
      <li class="nav-item xl:!hidden lg:!hidden">
        <button class="hamburger offcanvas-nav-btn"><span></span></button>
      </li>
    </ul>
    <!-- /.navbar-nav -->
  </div>