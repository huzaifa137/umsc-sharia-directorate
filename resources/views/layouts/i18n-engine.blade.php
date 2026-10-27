@include('layouts.header')


<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Sidebar -->
        @include('layouts.side-bar-menu')
        <!-- / Sidebar -->

        <!-- Layout page -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.nav-bar')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                @yield('content')

                <div class="content-backdrop fade"></div>
            </div>
            <!-- / Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target -->
    <div class="drag-target"></div>
</div>

@include('layouts.footer')
@include('layouts.views.credentials-warning-modal')