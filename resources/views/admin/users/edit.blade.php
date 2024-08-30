@extends('admin.layout.base')

@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Chỉnh sửa thông tin: {{ $user->username }}</h3>
            </div>
            <div class="card-body row">
                <form action="{{ route('admin.users.update', $user->id) }}" method="post" class="col-6 row">
                    @csrf
                    @method('PATCH')
                    <h4>Cập nhật thông tin</h4>
                    <div class="my-2">
                        <label for="">Vai trò</label>
                        <select name="role_id" name="role_id" id="" class="form-select">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>{{ $role->role_display }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="">Trạng thái</label>
                        <select name="status" id="" class="form-select">
                            <option value="1" @selected($user->status == 1)>Hoạt động</option>
                            <option value="0" @selected($user->status == 0)>Khóa tài khoản</option>
                        </select>
                        @error('role_id')
                        <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="my-3"><button class="btn btn-primary" type="submit">Cập nhật</button>
                    </div>
                </form>

                <form action="{{ route('admin.users.update-waller', $user->id) }}" method="post" class="col-6">
                    @csrf
                    <h4>Cập nhật ví</h4>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Tiền</label>
                            <input type="text" name="price" value="{{ $user->wall_user->money ?? 0 }}" class="form-control inputPrice">
                        </div>
                        <div class="col-6">
                            <label for="">Xu</label>
                            <input type="text" name="coin" value="{{ $user->wall_user->coin }}" class="form-control inputPrice">
                        </div>
                    </div>
                    <div class="my-3"><button class="btn btn-primary" type="submit">Cập nhật</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mx-2">Hủy</a>
                    </div>
                </form>
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

        $('.inputPrice').on("input", function() {
            var price = $(this).val();
            var formattedPrice = formatPrice(price);
            $(this).val(formattedPrice);
        });
    </script>
@endsection
