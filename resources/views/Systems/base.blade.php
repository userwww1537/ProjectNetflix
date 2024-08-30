<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="canonical" href="https://cuahangmmo.pro.vn/" />
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')">
    <meta name="copyright" content="TaiNguyenNETPHICH.click cung cấp tài nguyên Netflix miễn phí" />
    <meta name="author" content="TnY" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://shop.muatainguyen.com/assets/storage/images/favicon_0TS.png" />
    <link rel="manifest" href="{{ asset('Icons/site.webmanifest') }}">
    <link rel="icon" href="https://shop.muatainguyen.com/assets/storage/images/favicon_0TS.png">
    <meta property="og:url" content="https://cuahangmmo.pro.vn">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="{{ asset('Icons/image_TPR.png') }}">
    <meta property="og:site_name" content="Cửa hàng MMO - Tài nguyên MMO giá rẻ">
    <meta property="article:section"
        content="Mua TN giá rẻ nhất thị trường! Hỗ trợ đặc quyền cho các nhà quảng cáo Online #1">
    <meta property="article:tag" content="shop clone, shop via, shop acc, shop bm, mua bm, mua via, mua clone">

    <link href="https://shop.muatainguyen.com/public/assets/dist/all.min.css" rel="stylesheet">
    <script src="https://shop.muatainguyen.com/resources/js/jquery.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweetalert2-->
    <link class="main-stylesheet" href="https://shop.muatainguyen.com/public/sweetalert2/default.css" rel="stylesheet"
        type="text/css">
    <script src="https://shop.muatainguyen.com/public/sweetalert2/sweetalert2.js"></script>
    <!-- Cute Alert -->
    <link class="main-stylesheet" href="https://shop.muatainguyen.com/public/cute-alert/style.css" rel="stylesheet"
        type="text/css">
    <script src="https://shop.muatainguyen.com/public/cute-alert/cute-alert.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://shop.muatainguyen.com/public/assets/js/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="google-site-verification" content="-PqKNNu_jw-3d0HLQhDuSFDnqjWvUIv24Yo2mJowbDg" />
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" rel="stylesheet" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BY12G9LZY5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-BY12G9LZY5');
    </script>


    @yield('css')
    <!-- Script Header -->
</head>
<style>
    .sidebar {

        overflow-y: hidden;

    }

    .sidebar.show-scroll-bar {
        overflow-y: scroll;
    }

    .pagination .active {
        background-color: #dadcde;
        border-radius: 10px;
    }
</style>
<script>
    function showScrollBar() {
        var sidebar = document.querySelector('.sidebar');
        sidebar.classList.add('show-scroll-bar');
    }

    function hideScrollBar() {
        var sidebar = document.querySelector('.sidebar');
        sidebar.classList.remove('show-scroll-bar');
    }
</script>

<body data-bs-theme="light" class="pb-5 mb-5 pb-lg-0 mb-lg-0">
    <div class="backdrop" onclick="closeMenu()">
        <button type="button"><i class="fas fa-times"></i></button>
    </div>

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

    <div id="panel" onmouseenter="showScrollBar()" class="sidebar" onmouseleave="hideScrollBar()"
        class="border-end shadow-sm">
        @if (!Auth::check())
            @if (Route::currentRouteName() == 'login')
                <div class="p-3">
                    <a class="d-block btn-nap text-decoration-none" href="{{ route('register') }}">
                        <span class="d-flex align-items-center justify-content-center">
                            <img src="https://shop.muatainguyen.com/public/assets/img/login.png" height="30"
                                class="me-2">
                            Đăng ký </span>
                        <span class="btn-nap2"></span>
                    </a>
                </div>
            @elseif(Route::currentRouteName() == 'register')
                <div class="p-3">
                    <a class="d-block btn-nap text-decoration-none" href="{{ route('login') }}">
                        <span class="d-flex align-items-center justify-content-center">
                            <img src="https://shop.muatainguyen.com/public/assets/img/login.png" height="30"
                                class="me-2">
                            Đăng nhập </span>
                        <span class="btn-nap2"></span>
                    </a>
                </div>
            @else
                <div class="p-3">
                    <a class="d-block btn-nap text-decoration-none" href="{{ route('login') }}">
                        <span class="d-flex align-items-center justify-content-center">
                            <img src="https://shop.muatainguyen.com/public/assets/img/login.png" height="30"
                                class="me-2">
                            Đăng nhập </span>
                        <span class="btn-nap2"></span>
                    </a>
                </div>
            @endif
        @else
            <div class="user p-3 position-relative">
                <a class="position-absolute top-0 bottom-0 start-0 end-0" href="{{ route('profile') }}"></a>
                <div class="avatar">
                    <img src="https://shop.muatainguyen.com/public/assets/img/avatar.png">
                </div>
                <div class="info">
                    <strong>{{ Auth::user()->fullName }} <br> ({{ $controller::checkRole()->role_display }})</strong>
                    <span class="mb-1">
                        <img src="https://cdn-icons-png.freepik.com/512/8107/8107808.png">
                        {{ number_format($controller::getWallet()->money) }}đ
                    </span>
                    <span class="mb-1">
                        <img src="https://shop.muatainguyen.com/public/assets/img/dollar.png">
                        {{ number_format($controller::getWallet()->coin) }} xu
                    </span>
                </div>
            </div>
            <div class="px-3 pt-1 pb-4">
                <a class="d-block btn-nap text-decoration-none" type="button" data-bs-toggle="modal"
                    data-bs-target="#recharge_popup">
                    <span class="d-flex align-items-center justify-content-center">
                        <img src="https://shop.muatainguyen.com/public/assets/img/wallet2.png" height="30"
                            class="me-2">
                        Nạp tiền </span>
                    <span class="btn-nap2"></span>
                </a>
            </div>
        @endif

        <nav>
            <div class="menu-divider border-top p-3">
                <span class="px-2">Hệ thống</span>
            </div>
            @if (Auth::check() && Auth::user()->role_id <= 2)
                <ul class="pb-3">
                    <li class="mx-3 mb-1 rounded {{ Route::currentRouteName() == 'staff.index' ? 'active' : '' }}">
                        <a href="{{ route('staff.index') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://static.vecteezy.com/system/resources/previews/035/896/670/original/admin-3d-illustration-icon-png.png"
                                height="30" width="30" class="me-3">Quản trị nhanh </a>
                    </li>
                </ul>
            @endif
            @if (Auth::check() && Auth::user()->role_id == 1)
                <ul class="pb-3">
                    <li class="mx-3 mb-1 rounded {{ Route::currentRouteName() == 'staff.notify' ? 'active' : '' }}">
                        <a href="{{ route('staff.notify') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/notification-bell-6335963-5220283.png?f=webp"
                                height="30" width="30" class="me-3">Quản trị thông báo </a>
                    </li>
                </ul>
            @endif
            <ul class="pb-3">
                <li class="mx-3 mb-1 rounded {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="d-block p-2 text-decoration-none">
                        <img src="https://cdn3d.iconscout.com/3d/free/thumb/free-netflix-2950136-2447898.png"
                            height="30" width="30" class="me-3">Hệ thống netflix </a>
                </li>
            </ul>
            @if (Auth::check())
                <div class="menu-divider border-top p-3">
                    <span class="px-2">Tài khoản</span>
                </div>
                <ul class="pb-3">
                    <li class="mx-3 mb-1 rounded {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}">
                        <a href="{{ route('profile') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://shop.muatainguyen.com/public/assets/img/profile.png" height="30"
                                width="30" class="me-3">Thông tin cá nhân </a>
                    </li>

                    <li class="mx-3 rounded {{ Route::currentRouteName() == 'orders' ? 'active' : '' }}">
                        <a href="{{ route('orders') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://shop.muatainguyen.com/public/assets/img/history.png" height="30"
                                width="30" class="me-3">Lịch sử giao dịch </a>
                    </li>
                    <li class="mx-3 rounded {{ Route::currentRouteName() == 'history' ? 'active' : '' }}">
                        <a href="{{ route('history') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/recycle-6855152-5625025.png"
                                height="30" width="30" class="me-3">Lịch sử nạp tiền </a>
                    </li>
                    <li class="mx-3 rounded {{ Route::currentRouteName() == 'affilate' ? 'active' : '' }}">
                        <a href="{{ route('affilate') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://shop.muatainguyen.com/public/assets/img/affiliate-marketing.png"
                                height="30" width="30" class="me-3">Cộng tác viên </a>
                    </li>

                </ul>
            @endif
            <div class="menu-divider border-top p-3">
                <span class="px-2">Công cụ</span>
            </div>
            <ul class="pb-3">

                <li class="mx-3 mb-1 rounded {{ Route::currentRouteName() == 'mission' ? 'active' : '' }}">
                    <a href="{{ route('mission') }}" class="d-block p-2 text-decoration-none">
                        <img src="https://png.pngtree.com/png-clipart/20230520/original/pngtree-d-gold-coin-dollar-us-currency-money-icon-sign-or-symbol-png-image_9165424.png"
                            height="30" width="30" class="me-3">Nhiệm vụ <b
                            class="text-danger">({{ $controller::countMission() }})</b></a>
                </li>
                <!-- <li class="mx-3 mb-1 rounded ">
                    <a href="https://shop.muatainguyen.com/client/icon-facebook" class="d-block p-2 text-decoration-none">
                        <img src="https://shop.muatainguyen.com/public/assets/img/icon-facebook.png" height="30" width="30"
                            class="me-3">Icon Facebook                    </a>
                </li> -->
                {{-- <li class="mx-3 mb-1 rounded ">
                    <a href="https://shop.muatainguyen.com/client/ephotor" class="d-block p-2 text-decoration-none">
                        <img src="https://shop.muatainguyen.com/public/assets/img/ephotor.png" height="30"
                            width="30" class="me-3">ePhotor </a>
                </li>
                <li class="mx-3 mb-1 rounded ">
                    <a href="https://shop.muatainguyen.com/client/batchwatermark"
                        class="d-block p-2 text-decoration-none">
                        <img src="https://shop.muatainguyen.com/public/assets/img/batchwatermark.png" height="30"
                            width="30" class="me-3">Chèn Watermark </a>
                </li> --}}

            </ul>
            <div class="menu-divider border-top p-3">
                <span class="px-2">Hỗ trợ</span>
            </div>
            <ul class="pb-3">
                <li class="mx-3 mb-1 rounded ">
                    <a href="{{ route('faq') }}" class="d-block p-2 text-decoration-none">
                        <img src="https://shop.muatainguyen.com/public/assets/img/question-mark.png" height="30"
                            width="30" class="me-3">FAQ </a>
                </li>
                <li class="mx-3 mb-1 rounded ">
                    <a href="" class="d-block p-2 text-decoration-none">
                        <img src="https://shop.muatainguyen.com/public/assets/img/contact.png" height="30"
                            width="30" class="me-3">Liên hệ </a>
                </li>
                @if (Auth::check() && Auth::user()->role_id == 1)
                    <li class="mx-3 mb-1 rounded ">
                        <a href="{{ route('admin.dashboard') }}" class="d-block p-2 text-decoration-none">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/admin-10681138-8625038.png?f=webp"
                                height="30" width="30" class="me-3">Quản trị admin </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <div class="modal fade" id="recharge_popup" tabindex="-1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Chọn phương thức nạp tiền</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pt-3 text-center mb-5">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 mb-3">
                                <div class="home-card two">
                                    <a href="{{ route('history') }}">
                                    </a>
                                    <div class="icon">
                                        <img src="https://shop.muatainguyen.com/public/assets/img/bank.png">
                                    </div>
                                    <div class="info">
                                        <h5 style="color: white;">Ngân
                                            hàng</h5>
                                        <span>Tự động cộng tiền
                                            trong vài giây</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function changeLanguage(id) {
            $.ajax({
                url: "https://shop.muatainguyen.com/ajaxs/client/changeLanguage.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    history.back();
                }
            });
        }
    </script>
    <script>
        function formatPrice(price) {
            return price.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function changeCurrency(id) {
            $.ajax({
                url: "https://shop.muatainguyen.com/ajaxs/client/changeCurrency.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    history.back();
                }
            });
        }
    </script>

    @yield('content')


    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.816) !important;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            z-index: 1041;
        }
    </style>
    @if (isset($is_notify) && $is_notify && Auth::check())
        <div class="modal fade show" id="notice_popup" tabindex="-1" aria-modal="true" role="dialog"
            style="display: block;">
            <div class="modal-backdrop fade show"></div>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="pt-3 text-center mb-5">
                            <!--Tiêu Đề -->
                            <h3><img src="https://shop.muatainguyen.com/assets/img/notification.svg" alt=""
                                    width="30">{{ $is_notify['title'] }}<img
                                    src="https://shop.muatainguyen.com/assets/img/notification.svg" alt=""
                                    width="30"></h3>
                        </div>
                        <div id="preview-body">
                            {!! $is_notify['body'] !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('process.da-xem-thong-bao', ['id' => $is_notify['id']]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Không hiển thị lại</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="mobile-nav" class="d-lg-none">
        <div class="row px-3">
            <div class="col p-0">
                <a href="javascript:;" onclick="toggleMenu()"
                    class="h-100 p-2 d-flex align-items-center justify-content-center text-decoration-none">
                    <span class="text-center text-dark fw-bold">
                        <i class="fas fa-ellipsis-h-alt fs-5 d-block"></i>
                        Menu </span>
                </a>
            </div>
            <div class="col p-0">
                <a href="/"
                    class="h-100 p-2 d-flex align-items-center justify-content-center text-decoration-none">
                    <span class="text-center text-dark fw-bold">
                        <i class="far fa-cookie fs-5 d-block"></i>
                        Nguyên liệu </span>
                </a>
            </div>
            @if (Auth::check())
                <div class="col p-0">
                    <a href=""
                        class="h-100 p-2 d-flex align-items-center justify-content-center text-decoration-none">
                        <span class="text-center text-dark fw-bold">
                            <i class="far fa-money-bill-wave-alt fs-5 d-block"></i>
                            Nạp tiền </span>
                    </a>
                </div>
            @else
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <a class="d-block btn-nap text-decoration-none" href="{{ route('login') }}"
                            style="width: 100%">
                            <span class="d-flex align-items-center justify-content-center">
                                Đăng nhập </span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://shop.muatainguyen.com/public/assets/dist/all.min.js"></script>

    <script>
        function toggleMenu() {
            $('body').toggleClass('show-menu')
        }

        function closeMenu() {
            $('body').removeClass('show-menu')
        }
    </script>
    <script type="text/javascript">
        function ShowModal_notice_popup() {
            $('#notice_popup').modal('show');
        }

        function formatNumber(input) {
            var value = input.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = value;
        }
    </script>

    @yield('script')
</body>


</html>
