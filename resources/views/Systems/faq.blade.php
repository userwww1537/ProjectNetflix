@section('title', 'Các câu hỏi thường gặp tại ' . config('app.name'))
@section('description', 'Trợ giúp người dùng giải đáp các thắc mắc thường gặp khi sử dụng ' . config('app.name'))
@extends('Systems.base')
@section('content')
    <div id="content">
        <div class="p-3">
            <div class="mb-3">
                <div class="card mb-3">
                    <h3 class="ms-3 mt-2">Câu hỏi thường gặp</h3>
                    <div class="card-header d-flex justify-content-between p-3">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="" class="nav-link fw-bold active howtousecookie-btn">Làm thế nào để sử dụng cookie?</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="" class="nav-link fw-bold howtovuotlink-btn">Làm thế nào để làm nhiệm vụ?</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-3 cookie-form" style="">
                <h5 class="card-header p-3">Làm thế nào để sử dụng cookie?</h5>
                <div class="card-body p-3">
                    <video width="100%" height="100%" controls>
                        <source src="{{ asset('Videos/CookieTutorial.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-3 vuotlink-form" style="display: none;">
                <h5 class="card-header p-3">Làm thế nào để làm nhiệm vụ?</h5>
                <div class="card-body p-3">
                    <video width="100%" height="100%" controls>
                        <source src="{{ asset('Videos/HuongDanLayXu.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.howtousecookie-btn').click(function(e) {
                e.preventDefault();
                $('.howtousecookie-btn').addClass('active');
                $('.howtousecookie').show();
                $('.howtovuotlink-btn').removeClass('active');
                $('.howtovuotlink').hide();

                $('.cookie-form').show();
                $('.vuotlink-form').hide();
            });

            $('.howtovuotlink-btn').click(function(e) {
                e.preventDefault();
                $('.howtovuotlink-btn').addClass('active');
                $('.howtovuotlink').show();
                $('.howtousecookie-btn').removeClass('active');
                $('.howtousecookie').hide();

                $('.cookie-form').hide();
                $('.vuotlink-form').show();
            });
        });
    </script>
@endsection
