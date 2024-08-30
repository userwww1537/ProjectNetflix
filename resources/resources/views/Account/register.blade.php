@section('title', 'Đăng ký tài khoản - ' . config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
<div id="content">
    <div class="p-3 d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card shadow-sm col-12 col-lg-6">
            <h5 class="card-header p-4">Đăng ký</h5>
            <div class="card-body p-4">
                <div class="form-group mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" id="fullname" class="form-control" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" id="username" class="form-control" placeholder="Tên dùng để đăng nhập tài khoản, không được viết cách ra hoặc có dấu">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Địa chỉ email</label>
                    <input type="email" id="email" class="form-control" placeholder="Nhập địa chỉ email">
                </div>
                <div class="row mb-3">
                    <div class="form-group col-sm-6">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" id="repassword" class="form-control" placeholder="Nhập lại mật khẩu">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Người giới thiệu</label>
                    <input type="aff" id="aff" name="aff" class="form-control" placeholder="Người giới thiệu bạn (Có thể bỏ qua)" {{ (isset($_GET['aff'])) ? 'readonly' : '' }} value="{{ (isset($_GET['aff'])) ? $_GET['aff'] : '0345123856' }}">
                </div>
                <div class="form-group mb-3" style="display:none;">
                    <center>
                        <div class="g-recaptcha" id="g-recaptcha-response" data-sitekey=""></div>
                    </center>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="agree">
                    <label class="form-check-label" for="agree">
                        Đồng ý với <a href="#" class="text-decoration-none">
                            <span class="mb-1 mb-sm-0">
                                </span></a><a class="text-decoration-none text-danger" href=""><strong>Điều khoản</strong>
                                </a>
                                <span>&amp;</span>
                                <a class="text-decoration-none text-danger" href="">
                                    <strong>Bảo mật</strong></a>
                            
                         sử dụng dịch vụ                    </label>
                </div>
                <button id="btnRegister" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" type="button">
                    <strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong>
                    <span>Đăng ký<span>
                </span></span></button>
            </div>
            <div class="card-footer p-4 text-center">
                Bạn đã có tài khoản? <a class="text-decoration-none" href="{{ route('login') }}">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#btnRegister').click(function() {
            var fullname = $('#fullname').val();
            var username = $('#username').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var repassword = $('#repassword').val();
            var agree = $('#agree').is(':checked');
            var regexMail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var regexPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            var aff = $('#aff').val();

            if (username == '' || email == '' || password == '' || repassword == ''|| fullname == '') {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng nhập đầy đủ thông tin",
                    icon: "error"
                });
                return;
            }

            if(aff == ''){
                aff = '0345123856';
            }

            if (password != repassword) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Mật khẩu không khớp",
                    icon: "error"
                });
                return;
            }

            if (!agree) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng đồng ý với điều khoản sử dụng dịch vụ",
                    icon: "error"
                });
                return;
            }

            if (!regexMail.test(email)) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Địa chỉ email không hợp lệ",
                    icon: "error"
                });
                return;
            }

            if (!regexPass.test(password)) {
                Swal.fire({
                    title: "Lỗi",
                    text: "Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số",
                    icon: "error"
                });
                return;
            }

            $('#btnRegister').attr('disabled', true);

            $.ajax({
                url: "{{ route('process-register') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    fullName: fullname,
                    username: username,
                    email: email,
                    password: password,
                    aff: aff
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            title: "Thành công",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('login') }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Lỗi",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Lỗi",
                        text: "Có lỗi xảy ra, vui lòng thử lại sau",
                        icon: "error"
                    });
                },
                complete: function() {
                    $('#btnRegister').attr('disabled', false);
                }
            });
        });
    });
</script>
@endsection