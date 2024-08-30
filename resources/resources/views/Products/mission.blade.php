@section('title', 'Nhiệm vụ đổi xu - Mua tài nguyên giá rẻ')
@section('description', 'Cung cấp nhiệm vụ đổi xu từ các trang web uy tín như Netflix, Spotify, Apple Music, HBO Max, Disney+')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
    <div id="content">
        <div class="p-3">
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <p><em><strong>Hi chào bạn đã đến với website của chúng tôi. Nếu bạn không biết và gặp vấn đề về lúc làm nhiệm vụ hãy truy cập vào <a href="{{ route('faq') }}"><b>ĐÂY</b></a> để xem hướng dẫn làm nhiệm vụ. <br>
                                Nếu có vấn đề gì <a href="tel:+84345123856">Liên hệ SDT</a> hoặc <a href="https://zalo.me/0345123856">Zalo</a> admin để được hỗ trợ
                            </strong></p>

                    <div id="gtx-trans" style="left:1446px; position:absolute; top:-6px">
                        <div class="gtx-trans-icon">&nbsp;</div>
                    </div>
                </div>
            </div>
            @if(Auth::check() && Auth::user()->role_id <= 2)
                <div class="card border-0 shadow-sm mb-3">
                    <h5 class="card-header p-3">Thêm nhiệm vụ</h5>
                    <div class="card-body p-3">
                        <form action="{{ route('staff.add-mission') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p>Vui lòng điền đủ <strong>Nội dung</strong></p>
                            </div>
                            <div class="input-group mb-4">
                                <input type="text" id="title" name="title" placeholder="Tiêu đề nhiệm vụ" class="form-control me-3" required="">
                                <select class="form-select" id="type" name="type" required="">
                                    <option value="">-- Loại nhiệm vụ --</option>
                                    <option selected value="1">Vượt link</option>
                                    <option value="2">Tương tác</option>
                                </select>
                            </div>
                            <div class="input-group mb-4">
                                <input type="number" id="reward" name="reward" placeholder="Phần thưởng" class="form-control me-3" required="">
                                <select class="form-select" id="type_reward" name="type_reward" required="">
                                    <option value="">-- Loại thưởng --</option>
                                    <option value="1">Xu</option>
                                    <option value="2">Money</option>
                                </select>
                            </div>
                            <div class="input-group mb-4 linkrutgon">
                                <select class="form-select" id="type_link" name="type_link" required="">
                                    <option value="">-- Loại link rút gọn --</option>
                                    <option value="8Link">8Link</optpion>
                                    <option value="YeuMoney">YeuMoney</option>
                                </select>
                            </div>

                            <script>
                                $('#type').on('change', function() {
                                    var type_reward = $(this).val();
                                    if (type_reward == '1') {
                                        $('.linkrutgon').show();
                                    } else {
                                        $('.linkrutgon').hide();
                                    }
                                });
                            </script>
                            
                            <div class="col-12 col-lg-3">
                                <button class="btn btn-primary" style="font-size: 14px" type="submit"
                                    id="btnDepositOrder"><i class="fa-solid fa-file-invoice"></i>
                                    Tạo nhiệm vụ</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    $('#btnDepositOrder').on('click', function(e) {
                        e.preventDefault();
                        var title = $('#title').val();
                        var type = $('#type').val();
                        var reward = $('#reward').val();
                        var type_reward = $('#type_reward').val();
                        var type_link = $('#type_link').val();

                        if (title == '' || type == '' || reward == '' || type_reward == '' || type_link == '') {
                            cuteToast({
                                type: "error",
                                message: "Vui lòng điền đủ thông tin!",
                                timer: 3000
                            });
                            return false;
                        }
                        $(this).attr('disabled', 'disabled');
                        $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý');
                        var form = $(this).parents('form');
                        form.submit();
                    });
                </script>
            @endif
            <div class="card border-0 shadow-sm mb-3">
                <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                    Nhiệm vụ hiện có </h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table data-table table-hover mb-0">
                            <thead class="table-color-heading">
                                <tr>
                                    <th class="text-center">Mã nhiệm vụ</th>
                                    <th class="text-center">Tên nhiệm vụ</th>
                                    <th class="text-center">Loại nhiệm vụ</th>
                                    <th class="text-center">Phần thưởng</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thời gian</th>
                                    <th class="text-center">Thao tác</th>
                                    @if(Auth::check() && Auth::user()->role_id <= 2)
                                        <th class="text-center">Lượt click</th> 
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($missions as $mission)
                                    <tr>
                                        <td class="text-center">
                                            <a href="">#{{ $mission['id'] }}</a>
                                        </td>
                                        <td class="text-center"><b style="color: #6666FF;">{{ $mission['title'] }}</b></td>
                                        <td class="text-center"><b style="color: #6666FF;">{{ $mission['type'] }}</b></td>
                                        <td class="text-center"><span class="badge text-bg-success">{{ number_format($mission['reward']) . ' ' . $mission['type_reward'] }}</span></td>
                                        <td class="text-center"><span class="badge text-bg-{{ ($mission['status'] == 0) ? 'danger' : 'primary' }}">{{ ($mission['status'] == 0) ? 'Hết hạn' : 'Hiện còn' }}</span>
                                        </td>
                                        <td class="text-center">{{ $controller::convertTime($mission['created_at']) }}</td>
                                        <td class="text-center">
                                            @if(Auth::check())
                                                <a class="taking-mission" target="_blank" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Chi tiết hoá đơn"
                                                    href="{{ $mission['link'] }}">
                                                    Nhận
                                                </a>
                                            @else
                                                <a class="" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Chi tiết hoá đơn" href="{{ route('login') }}">
                                                    Nhận
                                                </a>
                                            @endif
                                        </td>
                                        @if(Auth::check() && Auth::user()->role_id <= 2)
                                            <td class="text-center"><b style="color: #6666FF;">{{ $mission['view'] }}</b></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="row">
                        {{ $missions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".taking-mission").on('click', function(e) {
                e.preventDefault();
                var link = $(this).attr('href');

                $.ajax({
                    url: "{{ route('process.taking-mission') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        link: link
                    },
                    success: function(data) {
                        if(data.status) {
                            window.open(link, '_blank');
                        } else {
                            cuteToast({
                                type: "error",
                                message: "Có vấn đề xảy ra, vui lòng thử lại sau!",
                                timer: 3000
                            }).then(() => {
                                location.reload();
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
