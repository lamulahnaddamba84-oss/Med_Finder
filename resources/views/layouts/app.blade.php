<!DOCTYPE html>
<html lang="en">

<head>
    @include('shared.head-meta')
    <title>@yield('title', 'Med Finder Online - Pharmacy')</title>
    @include('shared.head-links')
</head>

<body>
  <div>
    @include('components.sidebar')

    <div id="content" class="position-relative h-100">
      @include('components.topbar')

      <div class="custom-container">
        @yield('content')
      </div>
    </div>
  </div>

  @include('shared.scripts')
  <script src="{{ asset('js/vendors/sidebarnav.js') }}"></script>
  <script src="{{ asset('libs/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('libs/jsvectormap/maps/world.js') }}"></script>
  <script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
  <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('js/vendors/chart.js') }}"></script>
  <script src="{{ asset('libs/choices/choices.min.js') }}"></script>
  <script src="{{ asset('js/vendors/choice.js') }}"></script>
  <script src="{{ asset('libs/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('js/vendors/swiper.js') }}"></script>

  <div class="text-center py-3 mt-5">
    <p class="mb-0">© All rights reserved by <a href="https://codescandy.com" target="_blank">CodesCandy</a>. Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>.</p>
  </div>
</body>

</html>
