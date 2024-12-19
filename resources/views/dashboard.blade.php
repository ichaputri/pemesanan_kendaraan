<!-- resources/views/dashboard.blade.php -->
@extends('layouts.layout')

@section('title', 'Dashboard - BookingCar')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-12 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->username }}! 🎉</h5>
                            <p class="mb-6">
                                Senang melihat Anda kembali. Mari kita mulai hari ini!<br>
                                Bersama kita menuju produktivitas yang lebih baik :)
                            </p>
                            <a href="{{ route('pemesanan.index') }}" class="btn btn-sm btn-outline-primary">Buat Pemesanan</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('template/assets/img/illustrations/man-with-laptop.png') }}" height="175" class="scaleX-n1-rtl" alt="View Badge User" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-12 order-2 order-md-3 order-xxl-2 mb-6 h-5">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-lg-6">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Total Pemakaian Kendaraan</h5>
                            </div>
                        </div>
                        <div id="totalPemakaianKendaraanPie" class="px-3" style="height: 400px; width: 100%;"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Total Pemakaian Kendaraan</h5>
                            </div>
                        </div>
                        <div id="totalPemakaianKendaraanBar" class="px-3" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        var data = google.visualization.arrayToDataTable([
            ['Nama Kendaraan', 'Total Pemakaian'],
            @foreach($data as $item)
                ['{{ $item->nama_kendaraan }}', {{ $item->total_pemakaian }}],
            @endforeach
        ]);

        var pieOptions = {
            // title: 'Pemakaian Kendaraan (Pie Chart)',
            pieHole: 0.2,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out',
            },
            fontName: 'Arial',
            fontSize: 14,
            // backgroundColor: '#f1f1f1',
        };

        var pieChart = new google.visualization.PieChart(document.getElementById('totalPemakaianKendaraanPie'));
        pieChart.draw(data, pieOptions);

        var barOptions = {
            // title: 'Pemakaian Kendaraan (Bar Chart)',
            hAxis: {
                title: 'Total Pemakaian',
                minValue: 0
            },
            vAxis: {
                title: 'Nama Kendaraan'
            },
            legend: { position: 'none' },
            // bars: 'vertical'
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out',
            },
            fontName: 'Arial',
            fontSize: 14,
            // backgroundColor: '#f1f1f1',
        };

        var barChart = new google.visualization.BarChart(document.getElementById('totalPemakaianKendaraanBar'));
        barChart.draw(data, barOptions);
    }
</script>
@endsection

