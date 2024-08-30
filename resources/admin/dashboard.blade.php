@extends('admin.layout.base')
@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Tổng thành viên</p>
                                    <h4 class="card-title">{{ $totalUser }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-luggage-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Tổng tiền nạp</p>
                                    <h4 class="card-title">{{ number_format($totalAmount, 0, ',', '.') . ' ₫' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Tổng tiền nhiệm vụ</p>
                                    <h4 class="card-title">{{ number_format($totalAmountMission, 0, ',', '.') . ' ₫' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Số đơn hàng</p>
                                    <h4 class="card-title">{{ $totalOrder }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Thống kê đơn hàng</div>
                            <div class="card-tools d-flex">
                                <select id="month_order" name="month_order" class="form-select" style="width: 100px;">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>

                                <select id="year_order" name="year_order" class="form-select mx-2">
                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row d-flex justify-content-around">
                        <canvas id="OrderCount" class="col-lg-6 col-12" style="max-width: 550px; max-height: 400px;"></canvas>
                        <canvas id="DepositCount"  class="col-lg-6 col-12" style="max-width: 550px; max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round" style="max-height: 700px; overflow: scroll;">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right justify-content-between">
                            <div class="card-title">Lịch sử giao dịch | <span class="mx-2" id="total_amount">Tổng tiền:
                                    {{ number_format($totalAmount, 0, ',', '.') . ' ₫' }}</span></div>
                            <div class="justify-content-center align-items-center d-flex">
                                <input type="text" id="date_start_deposit" name="date_start_deposit"
                                    value="{{ old('date_start_deposit') }}" class="datepicker form-control"
                                    placeholder="Từ ngày...">
                                <strong class="mx-2">-</strong>
                                <input type="text" id="date_end_deposit" class="datepicker form-control"
                                    value="{{ old('date_end_deposit') }}" name="date_end_deposit"
                                    placeholder="Đến ngày...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker();

            var chart = new Chart(document.getElementById('OrderCount').getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($day) !!},
                    datasets: [{
                        label: 'Đơn hàng',
                        data: {!! json_encode($countOrder) !!},
                        backgroundColor: "rgba(38, 185, 154, 0.31)",
                        borderColor: "rgba(38, 185, 154, 0.7)",
                        pointBorderColor: "rgba(38, 185, 154, 0.7)",
                        pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        fill: true
                    }
                ]
                },
                options: {}
            });

            var chart2 = new Chart(document.getElementById('DepositCount').getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($dayDeposit) !!},
                    datasets: [{
                        label: 'Tiền nạp',
                        data: {!! json_encode($totalAmountDeposit) !!},
                        backgroundColor: "rgba(38, 185, 154, 0.31)",
                        borderColor: "rgba(38, 185, 154, 0.7)",
                        pointBorderColor: "rgba(38, 185, 154, 0.7)",
                        pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        fill: true
                    }
                ]
                },
                options: {}
            });


            $('#month_order, #year_order').on('change', function() {
                var month = $('#month_order').val();
                var year = $('#year_order').val();

                $.ajax({
                    url: '{{ route('admin.dashboard') }}',
                    method: 'GET',
                    data: {
                        month_order: month,
                        year_order: year
                    },
                    success: function(response) {
                        chart.data.labels = response.labels;
                        chart.data.datasets[0].data = response.order;
                        chart2.data.labels = response.label2;
                        chart2.data.datasets[0].data = response.deposit;
                        chart.update();
                        chart2.update();
                    }
                });
            })

            $("#date_start_deposit, #date_end_deposit").on('change', function() {
                var date_start = $('#date_start_deposit').val()
                var date_end = $('#date_end_deposit').val()

                $.ajax({
                    url: '{{ route('admin.dashboard') }}',
                    method: 'GET',
                    data: {
                        date_start_deposit: date_start,
                        date_end_deposit: date_end
                    },
                    success: function(response) {
                        $('#table_deposit').html(response.html);
                        $('#total_amount').html('Tổng tiền: ' + response.totalAmount);
                    }
                });
            });
        });
    </script>
@endsection
