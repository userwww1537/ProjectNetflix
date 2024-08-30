@section('title', 'Lịch sử nạp tiền của ' . Auth::user()->fullName . ' - ' . config('app.name'))
@section('description', 'Lịch sử nạp tiền của ' . Auth::user()->fullName . ' tại ' . config('app.name'))
@section('keywords', 'Netflix, Spotify, Apple Music, HBO Max, Disney+')
@extends('Systems.base')
@section('content')
    <div id="content">
        <div class="p-3">
            <div class="card border-0 shadow-sm mb-3">
                <h5 class="card-header p-3">Nạp tiền vào tài khoản bằng Ngân Hàng</h5>
                <div class="card-body p-3">
                    <form action="{{ route('process-bank') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <p><b class="text-danger">Lưu ý: </b>Tính năng nạp tiền là tự động, khi thời gian hơn 15p vui lòng liên hệ qua kênh: <a href="https://mail.google.com/mail/?view=cm&to=cuahangmmovn@gmail.com&su=Hỗ trợ vấn đề không nạp tiền không vào - User: {{ Auth::user()->username }}&body=Tôi nạp tiền nhưng không thấy tiền được cộng">Email Cửa hàng MMO</a> để được hỗ trợ.</p>
                        </div>
                        <div class="input-group mb-4">
                            <input type="number" id="amount" onchange="totalRecharge()" onkeyup="totalRecharge()"
                                placeholder="Nhập số tiền cần nạp (VNĐ)" class="form-control me-3" required="" name="amount">
                            <div class="col-3">
                                <button class="btn btn-primary" style="font-size: 14px" type="submit"
                                    id="btnDepositOrder"><i class="fa-solid fa-file-invoice"></i>
                                    Tạo hóa đơn</button>
                            </div>
                        </div>
                        <p><span class="float-right">Số tiền thực nhận: <b id="received" style="color: red;">0</b></span>
                        </p>
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-3">
                <h5 class="card-header p-3 d-flex justify-content-between align-items-center">
                    Lịch sử nạp tiền </h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table data-table table-hover mb-0">
                            <thead class="table-color-heading">
                                <tr>
                                    <th class="text-center">Mã giao dịch</th>
                                    <th class="text-center">Thanh toán</th>
                                    <th class="text-center">Thực nhận</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thời gian</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $key => $value)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('bank-info', ['id' => $value['id']]) }}">#{{ $value['id'] }}</a>
                                        </td>
                                        <td class="text-center"><span class="badge text-bg-success">{{ $value['amount'] }}đ</span></td>
                                        <td class="text-center"><span class="badge text-bg-danger">{{ $value['actually_received'] }}đ</span></td>
                                        <td class="text-center"><span class="badge text-bg-@php
                                            if($value['status'] == 'Thành công') {
                                                echo 'success';
                                            } elseif($value['status'] == 'Chờ xác nhận') {
                                                echo 'primary';
                                            } else {
                                                echo 'danger';
                                            }
                                        @endphp">{{ $value['status'] }}</span></td>
                                        <td class="text-center">{{ $value['updated_at'] }}</td>
                                        <td class="text-center">
                                            @if($value['status'] != 'Hủy bỏ')
                                                <a class="" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Chi tiết hoá đơn"
                                                    href="{{ route('bank-info', ['id' => $value['id']]) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4"
                                                        width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a class="" data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Chi tiết hoá đơn" onclick="return alert('Hoá đơn đã bị hủy bỏ, không thể xem chi tiết')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4"
                                                        width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="row">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function totalRecharge() {
        var amount = document.getElementById('amount').value;
        var received = document.getElementById('received');
        received.innerHTML = formatCurrency(amount);
    }

    function formatCurrency(amount) {
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            minimumFractionDigits: 0
        });
        return formatter.format(amount);
    }
</script>
@endsection
