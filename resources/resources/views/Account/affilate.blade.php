@section('title', 'Cộng tác viên - ' . config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với
    giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
    <div id="content">
        @if(Auth::user()->phone)
            <div class="p-3">
                <div class="mb-3">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between p-3">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold active" data-bs-toggle="pill" data-bs-target="#tab-home"
                                        type="button" role="tab" aria-selected="true">TỔNG QUAN</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold" data-bs-toggle="pill" data-bs-target="#tab-member"
                                        type="button" role="tab" aria-selected="false" tabindex="-1">THÀNH VIÊN</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold" data-bs-toggle="pill" data-bs-target="#tab-ruttien"
                                        type="button" role="tab" aria-selected="false" tabindex="-1">RÚT TIỀN</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold" data-bs-toggle="pill" data-bs-target="#tab-lichsu"
                                        type="button" role="tab" aria-selected="false" tabindex="-1">LỊCH SỬ</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-home" role="tabpanel" tabindex="0">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                                    <div class="card overflow-hidden">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <p class="mb-2 text-secondary">TỔNG SỐ ĐĂNG KÝ</p>
                                                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            {{ $count['countUser'] }} users</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                                    <div class="card overflow-hidden">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <p class="mb-2 text-secondary">TỔNG TIỀN NGƯỜI ĐƯỢC GIỚI THIỆU ĐÃ NẠP</p>
                                                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            {{ number_format($count['countRecharge']) }}đ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card overflow-hidden">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <p class="mb-2 text-secondary">SỐ DƯ CỦA BẠN</p>
                                                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                        <h5 class="mb-0 font-weight-bold">
                                                            {{ number_format($count['countMoney']) }}đ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card mb-3">
                                    <h5 class="card-header p-3">THÔNG TIN CHI TIẾT</h5>
                                    <div class="card-body p-3">
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email">Email:</label>
                                            <div class="col-sm-8">
                                                <b> {{ Auth::user()->email }}</b>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center" for="email">Mức hoa
                                                hồng nạp tiền:</label>
                                            <div class="col-sm-8">
                                                <b style="color: red;">10%</b>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center" for="email">Mức hoa
                                                hồng giới thiệu:</label>
                                            <div class="col-sm-8">
                                                <b style="color: red;">1,000đ - 1 người được giới thiệu</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <h5 class="card-header p-3">LINK GIỚI THIỆU CỦA BẠN</h5>
                                    <div class="card-body p-3">
                                        <div class="input-group mb-4">
                                            <input type="text" class="form-control me-3" id="urlRef" readonly=""
                                                value="{{ url('/account/register?aff=' . Auth::user()->phone) }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary copy d-flex align-items-center"
                                                    data-clipboard-target="#urlRef"
                                                    onclick="copy()" type="button">
                                                    <i class="fad fa-paste me-2"></i>
                                                    COPY </button>
                                            </div>
                                        </div>
                                        <i>Sao chép địa chỉ này và chia sẻ đến bạn bè của bạn.</i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card overflow-hidden">
                                    <h5 class="card-header p-3">LƯU Ý</h5>
                                    <div class="card-body p-3">
                                        <p>Số điện thoại phải là số điện thoại của bạn, sài số giả không duyệt rút tiền.</p>
                                        <p>Cố tình lập tài khoản mới sẽ bị <b>khóa vĩnh viễn</b> tài khoản không có nhắc nhở.</p>

                                        <p><b>Hoa hồng nạp tiền</b> chỉ được tính khi người được giới thiệu nạp tiền trên web.</p>
                                        <p><b>Hoa hồng giới thiệu</b> chỉ được tính khi người được giới thiệu làm trên 5 nhiệm vụ.</p>

                                        <p>Việc xác định xem ai là người giới thiệu của một người dùng phụ thuộc hoàn toàn vào
                                            link giới thiệu. Nếu một người sử dụng link giới thiệu của bạn để tạo tài khoản thì bạn sẽ là người giới thiệu.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-member" role="tabpanel" tabindex="0">
                        <div class="card overflow-hidden">
                            <h5 class="card-header p-3">
                                DANH SÁCH BẠN BÈ ĐƯỢC BẠN GIỚI THIỆU </h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table data-table table-striped mb-0">
                                        <thead class="table-color-heading">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Tên đăng nhập</th>
                                                <th>Thời gian đăng ký</th>
                                                <th>Hoa hồng</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td><b style="color: green;">{{ number_format($user->hoa_hong) }}đ</b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-ruttien" role="tabpanel" tabindex="0">
                        <div class="row">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <div class="card overflow-hidden">
                                    <h5 class="card-header p-3">TẠO YÊU CẦU RÚT TIỀN</h5>
                                    <div class="card-body">
                                        <div class="form-group row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Ngân hàng:</label>
                                            <div class="col-lg-8 fv-row">
                                                <select class="form-control" id="bank">
                                                    <option value="">-- Chọn ngân hàng cần rút --</option>
                                                    <option value="1">MB Bank</option>
                                                    <option value="2">Vietcombank</option>
                                                    <option value="3">Sacombank</option>
                                                    <option value="4">Techcombank</option>
                                                    <option value="5">TP Bank</option>
                                                    <option value="6">Agribank</option>
                                                    <option value="7">Ví Momo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Số tài khoản:</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="stk" class="form-control"
                                                    placeholder="Nhập số tài khoản cần rút">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Chủ tài khoản:</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="name" class="form-control"
                                                    placeholder="Nhập tên chủ tài khoản">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Số tiền cần
                                                rút:</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="number" id="amount" class="form-control"
                                                    placeholder="Nhập số dư hoa hồng cần rút">

                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-lg-12 fv-row text-center">
                                                <input type="hidden" id="token" class="form-control"
                                                    value="f199f5618710869c12a5aeba4e89f096">
                                                <button type="button" id="btnRutTien" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-money-check-alt"></i>
                                                    RÚT NGAY</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card overflow-hidden">
                                    <h5 class="card-header p-3">THÔNG TIN CHI TIẾT</h5>
                                    <div class="card-body p-3">
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center"
                                                for="email">Email:</label>
                                            <div class="col-sm-8">
                                                <b> nguyentany.tricker@gmail.com</b>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center" for="email">Mức hoa
                                                hồng:</label>
                                            <div class="col-sm-8">
                                                <b style="color: red;">5%</b>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="control-label col-sm-4 align-self-center" for="email">Số dư hoa
                                                hồng khả dụng:</label>
                                            <div class="col-sm-8">
                                                <b style="color: blue;">0đ</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="card overflow-hidden">
                                <h5 class="card-header p-3">
                                    <b>DANH SÁCH RÚT TIỀN</b>
                                </h5>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table data-table table-striped mb-0">
                                            <thead class="table-color-heading">
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th>SỐ TIỀN RÚT</th>
                                                    <th>NGÂN HÀNG</th>
                                                    <th>THỜI GIAN</th>
                                                    <th>TRẠNG THÁI</th>
                                                    <th>LÝ DO</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-lichsu" role="tabpanel" tabindex="0">
                        <div class="card overflow-hidden">
                            <h5 class="card-header p-3">
                                LỊCH SỬ HOA HỒNG </h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table data-table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Số tiền trước</th>
                                                <th>Số tiền thay đổi</th>
                                                <th>Hoa hồng nhận được</th>
                                                <th>Thành viên</th>
                                                <th>Thời gian</th>
                                                <th>Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($history as $key => $his)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ number_format($his->money_before) }}đ</td>
                                                    <td>{{ number_format($his->money_change) }}đ</td>
                                                    <td>{{ number_format($his->amount) }}đ</td>
                                                    <td>{{ $his->username }}</td>
                                                    <td>{{ $his->created_at }}</td>
                                                    <td>{{ $his->content }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <script>
                if (confirm('Vui lòng cập nhật số điện thoại để sử dụng tính năng này')) {
                    window.location.href = '{{ route('profile') }}';
                } else {
                    window.location.href = '{{ route('home') }}';
                }
            </script>
        @endif
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        
        function copy() {
            var copyText = document.getElementById("urlRef");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            
            cuteToast({
                type: "success",
                message: "Đã sao chép vào bộ nhớ tạm",
                timer: 5000
            });
        }
    </script>
@endsection
