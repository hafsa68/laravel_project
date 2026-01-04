<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">
    
@yield("head")

<body>

    <!-- Begin page -->
    <div class="layout-wrapper">

        <!-- ========== Left Sidebar ========== -->
       @include("backend.layouts.leftbar")
        

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <!-- ========== Topbar Start ========== -->
            @include("backend.layouts.header")
            <!-- ========== Topbar End ========== -->

            <div class="px-3">

                <!-- Start Content-->
                @yield("content")

                 <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            @include("backend.layouts.footer")
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- App js -->
    @yield("scripts")

</body>

</html>