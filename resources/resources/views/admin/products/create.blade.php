@extends('admin.layout.base')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Thêm gian hàng</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" class="row">
                    @csrf
                    <div class="col-12 my-2">
                        <label for="">Tên gian hàng</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error('title')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-6 my-2">
                        <label for="">Nhập giá (đ)</label>
                        <input type="text" name="price" class="form-control inputPrice" value="{{ old('price') }}">
                        @error('price')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-6 my-2">
                        <label for="">Nhập số xu</label>
                        <input type="text" name="coin" class="form-control inputPrice" value="{{ old('coin') }}">
                        @error('coin')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                    </div>
                    <div class="col-12 my-2">
                        <label for="">Quốc gia</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                        @error('country')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                    </div>
                    <div class="col-12 my-2">
                        <label for="">Mô tả</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                        @error('description')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-12 my-2">
                        <label for="">Loại</label>
                        <select name="parent_id" id="" class="form-select">
                            <option value="">Chọn loại</option>
                            @foreach ($sub_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-3 my-3">
                        <button class="btn btn-primary" type="submit">Thêm</button>
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary mx-2">Hủy</a>
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
