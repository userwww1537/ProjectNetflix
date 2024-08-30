@section('title', 'Quên mật khẩu - '. config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
<div id="content">
    <div class="p-3 d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card shadow-sm col-12 col-md-6">
            <h5 class="card-header p-4">Quên mật khẩu</h5>
            <div class="card-body p-4">
                <div class="form-group mb-3">
                    <label class="form-label">Địa chỉ Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Nhập địa chỉ email đã đăng ký">
                </div>
                <div class="form-group mb-3" style="display:none;">
                    <center>
                        <div class="g-recaptcha" id="g-recaptcha-response" data-sitekey=""></div>
                    </center>
                </div>
                <button id="btnForgotPassword" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" type="button">
                    <strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong>
                    <span>Tìm mật khẩu<span>
                </span></span></button>
            </div>
            <div class="card-footer p-4 text-center">
                Đã có tài khoản? <a class="text-decoration-none" href="{{ route('login') }}">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#btnForgotPassword').click(function() {
            var email = $('#email').val();
            var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (email == '') {
                toastr.error('Vui lòng nhập địa chỉ email');
                return false;
            }
            if (!regex.test(email)) {
                toastr.error('Địa chỉ email không hợp lệ');
                return false;
            }
            $('#btnForgotPassword').attr('disabled', true);
            $('#btnForgotPassword').html('<strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong><span>Đang xử lý...</span>');
            NProgress.start();
            $.ajax({
                url: "{{ route('forgot-password') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email
                },
                success: function(response) {
                    NProgress.done();
                    NProgress.remove();
                    setTimeout(function() {
                        $('#btnForgotPassword').attr('disabled', false);
                        $('#btnForgotPassword').html('<strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong><span>Tìm mật khẩu</span>');
                    }, 3000);
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
                    $('#btnForgotPassword').attr('disabled', false);
                    $('#btnForgotPassword').html('<strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong><span>Tìm mật khẩu</span>');
                }
            });
        });
    });
</script>
@endsection