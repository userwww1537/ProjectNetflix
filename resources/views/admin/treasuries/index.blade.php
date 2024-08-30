@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Quản lí phiếu thu chi | {{ $treasury->name }}: {{ number_format($treasury->total_money) }}đ</h3>
                <a href="{{ route('admin.treasury.create') }}" class="btn btn-sm text-white btn-secondary">Thêm <i
                        class="fa-solid fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table id="myTable" class="display ">
                    <thead>
                        <tr>
                            <th>Mã phiếu</th>
                            <th>Nội dung</th>
                            <th>Giá trị</th>
                            <th>Loại</th>
                            <th>Người thực hiện</th>
                            <th>Người nhận</th>
                            <th>Quỹ</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $treasure)
                        <tr>
                            <td>#{{ $treasure->id }}</td>
                            <td>{{ $treasure->content }}</td>
                            <td>{{ number_format($treasure->money) }}</td>
                            <td>
                                @if ($treasure->type == 'collect')
                                    <span class="badge badge-success">Thu</span>
                                @elseif ($treasure->type == 'spend')
                                    <span class="badge badge-danger">Chi</span>
                                @endif
                            </td>
                            <td>{{ $treasure->user->fullName }}</td>
                            <td>{{ $treasure->people }} | {{ $treasure->number_phone }}</td>
                            <td>{{ $treasure->treasury->name }}</td>
                            <td>{{ $treasure->date }}</td>
                            <td>Sửa</td>
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
                    [5, "desc"]
                ],
                "columnDefs": [{
                    "targets": 5,
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

        function deleteProduct(id) {
            let product_id = id
            Swal.fire({
                title: "Bạn chắc chắc?",
                text: "Sau khi xóa không thể khôi phục!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Không",
                confirmButtonText: "Vâng, hãy xóa nó!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.products.delete', ':id') }}".replace(':id', product_id),
                        type: "delete",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                Swal.fire({
                                    title: "Thành công",
                                    text: data.success,
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Lỗi",
                                    text: data.error,
                                    icon: "error"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Lỗi",
                                text: "Có lỗi xảy ra",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
