@section('title', 'Lịch sử mua hàng')
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
    <div id="content">
        <div class="p-3">
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <p><em><strong>Hi chào bạn đã đến với website của chúng tôi. Nếu bạn không biết và gặp vấn đề về sử dụng cookie hãy truy cập vào <a href="{{ route('faq') }}"><b>ĐÂY</b></a> để xem hướng dẫn sử dụng cookie của Website. <br>
                                Nếu có vấn đề gì <a href="tel:+84345123856">Liên hệ SDT</a> hoặc <a href="https://zalo.me/0345123856">Zalo</a> admin để được hỗ trợ
                            </strong></p>

                    <div id="gtx-trans" style="left:1446px; position:absolute; top:-6px">
                        <div class="gtx-trans-icon">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between p-3">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="" class="nav-link fw-bold active">LỊCH
                                    SỬ MUA HÀNG</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card overflow-hidden">
                <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                    Lịch Sử Mua Hàng <div class="">
                        <button class="btn btn-primary btn-sm d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#modal-default" type="button">
                            <i class="far fa-bug fw-normal me-1"></i>
                            <strong>Báo cáo vấn đề</strong>
                        </button>
                    </div>
                </h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table data-table table-hover mb-0">
                            <thead class="table-color-heading">
                                <tr>
                                    <th class="text-center">Mã giao dịch</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Dữ liệu</th>
                                    <th class="text-center">Thông tin thêm</th>
                                    <th class="text-center">Thanh toán</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->id }}</td>
                                        <td>{{ $order->title }}</td>
                                        <td class="text-center">@php
                                            if(stripos($order->information, '|') !== false) {
                                                echo $order->information;
                                            } else {
                                                echo '<button class="btn btn-sm btn-primary" onclick="coppyCookie(\'' . $order->information . '\')">Copy cookie</button>';
                                            } 
                                        @endphp</td>
                                        <td class="text-center">{{ ($order->info_more) ? $order->info_more : 'Rỗng' }}</td>
                                        <td class="text-center">{{ ($order->payment_method == 'price') ? number_format($order->price) . 'đ' : $order->coin . 'Xu' }}</td>
                                        <td class="text-center">{{ $order['status'] }}</td>
                                        <td class="text-center">{{ $controller::convertTime($order->created_at) }}</td>
                                        <td>
                                            <div class="    ">
                                                {{-- <button class="btn btn-sm btn-primary" onclick="downloadFile({{ $order->id }}, '{{ $order->token }}')">
                                                    <i class="fas fa-download"></i>
                                                </button> --}}
                                                @if($order['product_id'] == 14 || $order['product_id'] == 5)
                                                    <a class="btn btn-sm btn-danger" href="{{ route('report-order', $order->id) }}">
                                                        <i class="far fa-bug"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-danger" onclick="reportOrder({{ $order->id }})">
                                                        <i class="far fa-bug"></i>
                                                    </button>
                                                @endif                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="row">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Bạn muốn báo cáo?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Mã giao dịch</label>
                                <input type="text" id="uid_via" class="form-control"
                                    placeholder="Nhập mã giao dịch bạn muốn báo cáo">
                            </div>
                            <div class="form-group">
                                <label>Nội dung báo cáo</label>
                                <input type="text" id="content_report" class="form-control"
                                    placeholder="Nhập nội dung bạn muốn báo cáo với Admin">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" onclick="reportNow()" class="btn btn-primary">Báo cáo</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
@endsection
@section('script')
    <script src="https://shop.muatainguyen.com/public/assets/dist/all.min.js"></script>

    <script>
        function coppyCookie(cookie) {
            navigator.clipboard.writeText(cookie).then(function() {
                cuteToast({
                    type: "success",
                    message: "Đã copy vào clipboard",
                    timer: 5000
                });
            }, function(err) {
                cuteToast({
                    type: "error",
                    message: "Không thể copy vào clipboard",
                    timer: 5000
                });
            });
        }
    </script>



    <script>
        function toggleMenu() {
            $('body').toggleClass('show-menu')
        }

        function closeMenu() {
            $('body').removeClass('show-menu')
        }
    </script>


    <script type="text/javascript">
        function downloadFile(transid, token) {
            cuteAlert({
                type: "question",
                title: "Xác nhận tải về đơn hàng #" + transid,
                message: "Bạn có chắc chắn muốn tải về hàng này không",
                confirmText: "Đồng Ý",
                cancelText: "Hủy"
            }).then((e) => {
                if (e) {
                    $.ajax({
                        url: "https://shop.muatainguyen.com/ajaxs/client/downloadOrder.php",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            transid: transid,
                            token: token
                        },
                        success: function(respone) {
                            if (respone.status == 'success') {
                                cuteToast({
                                    type: "success",
                                    message: respone.msg,
                                    timer: 5000
                                });
                                downloadTXT(respone.filename, respone.accounts);
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
                            location.reload();
                        }
                    });
                }
            })
        }

        function reportNow() {
            if ($("#uid_via").val() == '') {
                return cuteAlert({
                    type: "error",
                    title: "Error",
                    message: "Vui lòng nhập mã cần báo cáo",
                    buttonText: "Okay"
                });
            }

            if($("#content_report").val() == '') {
                return cuteAlert({
                    type: "error",
                    title: "Error",
                    message: "Vui lòng nhập nội dung báo cáo",
                    buttonText: "Okay"
                });
            }
            window.location.href = "https://mail.google.com/mail/?view=cm&to=cuahangmmovn@gmail.com&su=Gửi báo cáo đơn hàng có ID:"
                + $("#uid_via").val() + "&body=" + $("#content_report").val();
        }

        function reportOrder(id) {
            cuteAlert({
                type: "question",
                title: "Xác nhận báo cáo đơn hàng bị lỗi #" + id,
                message: "Bạn có chắc chắn muốn báo cáo đơn hàng này không ?",
                confirmText: "Đồng Ý",
                cancelText: "Hủy"
            }).then((e) => {
                if (e) {
            window.location.href = "https://mail.google.com/mail/?view=cm&to=cuahangmmovn@gmail.com&su=Gửi báo cáo đơn hàng có ID:"
                + id + "&body=" + "Mình muốn báo cáo đơn hàng có ID: " + id + " với lý do: lỗi";
                }
            })
        }

        function downloadTXT(filename, text) {
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', filename);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
    </script>
@endsection
