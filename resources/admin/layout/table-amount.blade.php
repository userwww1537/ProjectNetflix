<table class="table align-items-center mb-0" id="table_deposit">
    <thead class="thead-light">
        <tr>
            <th scope="col">Mã giao dịch</th>
            <th scope="col" class="text-end">Thời gian</th>
            <th scope="col" class="text-end">Nội dung</th>
            <th scope="col" class="text-end">Giá trị</th>
            <th scope="col" class="text-end">Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deposits as $deposit)
            <tr>
                <th scope="row">
                    #{{ $deposit->id }}
                </th>
                <td class="text-end">{{ $deposit->created_at }}</td>
                <td class="text-end">{{ $deposit->description }}</td>
                <td class="text-end">{{ number_format($deposit->amount, 0, ',', '.') . ' ₫' }}
                </td>
                <td class="text-end">
                    @if ($deposit->status == 'Thành công')
                        <span class="badge badge-success">Thành công</span>
                    @elseif ($deposit->status == 'Chờ xác nhận')
                        <span class="badge badge-warning">Chờ xác nhận</span>
                    @elseif ($deposit->status == 'Hủy bỏ')
                        <span class="badge badge-danger">Hủy bỏ</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
