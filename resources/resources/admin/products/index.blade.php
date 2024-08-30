@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Quản lí gian hàng</h3>
                <a href="{{ route('admin.products.add') }}" class="btn btn-sm text-white btn-secondary">Thêm <i
                        class="fa-solid fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table id="myTable" class="display ">
                    <thead>
                        <tr>
                            <th>Mã gian hàng</th>
                            <th>Tên gian hàng</th>
                            <th>Giá</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><strong>#{{ $product->id }}</strong></td>
                                <td>{{ $product->title }}</td>
                                <td>{{ number_format($product->price) }}đ | {{ $product->coin }}xu</td>

                                <td>{{ $product->sub_category->name }}</td>
                                <td>
                                    @if ($product->status == 1)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @elseif ($product->status == 0)
                                        <span class="badge badge-danger">Ngưng hoạt động</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </td>
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
