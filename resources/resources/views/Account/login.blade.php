@section('title', 'Đăng nhập tài khoản ' . config('app.name') . ' | ' . config('app.name') . ' - Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
<div id="content">
    <div class="p-3 d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card shadow-sm col-12 col-lg-6">
            <h5 class="card-header p-4">Đăng nhập</h5>
            <div class="card-body p-4">
                <div class="form-group mb-3">
                    <label class="form-label">Tên tài khoản</label>
                    <input type="text" id="username" class="form-control" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" onkeydown="handleKeyPress(event)">
                </div>
                <div class="form-group mb-3" style="display:none;">
                    <center>
                        <div class="g-recaptcha" id="g-recaptcha-response" data-sitekey=""></div>
                    </center>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('forgot') }}" class="text-decoration-none">Quên mật khẩu?</a>
                </div>
                <button id="btnLogin" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" type="button">
                    <strong class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></strong>
                    <span>Đăng nhập<span>
                </span></span></button>
            </div>
            <div class="card-footer p-4 text-center">
                Chưa có tài khoản? <a class="text-decoration-none" href="{{ route('register') }}">Đăng ký tài khoản</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#btnLogin').click(function() {
            var username = $('#username').val();
            var password = $('#password').val();

            if (username == '' || password == '') {
                Swal.fire({
                    title: "Lỗi",
                    text: "Vui lòng nhập đầy đủ thông tin",
                    icon: "error"
                });
                return;
            }

            $('#btnLogin').attr('disabled', true);

            $.ajax({
                url: "{{ route('process-login') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    username: username,
                    password: password
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            title: "Thành công",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('home') }}";
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
                    $('#btnLogin').attr('disabled', false);
                }
            });
        });
    });

    function handleKeyPress(e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            $('#btnLogin').click();
        }
    }
</script>
@endsection