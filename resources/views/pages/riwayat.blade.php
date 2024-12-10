@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Riwayat Data Sensor'])
    <div class="container-fluid py-4">
        <form class="d-flex flex-row justify-content-end p-3 align-items-center card mb-3" action="#">
            <div class="d-flex flex-row me-3">
                <label for="tanggal_awal" class="form-label text-nowrap me-3 my-auto">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
            </div>
            <div class="d-flex flex-row me-3">
                <label for="tanggal_akhir" class="form-label text-nowrap me-3 my-auto">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
            </div>
            <button type="submit" class="btn btn-success my-auto">Cari</button>
        </form>

        <div class="card p-3 mb-3" id="tinggi_air"></div>
        <div class="card p-3 mb-3" id="debit_air"></div>
        <div class="card p-3" id="curah_hujan"></div>
    </div>
    @push('js')
        <script>
            const getDataChart = () => {
                const tanggalAwal = $('#tanggal_awal').val();
                const tanggalAkhir = $('#tanggal_akhir').val();

                $.ajax({
                    url: '/riwayat',
                    method: 'GET',
                    data: {
                        tanggal_awal: tanggalAwal,
                        tanggal_akhir: tanggalAkhir
                    },
                    success: function(response) {
                        // Update data pada chart berdasarkan response
                        chart1.updateOptions({
                            labels: response.tanggalTinggi,
                            series: [{
                                    name: 'Tinggi Air',
                                    type: 'column',
                                    data: response.avg_tinggi_air
                                },
                                {
                                    name: 'Tinggi Air',
                                    type: 'line',
                                    data: response.avg_tinggi_air
                                }
                            ]
                        });

                        // Update label dan data untuk chart Debit Air
                        chart2.updateOptions({
                            labels: response.tanggalTinggi,
                            series: [{
                                    name: 'Debit Air',
                                    type: 'column',
                                    data: response.avg_debit_air
                                },
                                {
                                    name: 'Debit Air',
                                    type: 'line',
                                    data: response.avg_debit_air
                                }
                            ]
                        });

                        // Update label dan data untuk chart Curah Hujan
                        chart3.updateOptions({
                            labels: response.tanggalTinggi,
                            series: [{
                                    name: 'Curah Hujan',
                                    type: 'column',
                                    data: response.avg_curah_hujan
                                },
                                {
                                    name: 'Curah Hujan',
                                    type: 'line',
                                    data: response.avg_curah_hujan
                                }
                            ]
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching chart data:', error);
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', function() {
                getDataChart();
            });

            // Event listener untuk tombol Cari
            $('form').on('submit', function(event) {
                event.preventDefault();
                getDataChart();
            });

            var optionsTinggiAir = {
                series: [{
                    name: 'Tinggi Air',
                    type: 'column',
                    data: {!! $avg_tinggi_air !!}
                }, {
                    name: 'Tinggi Air',
                    type: 'line',
                    data: {!! $avg_tinggi_air !!}
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: [0, 4],
                },
                title: {
                    text: 'Riwayat Ketinggian Air'
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                labels: {!! $tanggalTinggi !!},
                yaxis: [{
                    title: {
                        text: 'Tinggi Air',
                    },
                }]
            };

            var optionsDebitAir = {
                series: [{
                    name: 'Debit Air',
                    type: 'column',
                    data: {!! $avg_debit_air !!}
                }, {
                    name: 'Debit Air',
                    type: 'line',
                    data: {!! $avg_debit_air !!}
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: [0, 4],
                },
                title: {
                    text: 'Riwayat Debit Air'
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                labels: {!! $tanggalTinggi !!},
                yaxis: [{
                    title: {
                        text: 'Debit Air',
                    },
                }]
            };

            var optionsCurahHujan = {
                series: [{
                    name: 'Curah Hujan',
                    type: 'column',
                    data: {!! $avg_curah_hujan !!}
                }, {
                    name: 'Curah Hujan',
                    type: 'line',
                    data: {!! $avg_curah_hujan !!}
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: [0, 4],
                },
                title: {
                    text: 'Riwayat Curah Hujan'
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                labels: {!! $tanggalTinggi !!},
                yaxis: [{
                    title: {
                        text: 'Curah Hujan',
                    },
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#tinggi_air"), optionsTinggiAir);
            chart1.render();
            var chart2 = new ApexCharts(document.querySelector("#debit_air"), optionsDebitAir);
            chart2.render();
            var chart3 = new ApexCharts(document.querySelector("#curah_hujan"), optionsCurahHujan);
            chart3.render();
        </script>
    @endpush
@endsection
