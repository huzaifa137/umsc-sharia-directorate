<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- Keep logo SVG -->
        <svg width="26px" height="26px" viewBox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <!-- svg content omitted for brevity -->
        </svg>
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
      <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
    </a>
  </div>

  <div class="menu-divider mt-0"></div>
  <div class="menu-inner-shadow"></div>

</aside>