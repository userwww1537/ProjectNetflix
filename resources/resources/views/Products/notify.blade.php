@section('title', 'Quản trị thông báo chung, công cụ của cộng tác viên ' . config('app.name'))
@section('description', 'Cung cấp tài nguyên Netflix, Spotify, Apple Music, HBO Max, Disney+ và nhiều tài khoản khác với giá rẻ nhất thị trường')
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('css')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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
                <form method="post" action="{{ route('staff.them-thong-bao') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card border-0 shadow-sm mb-3 gianhang-form">
                        <div class="card shadow">
                            <div class="card-header">
                                <h4 class="card-title"> Thêm thông báo mới </h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label> Tiêu đề </label>
                                    <input type="text" class="form-control" name="title" placeholder="Tiêu đề thông báo">
                                </div>
                                <div class="form-group">
                                    <label> Nội dung </label>
                                    <textarea class="form-control" id="body" placeholder="Nội dung thông báo" name="body"></textarea>
                                </div>
                            </div>
                            <div class="card-footer"> 
                                <button type="submit" class="btn btn-success"> Save </button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
            <div class="card border-0 shadow-sm mb-3">
                <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                    Sản phẩm hiện có </h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table data-table table-hover mb-0">
                            <thead class="table-color-heading">
                                <tr>
                                    <th class="text-center">Mã thông báo</th>
                                    <th class="text-center">Tiêu đề</th>
                                    <th class="text-center">Lượt người tiếp cận</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Người đăng</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notify as $item)
                                    <tr>
                                        <td class="text-center">
                                            <a href="https://shop.muatainguyen.com/client/payment/VF9613">#{{ $item['id'] }}</a>
                                        </td>
                                        <td class="text-center btn-change-title" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item['body'] }}"><b style="color: #6666FF;">{!! $item['title'] !!}</b></td>
                                        <td class="text-center"><span class="badge text-bg-success">{{ $item['traffic'] }}</span></td>
                                        <td class="text-center">
                                            @if($item['status'] == 1)
                                                <span class="badge text-bg-primary btn-change-status" data-id="{{ $item['id'] }}">Đang hiện</span>
                                            @else
                                                <span class="badge text-bg-danger btn-change-status" data-id="{{ $item['id'] }}">Đang ẩn</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item['user_name'] }}</td>
                                        <td class="text-center">
                                            <a class="detail-btn" target="_blank" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Chi tiết gian hàng"
                                                data-id="{{ $item['id'] }}"
                                                href="">
                                                Preview
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
                        {{ $notify->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="notice_preview" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-backdrop fade show"></div>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-body">
                        <div class="pt-3 text-center mb-5">
                            <h3><img src="https://shop.muatainguyen.com/assets/img/notification.svg" alt="" width="30"><span id="preview-title">Thông Báo Toàn Hệ Thống</span><img src="https://shop.muatainguyen.com/assets/img/notification.svg" alt="" width="30"></h3>
                        </div>
                        <div id="preview-body">
                            <p>Link đổi Pass tránh Checkpoint: <span style="color:#009900"><strong>https://www.facebook.com/privacy/review/?review_id=573933453011661&amp;source=unknown</strong></span></p>
    
                            <p>Mua via hạn chế đổi info tránh Die, BẮT BUỘC đổi Mật khẩu via và Mật Khẩu mail</p>
    
                            <p>HỖ TRỢ BẢO HÀNH TẠI:&nbsp;<a href="https://www.facebook.com/hieunguyen.jc">FB: Hieu Nguyen( CLICK VÀO ĐÂY )</a></p>
    
                            <p><span style="color:#cc0000"><strong>Tất cả tài nguyên trên website chỉ phục vụ với mục đích QUẢNG CÁO. Tất cả hành vi sử dụng vi phạm nào trái pháp luật Việt Nam, chúng tôi đều không chịu bất cứ trách nhiệm nào</strong></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" method="">
                            <button type="submit" class="btn btn-danger btn-sm" name="hide_notice_popup">Thoát</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
            console.error( error );
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.detail-btn').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('staff.get-notify') }}',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(data) {
                        $('#preview-title').html(data.title);
                        $('#preview-body').html(data.body);
                        $('#notice_preview').modal('show');
                    }
                });
            });

            $('.btn-change-status').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('staff.change-notify-status') }}',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(data) {
                        if(data.status == 1) {

                            var status = document.querySelectorAll('.btn-change-status');
                            status.forEach(function(item) {
                                if(item.getAttribute('data-id') == id) {
                                    item.innerHTML = 'Đang hiện';
                                    item.classList.remove('text-bg-danger');
                                    item.classList.add('text-bg-primary');
                                } else {
                                    item.innerHTML = 'Đang ẩn';
                                    item.classList.remove('text-bg-primary');
                                    item.classList.add('text-bg-danger');
                                }
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message
                            });
                        } else if(data.status == 0) {
                            $('.btn-change-status[data-id="'+id+'"]').html('Đang ẩn');
                            $('.btn-change-status[data-id="'+id+'"]').removeClass('text-bg-primary');
                            $('.btn-change-status[data-id="'+id+'"]').addClass('text-bg-danger');

                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Thất bại',
                                text: data.message
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
