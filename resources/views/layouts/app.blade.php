<!DOCTYPE html>
<html lang="en">

<head>
    @include('shared.head-meta')
    <title>@yield('title', 'MedFinder')</title>
    @include('shared.head-links')
</head>

<body>
  <div>
    @include('components.sidebar')

    <div id="content" class="position-relative h-100">
      @include('components.topbar')

      <div class="custom-container py-4">
        @yield('content')
      </div>
    </div>
  </div>

  @include('shared.scripts')
  <script src="{{ asset('js/vendors/sidebarnav.js') }}"></script>

  <div class="text-center py-3 mt-5">
    <p class="mb-0">MedFinder helps people locate medicine across nearby pharmacies and reserve stock before they travel.</p>
  </div>
</body>

</html>
