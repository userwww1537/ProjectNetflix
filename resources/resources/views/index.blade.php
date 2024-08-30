@section('title', 'Trang chủ - ' . config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
    <div id="content">
        <div class="p-3">
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <p><em><strong>Hi chào bạn đã đến với website của chúng tôi. Nếu bạn cần về tài nguyên Netflix thì đây
                                chính là sự sáng suốt của bạn khi vào đây.
                                Nếu có vấn đề gì <a href="tel:+84345123856">Liên hệ SDT</a> hoặc <a href="https://zalo.me/0345123856">Zalo</a> admin để được hỗ trợ
                            </strong></p>

                    <div id="gtx-trans" style="left:1446px; position:absolute; top:-6px">
                        <div class="gtx-trans-icon">&nbsp;</div>
                    </div>
                </div>
            </div>

            @if(count($popular) > 0)
                <div class="home-heading d-flex justify-content-between align-items-center">
                    <h3 class="no-bg">
                        <img src="https://shop.muatainguyen.com/public/assets/img/star.png">
                        Sản phẩm bán chạy
                    </h3>
                    <div class="swiper-nav">
                        <div class="swiper-button prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="swiper-button next"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>
                <div id="popular-products" class="swiper">
                    <div class="swiper-wrapper">
                        @foreach($popular as $key => $product)
                            <div class="swiper-slide">
                                <div class="product">
                                    <div class="product-head">
                                        <img src="{{ asset('Categories/' . $product['category_image']) }}">
                                        <h4>{{ $product['title'] }}</h4>
                                    </div>
                                    <div class="product-body">
                                        @foreach($product['des'] as $description)
                                            <p><i class="fa-solid fa-circle-check"></i>
                                                {{ $description }}
                                            </p>
                                        @endforeach
                                    </div>
                                    <div class="product-footer">
                                        <div class="row">
                                            <div class="col-4 text-center border-end">
                                                <strong>Quốc gia</strong>
                                                <span>{{ $product['country'] }}</span>
                                            </div>
                                            <div class="col-4 text-center border-end">
                                                <strong>Hiện có</strong>
                                                <span class="badge text-bg-primary rounded-pill">{{ $product['stock'] }}</span>
                                            </div>
                                            <div class="col-4">
                                                <div class="price">
                                                    <strong>{{ $product['coin'] }}xu</strong>
                                                    <strong>{{ number_format($product['price']) }}đ</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($product['stock'] > 0 && $product['status'] == 1)
                                        <div class="product-buttons">
                                            <button type="button"
                                                onclick="modalBuy({{ $product['id'] }}, {{ $product['price'] }},`{{ $product['title'] }}`)"
                                                class="btn buy-btn">MUA
                                                NGAY</button>
                                        </div>
                                    @else
                                        <div class="product-buttons">
                                            <button type="button" disabled="" class="btn buy-btn">
                                                <i class="fas fa-frown mr-1"></i>HẾT
                                                HÀNG</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @endif
            <div class="home-heading"></div>

            <div class="search-form">
                <input type="text" placeholder="Nhập từ khóa tìm kiếm" id="keyword" onpaste="searchProduct()"
                    onkeyup="searchProduct()">
                <buton type="button" class="btn" onclick="searchProduct()">
                    <i class="fad fa-search me-0 me-sm-2"></i>
                    <span class="d-none d-sm-block">Tìm kiếm</span>
                </buton>
            </div>

            <nav class="product-tabs">
                <ul>
                    <li class="active" data-id="all">
                        Tất cả </li>
                    @foreach($categories as $category)
                        <li data-id="{{ $category['id'] }}">
                            {{ $category['name'] }} </li>
                    @endforeach
                </ul>
            </nav>

            @foreach($products as $key => $product)
                <div id="products" class="mb-3">
                    <div class="home-block" data-id="{{ $product[0]['parent_id'] }}" style>
                        <div class="home-heading">
                            <h3>
                                <img src="{{ asset('Categories/' . $product[0]['category_image']) }}">
                                {{ $key }}
                            </h3>
                        </div>
                        <div class="row row2">
                            @foreach($product as $key => $product)
                                <div class="prod-item col-sm-6 col-md-4" data-title="{{ $product['title'] }}">
                                    <div class="product">
                                        <div class="product-head">
                                            <img src="{{ asset('Categories/' . $product['category_image']) }}">
                                            <h4>{{ $product['title'] }}</h4>
                                        </div>
                                        <div class="product-body">
                                            @foreach($product['des'] as $description)
                                                <p><i class="fa-solid fa-circle-check"></i>
                                                    {{ $description }}
                                                </p>
                                            @endforeach
                                        </div>
                                        <div class="product-footer">
                                            <div class="row">
                                                <div class="col-4 text-center border-end">
                                                    <strong>Quốc gia</strong>
                                                    <span>{{ $product['country'] }}</span>
                                                </div>
                                                <div class="col-4 text-center border-end">
                                                    <strong>Hiện có</strong>
                                                    <span class="badge text-bg-primary rounded-pill">{{ $product['stock'] }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="price">
                                                        <strong>{{ $product['coin'] }}xu</strong>
                                                        <strong>{{ number_format($product['price']) }}đ</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($product['stock'] > 0 && $product['status'] == 1)
                                            <div class="product-buttons">
                                                <button type="button"
                                                    onclick="modalBuy({{ $product['id'] }}, {{ $product['price'] }},`{{ $product['title'] }}`)"
                                                    class="btn buy-btn">MUA
                                                    NGAY</button>
                                            </div>
                                        @else
                                            <div class="product-buttons">
                                                <button type="button" disabled="" class="btn buy-btn">
                                                    <i class="fas fa-frown mr-1"></i>HẾT
                                                    HÀNG</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="card overflow-hidden">
                        <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                            ĐƠN HÀNG GẦN ĐÂY </h5>
                        <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                            <div class="table-responsive">
                                <table class="table data-table table-hover mb-0">
                                    <tbody>
                                        @foreach($orderNearest as $key => $value)
                                            <tr>

                                                <td style="height:20px;">
                                                    <lord-icon src="https://cdn.lordicon.com/cllunfud.json" trigger="hover"
                                                        style="width:30px;height:30px">
                                                    </lord-icon> <b style="color: green;">{{ $value['fullName'] }}</b>
                                                    đã mua
                                                    <b>{{ $value['title'] }}</b>
                                                    - <b style="color:blue;">{{ ($value['payment_method'] == 'price') ? number_format($value['price']) . 'đ' : $value['coin'] . 'xu' }}</b>
                                                </td>
                                                <td><span class="badge text-bg-primary">{{ $controller::convertTime($value['created_at']) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card overflow-hidden">
                        <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                            CÀY NHIỆM VỤ GẦN ĐÂY </h5>
                        <div class="card-body p-0" style="height:500px;overflow-x:hidden;overflow-y:auto;">
                            <div class="table-responsive">
                                <table class="table data-table table-hover mb-0">
                                    <tbody>
                                        @foreach($cayxuNearest as $key => $value)
                                            <tr>
                                                <td style="height:20px;">

                                                    <lord-icon src="https://cdn.lordicon.com/ujmqspux.json" trigger="hover"
                                                        style="width:30px;height:30px">
                                                    </lord-icon> <b style="color: green;">{{ $value['fullName'] }}</b>
                                                    đã làm nhiệm vụ {{ $value['title'] }}, nhận được <b style="color:blue;">{{ $value['reward'] . $value['type_reward'] }}</b>
                                                    <b style="color:red;"></b>
                                                </td>
                                                <td><span class="badge text-bg-primary">{{ $controller::convertTime($value['created_at']) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer card mt-3">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-5 mb-4 border-bottom border-bottom-md-0 pb-4 pb-md-0 mb-md-0 pe-3">
                            <h5 class="mb-4 text-uppercase">Hệ Thống Chúng
                                Tôi</h5>
                            <ul>
                                <li>
                                    <i class="fab fa-facebook"></i>
                                    <span><a target="_blank"
                                            href="https://www.facebook.com/groups/sharecookienetflix">Cookie Netflix
                                            Share</a><span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 mb-4 border-bottom border-bottom-md-0 pb-4 pb-md-0 mb-md-0">
                            <h5 class="mb-4 text-uppercase">Hướng
                                dẫn</h5>
                            <ul>
                                <li><i class="far fa-question-square"></i><span><a href="">Cách sử dụng
                                            cookie</a></span></li>
                                <li><i class="fas fa-question"></i><span><a href="">Quy tắc bảo hành</a></span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-4">
                            <h5 class="mb-4 text-uppercase">Liên
                                hệ</h5>
                            <ul>
                                <li>
                                    <i class="fas fa-map-marked"></i>
                                    <span><strong>Địa Chỉ:</strong>
                                        Công viên phần mềm Quang Trung, Quận 12, TP. Hồ Chí Minh</span>
                                </li>
                                <li>
                                    <i class="fad fa-phone"></i>
                                    <span><strong>Phone:</strong>
                                        0345.123.856
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-envelope-open-text"></i>
                                    <span><strong>Email:</strong>
                                        <a href="mailto:cuahangmmovn@gmail.com">Cửa hàng MMO</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="card-footer px-4 py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <span class="mb-1 mb-sm-0">
                        Copyright © <strong> TnY</strong>
                    </span>
                    <span class="mb-1 mb-sm-0">
                        <a class="text-decoration-none text-danger" href=""><strong>Điều
                                khoản</strong> </a>
                        <span>&</span>
                        <a class="text-decoration-none text-danger" href="">
                            <strong>Bảo mật</strong></a>
                    </span>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModalPreview" class="modal fade">
            <div class="modal-dialog modal-xl modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titlePreview"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="imgpreviewbody">

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function removeVietnameseTones(str) {
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                str = str.replace(/đ/g, "d");
                str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
                str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
                str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
                str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
                str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
                str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
                str = str.replace(/Đ/g, "D");
                // Some system encode vietnamese combining accent as individual utf-8 characters
                // Một vài bộ encode coi các dấu mũ, dấu chữ như một kí tự riêng biệt nên thêm hai dòng này
                str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
                str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
                // Remove extra spaces
                // Bỏ các khoảng trắng liền nhau
                str = str.replace(/ + /g, " ");
                str = str.trim();
                // Remove punctuations
                // Bỏ dấu câu, kí tự đặc biệt
                str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g,
                    " ");
                return str;
            }


            jQuery(document).ready(function($) {

                var nice = $('#panel').niceScroll({
                    cursoropacitymin: 0,
                    cursoropacitymax: 0.2,
                    cursorcolor: '#000',
                    cursorwidth: '8px',
                    cursorborder: 0,
                    railpadding: {
                        top: 2,
                        left: 2,
                        right: 2,
                        bottom: 2
                    }
                })

                var swiper = new Swiper('#popular-products', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 5000
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button.next",
                        prevEl: ".swiper-button.prev",
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2,
                        },
                        992: {
                            slidesPerView: 3,
                        },
                        1824: {
                            slidesPerView: 4,
                        },
                    },
                })
            })


            $('body').on('click', '.preview-product', function() {

                var image = $(this).attr('href')
                var title = $(this).attr('data-title')

                $('#modalPreview .modal-title').text(title)
                $('#modalPreview .modal-body img').attr('src', image)

                $('#modalPreview').modal('show')

                return false;
            })

            function searchProduct() {

                var keyword = removeVietnameseTones($('#keyword').val().toLowerCase());

                if (keyword.length > 0) {

                    $('.home-block').hide();

                    $('div[data-title]').each(function() {

                        var title = removeVietnameseTones($(this).attr('data-title').toLowerCase().trim())

                        if (title.indexOf(keyword) !== -1) {
                            $(this).show();
                            $(this).parent().parent().show();
                        } else {
                            $(this).hide();
                        }

                    })

                } else {
                    $('.home-block').hide();
                    $('.home-block:not(.pin)').show();
                    $('div[data-title]').show();
                }

                return false;
            }

            $('body').on('click', '.product-tabs ul li', function() {

                var id = $(this).attr('data-id')

                if (id !== 'all') {
                    $('.home-block').hide();
                    $('.home-block[data-id="' + id + '"]').show();
                } else {
                    $('.home-block:not(.pin)').show();
                }

                $('.product-tabs ul li').removeClass('active')

                $(this).addClass('active')


            })
        </script>

        <div class="modal fade" id="modalBuy" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content"
                    style="background-image:url('https://shop.muatainguyen.com/assets/storage/images/bg_cardUK5.png');">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thanh toán đơn
                            hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Tên sản phẩm:</label>
                            <input type="text" class="form-control" id="name" readonly />
                        </div>
                        <div class="form-group mb-3 scan-here" style="display:none;">
                            <label>Nhập mã để quét:</label>
                            <input type="text" class="form-control" id="scan" name="scan" required />
                        </div>
                        <div class="form-group mb-3 amount-here">
                            <label>Số lượng cần mua:</label>
                            <input type="number" class="form-control form-control-solid" onchange="totalPayment()"
                                onkeyup="totalPayment()" placeholder="Nhập số lượng cần mua" id="amount" value="1" />
                            <input type="hidden" value readonly class="form-control" id="modal-id">
                            <input type="hidden" value readonly class="form-control" id="price">
                            <input class="form-control" type="hidden" id="token" value="{{ csrf_token() }}">
                        </div>
                        <div class="form-group mb-3" id="showDiscountCode">
                            <label>Mã giảm giá:</label>
                            <input type="text" class="form-control" onchange="totalPayment()"
                                onkeyup="totalPayment()" placeholder="Nhập mã giảm giá của bạn" id="coupon" />
                        </div>
                        <div class="mb-3 text-right">
                            <button id="btnshowDiscountCode" onclick="showDiscountCode()"
                                class="btn btn-danger btn-sm"><i class="fa-solid fa-tag"></i>
                                Nhập mã giảm giá </button>
                        </div>
                        <div class="mb-3 text-center" style="font-size: 20px;">Tổng tiền cần
                            thanh toán: <b id="total" style="color:red;">0</b></div>
                        <div class="mb-3 text-center">
                            <select class="form-select" id="paymentMethod">
                                <option value="0">Chọn phương thức thanh toán</option>
                                <option value="1">Tiền</option>
                                <option value="2">Xu</option>
                            </select>
                        </div>
                        <div class="text-center mb-3">
                            <div class="d-grid gap-2">
                                <button type="submit" id="btnBuy" onclick="buyProduct()"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"><i class="fas fa-money-bill-wave-alt me-2"></i>THANH
                                    TOÁN</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script type="text/javascript">
            function buyProduct() {
                var id = $("#modal-id").val();
                var amount = $("#amount").val();
                var token = $("#token").val();
                var paymentMethod = $("#paymentMethod").val();
                var total = $("#total").text();
                var scan = $("#scan").val();
                if(total == 0){
                    cuteToast({
                        type: "error",
                        message: 'Bạn chưa chọn sản phẩm hoặc số lượng sản phẩm không hợp lệ',
                        timer: 5000
                    });
                    return false;
                }
                if (paymentMethod == 0) {
                    cuteToast({
                        type: "error",
                        message: 'Vui lòng chọn phương thức thanh toán',
                        timer: 5000
                    });
                    return false;
                }
                if($('#name').val().includes('mã')) {
                    if(scan == '') {
                        cuteToast({
                            type: "error",
                            message: 'Vui lòng nhập mã để quét',
                            timer: 5000
                        });
                        return false;
                    } else {
                        if(scan.length != 8) {
                            cuteToast({
                                type: "error",
                                message: 'Mã quét không hợp lệ',
                                timer: 5000
                            });
                            return false;
                        }
                    }
                }
                $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
                $.ajax({
                    url: "{{ route('process.buy-now') }}",
                    method: "POST",
                    data: {
                        _token: token,
                        id: id,
                        coupon: $("#coupon").val(),
                        qty: amount,
                        paymentMethod: paymentMethod,
                        scan: scan
                    },
                    success: function(data) {
                        $('#btnBuy').html('<i class="fas fa-money-bill-wave-alt me-2"></i> Thanh Toán').prop(
                            'disabled', false);
                        if (data.status) {
                            cuteToast({
                                type: "success",
                                message: data.message,
                                timer: 5000
                            });
                            $urlReturn = "{{ route('orders') }}";
                            setTimeout("location.href = '" + $urlReturn + "';", 1000);
                        } else {
                            cuteToast({
                                type: "error",
                                message: data.message,
                                timer: 5000
                            });
                        }
                    },
                    error: function() {
                        $('#btnBuy').html('<i class="ri-bank-card-line me-2"></i> Thanh Toán').prop(
                            'disabled', false);
                        cuteToast({
                            type: "error",
                            message: 'Không thể xử lý',
                            timer: 5000
                        });
                    }
                });
            }
        </script>
        <script type="text/javascript">
            function modalBuy(id, price, name) {
                $("#modal-id").val(id);
                $("#price").val(price);
                $("#name").val(name);
                $("#amount").val('1');
                totalPayment();
                $('.scan-here input').val('');
                if($('#name').val().includes('mã')) {
                    $('.scan-here').show();
                    $('.amount-here').hide();
                } else {
                    $('.scan-here').hide();
                    $('.amount-here').show();
                }
                $("#modalBuy").modal('show');
            }

            document.getElementById('showDiscountCode').style.display = 'none';

            function showDiscountCode() {
                if (document.getElementById('showDiscountCode').style.display == 'none') {
                    document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-dark";
                    $('#btnshowDiscountCode').html('<i class="fa-solid fa-xmark"></i> Huỷ mã giảm giá');
                    document.getElementById('showDiscountCode').style.display = 'block';
                } else {
                    document.getElementById('btnshowDiscountCode').className = "btn btn-sm btn-danger";
                    $('#btnshowDiscountCode').html('<i class="fa-solid fa-tag"></i> Nhập mã giảm giá');
                    document.getElementById('showDiscountCode').style.display = 'none';
                    document.getElementById('coupon').value = '';
                    totalPayment();
                }
            }

            function totalPayment() {
                $('#total').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');
                $.ajax({
                    url: "{{ route('fetch-buy') }}",
                    method: "POST",
                    data: {
                        _token: $("#token").val(),
                        id: $("#modal-id").val(),
                        qty: $("#amount").val(),
                    },
                    success: function(data) {
                        if (data.status) {
                            $("#total").html(data.total);
                        } else {
                            $('#total').html('0');
                            cuteToast({
                                type: "error",
                                message: data.message,
                                timer: 5000
                            });
                        }
                    },
                    error: function() {
                        cuteToast({
                            type: "error",
                            message: 'Không thể tính kết quả thanh toán',
                            timer: 5000
                        });
                    }
                });
                //$("#total").html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
            }
        </script>
    @endsection
