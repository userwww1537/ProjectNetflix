<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cửa hàng MMO - Quản trị</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('Icons/icon.png') }}" type="image/x-icon" />
    <script src="https://kit.fontawesome.com/c9111ed195.js" crossorigin="anonymous"></script>

    <!-- Fonts and icons -->
    <script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/js/plugin/webfont/webfont.min.js"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <link class="main-stylesheet" href="https://shop.muatainguyen.com/public/cute-alert/style.css" rel="stylesheet"
        type="text/css">
    <script src="https://shop.muatainguyen.com/public/cute-alert/cute-alert.js"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('style')
</head>

<body>
    @if (session('success'))
        <script>
            cuteToast({
                type: "success",
                message: "{{ session('success') }}",
                timer: 5000
            });
        </script>
    @elseif(session('error'))
        <script>
            cuteToast({
                type: "error",
                message: "{{ session('error') }}",
                timer: 5000
            });
        </script>
    @endif
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.layout.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('admin.layout.header')

            <div class="container">
                @yield('content')
            </div>

            @include('admin.layout.footer')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
    @yield('script')
    <script>
        function formatPrice(price) {
            return price.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</body>

</html>
