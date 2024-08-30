@extends('admin.layout.base')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3>Sửa gian hàng</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" class="row">
                    @csrf
                    <div class="col-12 my-2">
                        <label for="">Tên gian hàng</label>
                        <input type="text" name="title" class="form-control" value="{{ $product->title }}">
                        @error('title')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-6 my-2">
                        <label for="">Nhập giá (đ)</label>
                        <input type="text" name="price" class="form-control inputPrice" value="{{ $product->price }}">
                        @error('price')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-6 my-2">
                        <label for="">Nhập số xu</label>
                        <input type="text" name="coin" class="form-control inputPrice" value="{{ $product->coin }}">
                        @error('coin')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                    </div>
                    <div class="col-12 my-2">
                        <label for="">Quốc gia</label>
                        <input type="text" name="country" class="form-control" value="{{ $product->country }}">
                        @error('country')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror

                    </div>
                    <div class="col-12 my-2">
                        <label for="">Mô tả</label>
                        <input type="text" name="description" class="form-control" value="{{ $product->description }}">
                        @error('description')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-12 my-2">
                        <label for="">Loại</label>
                        <select name="parent_id" id="" class="form-select">
                            <option value="">Chọn loại</option>
                            @foreach ($sub_categories as $item)
                                <option value="{{ $item->id }}" @selected($item->id == $product->parent_id)>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-12 my-2">
                        <label for="">Trạng thái</label>
                        <select name="status" id="" class="form-select">
                            <option value="">Chọn trạng thái</option>
                            <option value="1" @selected($product->status == 1)>Hoạt động</option>
                            <option value="0" @selected($product->status == 0)>Ngưng hoạt động</option>
                        </select>
                    </div>
                    <div class="col-3 my-3"><button class="btn btn-primary" type="submit">Cập nhật</button>
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
            $(this).val(formattedPrice);
        });
    </script>
@endsection
