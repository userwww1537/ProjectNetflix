@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Chi tiết gian hàng: {{ $product->title }}</h3>
                <a href="{{ route('admin.products') }}" class="btn btn-sm text-white btn-secondary">Quay lại</a>
            </div>
            <div class="card-body">
                <table id="myTable" class="display ">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Thông tin</th>
                            <th>Giá</th>
                            <td>Số lượng</td>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stock_product as $product)
                            <tr>
                                <td>#{{ $product->id }}</td>
                                <td>{{ Str::limit($product->info, 35, '...') }}</td>
                                <td>{{Str::limit( $product->info_more, 20, '...') }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>

                                    @if ($product->status == 1 && $product->quantity > 0)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @elseif ($product->quantity >= 0)
                                        <span class="badge badge-warning">Hết hàng</span>
                                    @elseif ($product->status == 0)
                                        <span class="badge badge-danger">Ngưng hoạt động</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at }}</td>
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
                "order": [
                    [4, "desc"]
                ],
                "columnDefs": [{
                    "targets": 4,
                    "type": "date"
                }],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
                }
            });

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
