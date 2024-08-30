@section('title', 'Quản trị gian hàng, công cụ của cộng tác viên ' . config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('css')
<style>
    .model-detail-gian-hang {
        position: fixed;
        z-index: 999999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        overflow-y: auto;
    }

    .model-detail-gian-hang .card {
        position: absolute;
        z-index: 9999999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        max-width: 800px;
    }

    .model-detail-gian-hang .btn-close {
        position: relative;
        right: 0;
        top: 0;
    }
</style>
@endsection
@section('content')
    <div id="content">
        <div class="p-3">
            @if(Auth::check() && Auth::user()->role_id <= 2)
                <div class="mb-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between p-3">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="" class="nav-link fw-bold active gianhang-btn">Thêm gian hàng</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="" class="nav-link fw-bold sanpham-btn">Thêm sản phẩm</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-3 gianhang-form">
                    <h5 class="card-header p-3">Thêm gian hàng mới</h5>
                    <div class="card-body p-3">
                        <form action="{{ route('staff.add-gian-hang') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p>Vui lòng điền đủ <strong>Nội dung</strong></p>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" id="title" name="title" placeholder="Tiêu đề" class="form-control me-3" required="">
                                <select class="form-select" id="category_id" name="category_id" required="">
                                    <option value="">-- Danh mục --</option>
                                    @foreach($sub_categories as $key => $sub_category)
                                        <option value="{{ $sub_category['id'] }}">{{ $sub_category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" id="price" name="price" placeholder="Mệnh giá tiền mua" class="form-control me-3" required="" oninput="formatNumber(this)">
                                <input type="text" id="coin" name="coin" placeholder="Mệnh giá xu mua" class="form-control me-3" required="">
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" id="country" name="country" placeholder="Thuộc quốc gia nào?" class="form-control me-3" required="">
                            </div>
                            <div class="input-group mb-4">
                                <textarea name="description" placeholder="Nếu như bạn muốn xuống dòng hãy thêm dấu , sau mỗi lần muốn xuống dòng" id="description" style="width: 100%;" rows="5"></textarea>
                            </div>
                            
                            <div class="col-12 col-lg-3">
                                <button class="btn btn-primary" style="font-size: 14px" type="submit"
                                    id="btnDepositOrder"><i class="fa-solid fa-file-invoice"></i>
                                    Tạo gian hàng</button>
                                <a href="{{ route('admin.reset-cookie') }}" class="btn btn-danger" style="font-size: 14px" type="submit"
                                    id="btnDepositOrder"><i class="fa-solid fa-file-invoice"></i>
                                    Reset Cookie</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-3 sanpham-form" style="display: none;">
                    <h5 class="card-header p-3">Thêm sản phẩm</h5>
                    <div class="card-body p-3">
                        <form action="{{ route('staff.add-product') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p>Lưu ý: <strong>Nếu sản phẩm là cookie thì chỉ cần dán toàn bộ cookie vào phần nội dung. Nếu là tài khoản vui lòng nhập định dạng sau: taikhoan@tany.com|matkhau123</strong></p>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" id="info" name="info" placeholder="Nội dung" class="form-control me-3" required="">
                                <input type="text" id="info" name="info_more" placeholder="Thông tin thêm (Có thể bỏ qua)" class="form-control me-3">
                            </div>
                            <div class="input-group mb-4">
                                <input type="number" id="product_id" name="product_id" placeholder="Mã gian hàng" class="form-control me-3" required="">
                                <input type="number" id="quantity" name="quantity" placeholder="Số lượng" min="1" class="form-control me-3" required="">
                            </div>
                            <div class="input-group mb-4 content-fetch" style="display: none;">
                                <input type="text" id="name-product-fetch" placeholder="Tên sản phẩm" class="form-control me-3" readonly>
                            </div>
                            
                            <div class="col-12 col-lg-3">
                                <button class="btn btn-primary" style="font-size: 14px" type="submit"
                                    id="btnDepositOrder"><i class="fa-solid fa-file-invoice"></i>
                                    Tạo sản phẩm</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="card border-0 shadow-sm mb-3">
                <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                    Sản phẩm hiện có </h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table data-table table-hover mb-0">
                            <thead class="table-color-heading">
                                <tr>
                                    <th class="text-center">Mã gian hàng</th>
                                    <th class="text-center">Tên gian hàng</th>
                                    <th class="text-center">Loại gian hàng</th>
                                    <th class="text-center">Số lượng Sp</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Người đăng</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <a href="https://shop.muatainguyen.com/client/payment/VF9613">#{{ $product['id'] }}</a>
                                        </td>
                                        <td class="text-center form-change-title-{{ $product['id'] }}" style="display: none;"><input type="text" data-id="{{ $product['id'] }}" class="btn-title" value="{{ $product['title'] }}"></td>
                                        <td class="text-center btn-change-title" data-prent="form-change-title-{{ $product['id'] }}"><b style="color: #6666FF;">{{ $product['title'] }}</b></td>
                                        <td class="text-center btn-change-category" data-prent="form-change-category-{{ $product['id'] }}"><b style="color: #6666FF;">{{ $product['category_name'] }}</b></td>
                                        <td class="text-center form-change-category-{{ $product['id'] }}" style="display: none;">
                                            <select class="form-select btn-category" name="category_id" data-id="{{ $product['id'] }}" required="">
                                                <option value="">-- Danh mục --</option>
                                                @foreach($sub_categories as $key => $sub_category)
                                                    <option value="{{ $sub_category['id'] }}">{{ $sub_category['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center"><span class="badge text-bg-success">{{ $product['stock'] }}</span></td>
                                        <td class="text-center">
                                            @if($product['status'] == 1 && $product['stock'] > 0)
                                                <span class="badge text-bg-primary">Còn hàng</span>
                                            @else
                                                <span class="badge text-bg-danger">Hết hàng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $product['user_name'] }}</td>
                                        <td class="text-center">
                                            <a class="detail-btn" target="_blank" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Chi tiết gian hàng"
                                                data-id="{{ $product['id'] }}"
                                                href="">
                                                Xem sản phẩm
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="row">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="model-detail-gian-hang">
        <div class="card border-0 shadow-sm mb-3">
            <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                Sản phẩm hiện có
                <button type="button" class="btn-close close-detail" data-bs-dismiss="modal" aria-label="Close"></button> </h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table data-table table-hover mb-0 table-gian-hang">
                        <thead class="table-color-heading">
                            <tr>
                                <th class="text-center">Tên gian hàng</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Thông tin</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Người đăng</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="details-gianhang">
                            {{-- <tr>
                                <td class="text-center"><b style="color: #6666FF;"></b></td>
                                <td class="text-center"><b style="color: #6666FF;"></b></td>
                                <td class="text-center"><span class="badge text-bg-success"></span></td>
                                <td class="text-center">
                                    <span class="badge text-bg-primary">Còn hàng</span>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <a class="" target="_blank" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Chi tiết hoá đơn"
                                        href="">
                                        Xem sản phẩm
                                    </a>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer p-3">
                <div class="row">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var count = 0, countCategory = 0;
            $('.close-detail').click(function() {
                $('.model-detail-gian-hang').hide();
            });
            $('.detail-btn').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    url: "{{ route('staff.fetch-gian-hang') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        detail: true
                    },
                    success: function(data) {
                        if(!data.status) {
                            Swal.fire({
                                title: "Lỗi",
                                text: "Gian hàng không tồn tại",
                                icon: "error"
                            });
                        } else {
                            $('#details-gianhang').html(data.html);
                            $('.model-detail-gian-hang').show();

                            $('.coppy-cookie').on('click', function() {
                                var text = $(this).data('text');
                                var $temp = $("<input>");
                                $("body").append($temp);
                                $temp.val(text).select();
                                document.execCommand("copy");
                                $temp.remove();
                                alert('Đã sao chép cookie');
                            });

                            $('.cookieDie-Btn').on('click', function() {
                                var id = $(this).data('id');
                                $.ajax({
                                    url: "{{ route('staff.cookie-die') }}",
                                    type: "post",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: id
                                    },
                                    success: function(data) {
                                        if(data.status) {
                                            Swal.fire({
                                                title: "Thành công",
                                                text: data.message,
                                                icon: "success"
                                            }).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "Lỗi",
                                                text: data.message,
                                                icon: "error"
                                            });
                                        }
                                    }
                                });
                            });
                        }
                    }
                });
            });
            $('.gianhang-btn').click(function(e) {
                e.preventDefault();
                $('.gianhang-form').show();
                $('.gianhang-btn').addClass('active');
                $('.sanpham-form').hide();
                $('.sanpham-btn').removeClass('active');
            });
            $('.sanpham-btn').click(function(e) {
                e.preventDefault();
                $('.gianhang-form').hide();
                $('.gianhang-btn').removeClass('active');
                $('.sanpham-form').show();
                $('.sanpham-btn').addClass('active');
            });
            $('#product_id').on('change', function() {
                var product_id = $('#product_id').val();

                $.ajax({
                    url: "{{ route('staff.fetch-gian-hang') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: product_id
                    },
                    success: function(data) {
                        if(!data.status) {
                            Swal.fire({
                                title: "Lỗi",
                                text: "Gian hàng không tồn tại",
                                icon: "error"
                            });
                        } else {
                            Swal.fire({
                                title: "Thành công",
                                text: data.message,
                                icon: "success"
                            });
                            $('#name-product-fetch').val('Tên gian hàng: ' + data.title);
                            $('.content-fetch').show();
                        }
                    }
                });
            });
            $('.btn-change-title').on('click', function() {
                count++;

                if(count % 2 == 0) {
                    var prent = $(this).data('prent');
                    $('.' + prent).show();
                    $(this).hide();

                    $('.btn-title').on('focusout', function() {
                        var id = $(this).data('id');
                        var title = $(this).val();

                        $(this).parent().hide();
                        $('.btn-change-title').show();

                        $.ajax({
                            url: "{{ route('staff.process-edit') }}",
                            type: "get",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                title: title
                            },
                            success: function(data) {
                                if(data.status) {
                                    Swal.fire({
                                        title: "Thành công",
                                        text: data.message,
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Lỗi",
                                        text: data.message,
                                        icon: "error"
                                    });
                                }
                            }, 
                            error: function() {
                                Swal.fire({
                                    title: "Lỗi",
                                    text: "Có lỗi xảy ra",
                                    icon: "error"
                                });
                            }
                        });
                    });
                }
            });
            $('.btn-change-category').on('click', function() {
                countCategory++;

                if(countCategory % 2 == 0) {
                    var prent = $(this).data('prent');
                    $('.' + prent).show();
                    $(this).hide();

                    $('.btn-category').on('change', function() {
                        var id = $(this).data('id');
                        var category_id = $(this).val();

                        $(this).parent().hide();
                        $('.btn-change-category').show();

                        $.ajax({
                            url: "{{ route('staff.process-edit') }}",
                            type: "get",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                category_id: category_id
                            },
                            success: function(data) {
                                if(data.status) {
                                    Swal.fire({
                                        title: "Thành công",
                                        text: data.message,
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Lỗi",
                                        text: data.message,
                                        icon: "error"
                                    });
                                }
                            }, 
                            error: function() {
                                Swal.fire({
                                    title: "Lỗi",
                                    text: "Có lỗi xảy ra",
                                    icon: "error"
                                });
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection
