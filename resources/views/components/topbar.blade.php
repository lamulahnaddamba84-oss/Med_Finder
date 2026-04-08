<div class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
  <div class="container-fluid px-lg-0">
    <div class="d-flex align-items-center gap-4">
      <div class="d-block d-lg-none">
        <a class="text-inherit" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
        </a>
      </div>
      <div class="d-none d-lg-block">
        <a class="sidebar-toggle d-flex texttooltip p-3" href="javascript:void(0)" data-template="collapseMessage">
          <span class="collapse-mini">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 12l10 0" /><path d="M4 12l4 4" /><path d="M4 12l4 -4" /><path d="M20 4l0 16" /></svg>
          </span>
          <span class="collapse-expanded">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 12l-10 0" /><path d="M20 12l-4 4" /><path d="M20 12l-4 -4" /><path d="M4 4l0 16" /></svg>
          </span>
        </a>
      </div>
      <div>
        <p class="mb-0 small text-secondary">MedFinder control center</p>
        <h1 class="fs-5 mb-0">Locate medicine faster and coordinate pharmacy supply</h1>
      </div>
    </div>

    <div class="d-flex align-items-center gap-3 flex-wrap justify-content-end">
      <span class="badge bg-success-subtle text-success-emphasis px-3 py-2">Nearby pharmacies</span>
      <span class="badge bg-primary-subtle text-primary-emphasis px-3 py-2">Real-time reservations</span>
      @auth
        <div class="dropdown">
          <button class="btn btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><span class="dropdown-item-text text-secondary text-capitalize">{{ auth()->user()->role }}</span></li>
            <li><a class="dropdown-item" href="{{ route('dashboard') }}">My dashboard</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      @endauth
    </div>
  </div>
</div>
