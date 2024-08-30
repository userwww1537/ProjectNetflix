@extends('admin.layout.base')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Thêm phiếu thu chi</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.treasury.store') }}" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <label for="">Nội dung</label>
                        <input type="text" name="content" class="form-control" required>
                    </div>
                    <div class="col-12 my-3">
                        <label for="">Chọn Quỹ</label>
                        <select id="" name="parent_id" required class="form-select">
                            @foreach ($treasuries as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-6 my-3">
                        <label for="">Loại thanh toán</label>
                        <select name="type" id="" required class="form-select">
                            <option value="collect">Thu</option>
                            <option value="spend">Chi</option>
                        </select>
                    </div>
                    <div class="col-6 my-3">
                        <label for="">Số tiền</label>
                        <input type="text" name="money" class="form-control inputPrice" required>
                    </div>
                    <div class="col-6 my-3">
                        <label for="">Người</label>
                        <input type="text" name="people" class="form-control">
                    </div>
                    <div class="col-6 my-3">
                        <label for="">Số điện thoại người nhận</label>
                        <input type="text" name="number_phone" class="form-control">
                    </div>
                    <div class="col-6 my-3">
                        <label for="">Ngày tạo</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="col-6 my-3">
                        <label for="">Ảnh chứng thực</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-12 my-3">
                        <button type="submit" class="btn btn-sm btn-primary">Tạo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.inputPrice').on("input", function() {
            var price = $(this).val();
            var formattedPrice = formatPrice(price);
            console.log(formattedPrice);
            $(this).val(formattedPrice);
        });
    </script>
@endsection
