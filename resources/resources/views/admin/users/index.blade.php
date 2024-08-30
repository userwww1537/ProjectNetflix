@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Quản lí người dùng</h3>
            </div>
            <div class="card-body">
                <table id="myTable" class="display ">
                    <thead>
                        <tr>
                            <th>Mã người dùng</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Tiền</th>
                            <th>Xu</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><strong>#{{ $user->id }}</strong></td>
                                <td style="width: 15%;">{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ number_format($user->wall_user->money) }}đ</td>
                                <td>{{ $user->wall_user->coin }}</td>
                                <td>
                                    @if ($user->role_id == 1)
                                        Quản trị viên
                                    @elseif($user->role_id == 2)
                                        Cộng tác viên
                                    @elseif($user->role_id == 3)
                                        Người dùng
                                    @endif
                                </td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @elseif($user->status == 0)
                                        <span class="badge badge-danger">Bị khóa</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
