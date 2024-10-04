@extends('layout')
@section('title', 'Dashboard')
@section('content')
@if(session('success'))
<div class="alert alert-success py-3">
    <i class="fas ml-3 fa-check-circle fa-sm"></i>
    <span class="small w-100">{{ session('success') }}</span>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger py-3">
    <i class="fas fa-exclamation-circle fa-sm"></i>
    <strong class="small">There were some problems with your input:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li class="small w-100">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container mt-5">
    <div class="row">

        {{-- Card for Expense Summary --}}
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-dark">
                    <h6 class="m-0 font-weight-bold text-white">Expense Summary</h6>
                </div>
                <div class="card-body">
                    <canvas id="expenseChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        {{-- Card for Expense Totals --}}
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-dark">
                    <h6 class="m-0 font-weight-bold text-white">Expense Categories and Totals</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="m-0 font-weight-bold">
                                <tr>
                                    <th>Expense Category</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totals as $total)
                                <tr>
                                    <td>{{ $total->expensecategory }}</td>
                                    <td>${{ number_format($total->total_amount, 2) }}</td>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('expenseChart').getContext('2d');
    var expenseCategories = {!! json_encode($totals->pluck('expensecategory')) !!};
    var expenseAmounts = {!! json_encode($totals->pluck('total_amount')) !!};

    var expenseChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: expenseCategories,
            datasets: [{
                label: 'Expense Totals',
                data: expenseAmounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                }
            }
        }
    });
</script>
@endsection
