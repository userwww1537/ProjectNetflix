@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h3>Quản lí đơn hàng</h3>
            </div>
            <div class="card-body">
                <table id="myTable" class="display text-right">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Người mua</th>
                            <th>Thông tin đơn hàng</th>
                            <th>Trạng thái</th>
                            <th>Loại đơn hàng</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->user->username }}</td>
                                <td>
                                    <span class="tooltip-trigger" data-info="{{ $order->information }}">
                                        {{ Str::limit($order->information, 30) }}
                                        <button style="float: right;" class="btn btn-sm btn-primary copyButton"
                                            data-info="{{ $order->information }}"><i class="far fa-copy"></i></button>
                                    </span>
                                </td>
                                <td>
                                    @if ($order->status == 'Hoàn thành')
                                        <span class="badge badge-success">Hoàn thành</span>
                                    @elseif($order->status == 'Đang chờ duyệt')
                                        <span class="badge badge-warning">Đang chờ duyệt</span>
                                    @elseif($order->status == 'Đã hoàn')
                                        <span class="badge badge-info">Đã hoàn</span>
                                    @endif
                                </td>
                                <td>{{ $order->product->title }}</td>
                                <td data-order="{{ $order->created_at->timestamp }}">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .tippy-content {
            max-width: 300px;
            text-align: left;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "pageLength": 30,
                "order": [[5, "asc"]],
                "columnDefs": [
                    {
                        "width": "30%",
                        "targets": 2
                    },
                    {
                        "targets": 5,
                        "type": "date"
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
                }
            });

            // Sử dụng sự kiện được ủy quyền cho nút copy
            $('#myTable').on("click", ".copyButton", function() {
                const infoToCopy = $(this).data('info');
                copyToClipboard(infoToCopy);
                alert('Đã sao chép');
            });

            function copyToClipboard(text) {
                const tempInput = document.createElement('input');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
            }
        });
    </script>
@endsection
