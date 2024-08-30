@section('title', 'Thông tin tài khoản của ' . Auth::user()->username)
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
<div id="content">
    <div class="p-3">
        <div class="mb-3">
            <div class="row">
                {{-- <div class="col-sm-4 col-lg-4 mb-3 mb-sm-0">
                    <div class="card p-3">
                        <div class="card-body text-center">
                            <h4 class="mb-2 text-primary">{{ number_format($amount['total']) }}đ</h4>
                            
                            <h5 class="m-0">Tổng Tiền Nạp</h5>
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-4 col-lg-4 mb-3 mb-sm-0">
                    <div class="card p-3">
                        <div class="card-body text-center">
                            <h4 class="mb-2 text-success">
                                {{ $mission_count }}</h4>
                            
                            <h5 class="m-0">Nhiệm vụ đã làm</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="card p-3">
                        <div class="card-body text-center">
                            <h4 class="mb-2 text-warning">{{ number_format($amount['money']) }}đ</h4>
                            <h5 class="m-0">Số Dư Hiện Tại</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="card p-3">
                        <div class="card-body text-center">
                            <h4 class="mb-2 text-danger">{{ number_format($amount['coin']) }} xu</h4>
                            <h5 class="m-0">Xu hiện tại</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between p-3">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="" class="nav-link fw-bold active form-info">Thông Tin Cá
                                Nhân</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="" class="nav-link fw-bold form-changepass">Đổi mật khẩu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-block profile-info">
            <h5 class="card-header p-3">
                Thông Tin Cá Nhân </h5>
            <div class="card-body p-3">
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Bật thông báo nhiệm vụ</label>
                    <div class="col-lg-8 fv-row">
                        <input type="checkbox" class="btn-check" id="btn-check-2-outlined" {{ (Auth::user()->is_mission) ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary btn-ismission" for="btn-check-2-outlined">{{ (Auth::user()->is_mission) ? 'Đã bật' : 'Đã tắt' }}</label><br>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Họ và Tên</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" id="fullname" class="form-control" placeholder="Nhập họ và tên" value="{{ Auth::user()->fullName }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">Tên đăng nhập</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="hidden" id="token" value="812f6f561ab6091e64e910ca8de463bc">
                        <input type="text" class="form-control" value="{{ Auth::user()->username }}" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Số điện thoại</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Địa chỉ Email <b class="text-danger">(*)</b></label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" id="email" class="form-control" placeholder="Nhập địa chỉ Email" value="{{ Auth::user()->email }}" required="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        @if(Auth::user()->email_verified == 0)
                            <button class="input-group-text fw-bold verify-mail btn btn-danger" style="cursor: pointer" id="basic-addon2">Xác minh E-mail</button>
                            <div class="mb-3">
                                <p><b class="text-danger">Lưu ý: </b>Nếu bạn không nhận được email xác nhận, vui lòng vào thư rác để đưa thư ra ngoài</p>
                            </div>
                        @else
                            <button class="input-group-text fw-bold btn btn-success" style="cursor: not-allowed" id="basic-addon2">Đã xác minh</button>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">Thời gian đăng ký</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" class="form-control" value="{{ Auth::user()->created_at }}" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">Đăng nhập gần đây</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" class="form-control" value="{{ Auth::user()->last_login }}" readonly="">
                    </div>
                </div>
            </div>
            <div class="card-footer p-3">
                <button type="button" id="btnSaveProfile" class="btn btn-primary d-inline-flex align-items-center me-2">
                    <i class="fad fa-save me-2"></i>
                    <span>Lưu Thay Đổi</span>
                </button>
                <a type="button" href="{{ route('logout') }}" class="btn btn-danger d-inline-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>
        <div class="card card-block profile-password" style="display: none;">
            <h5 class="card-header p-3">
                Thông Tin Cá Nhân </h5>
            <div class="card-body p-3">
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Mật khẩu hiện tại</label>
                    <div class="col-lg-8 fv-row">
                        <input type="password" id="password" class="form-control" placeholder="Vui lòng nhập mật khẩu hiện tại" required="">
                        <input type="hidden" id="token" value="812f6f561ab6091e64e910ca8de463bc">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Mật khẩu mới</label>
                    <div class="col-lg-8 fv-row">
                        <input type="password" id="newpassword" class="form-control" placeholder="Vui lòng nhập mật khẩu mới" required="">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nhập lại mật khẩu mới</label>
                    <div class="col-lg-8 fv-row">
                        <input type="password" id="renewpassword" class="form-control" placeholder="Vui lòng nhập lại mật khẩu mới" required="">
                    </div>
                </div>
            </div>
            <div class="card-footer p-3">
                <button type="button" id="btnSavePassword" class="btn btn-primary d-inline-flex align-items-center me-2">
                    <i class="fad fa-save me-2"></i>
                    <span>Lưu Thay Đổi</span>
                </button>
                <a type="button" href="{{ route('logout') }}" class="btn btn-danger d-inline-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.form-changepass').click(function(e) {
            e.preventDefault();
            $('.profile-info').hide();
            $('.form-info').removeClass('active');
            $('.profile-password').show();
            $('.form-changepass').addClass('active');
        });

        $('.form-info').click(function(e) {
            e.preventDefault();
            $('.profile-info').show();
            $('.form-info').addClass('active');
            $('.profile-password').hide();
            $('.form-changepass').removeClass('active');
        });

        $('#btnSaveProfile').click(function() {
            var fullname = $('#fullname').val();
            var phone = $('#phone').val();
            var email = $('#email').val();

            if (fullname == '' || phone == '' || email == '') {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng nhập đầy đủ thông tin",
                    icon: "error"
                });
                return;
            }

            $(this).html('Đang lưu...');
            $(this).attr('disabled', true);
            NProgress.start();

            $.ajax({
                url: "{{ route('update-profile') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    fullname: fullname,
                    phone: phone,
                    email: email,
                    is_mission: ($('#btn-check-2-outlined').is(':checked')) ? 1 : 0
                },
                success: function(response) {
                    NProgress.done();
                    NProgress.remove();
                    $('#btnSaveProfile').html('Lưu Thay Đổi');
                    $('#btnSaveProfile').attr('disabled', false);
                    if (response.status == true) {
                        Swal.fire({
                            title: "Thành công",
                            text: "Cập nhật thông tin thành công",
                            icon: "success"
                        });
                        $('.btn-ismission').html(($('#btn-check-2-outlined').is(':checked')) ? 'Đã bật' : 'Đã tắt');
                    } else {
                        Swal.fire({
                            title: "Lỗi",
                            text: 'Cập nhật thông tin thất bại',
                            icon: "error"
                        });
                    }
                }
            });
        });

        $('.verify-mail').click(function() {
            var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (!regex.test($('#email').val())) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng nhập đúng định dạng email",
                    icon: "error"
                });
                return;
            }
            
            $(this).html('Đang xác minh...');
            $(this).attr('disabled', true);
            NProgress.start();
            $.ajax({
                url: "{{ route('verify-email') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    NProgress.done();
                    NProgress.remove();
                    $('.verify-mail').html('Đã gửi mã');
                    setTimeout(function() {
                        $('.verify-mail').html('Gửi lại mã');
                        $('.verify-mail').attr('disabled', false);
                    }, 5000);
                    if (response.status) {
                        Swal.fire({
                            title: "Thành công",
                            text: "Vui lòng kiểm tra email để xác minh",
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Lỗi",
                            text: response.message,
                            icon: "error"
                        });
                    }
                }
            });
        });

        $('#btnSavePassword').click(function() {
            var password = $('#password').val();
            var newpassword = $('#newpassword').val();
            var renewpassword = $('#renewpassword').val();
            var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

            if (password == '' || newpassword == '' || renewpassword == '') {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng nhập đầy đủ thông tin",
                    icon: "error"
                });
                return;
            }

            if (newpassword != renewpassword) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Mật khẩu nhập lại không khớp",
                    icon: "error"
                });
                return;
            }

            if (!regex.test(newpassword)) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Mật khẩu phải chứa ít nhất 1 chữ số, 1 chữ thường, 1 chữ hoa và từ 6-20 ký tự",
                    icon: "error"
                });
                return;
            }

            $(this).html('Đang lưu...');
            $(this).attr('disabled', true);
            NProgress.start();

            $.ajax({
                url: "{{ route('update-password') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    password: password,
                    newpassword: newpassword,
                    renewpassword: renewpassword
                },
                success: function(response) {
                    NProgress.done();
                    NProgress.remove();
                    $('#btnSavePassword').html('Lưu Thay Đổi');
                    $('#btnSavePassword').attr('disabled', false);
                    $('#password').val('');
                    $('#newpassword').val('');
                    $('#renewpassword').val('');
                    if (response.status) {
                        Swal.fire({
                            title: "Thành công",
                            text: "Cập nhật mật khẩu thành công",
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Lỗi",
                            text: response.message,
                            icon: "error"
                        });
                    }
                }
            });
        });

        $('#renewpassword').keypress(function(e) {
            if (e.which == 13) {
                $('#btnSavePassword').click();
            }
        });

        $('#fullname').keypress(function(e) {
            if (e.which == 13) {
                $('#btnSaveProfile').click();
            }
        });

        $('#phone').keypress(function(e) {
            if (e.which == 13) {
                $('#btnSaveProfile').click();
            }
        });

        $('#email').keypress(function(e) {
            if (e.which == 13) {
                $('#btnSaveProfile').click();
            }
        });
    });
</script>
@endsection