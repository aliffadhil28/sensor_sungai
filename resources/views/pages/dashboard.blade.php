@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="d-flex flex-column gap-3 w-100 mb-3">
            <div class="card bg-white w-100 px-4 py-2">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex flex-column justify-content-between">
                        <h3>Status Banjir</h3>
                        <h1 id="status_deteksi">Aman</h1>
                    </div>
                    <div class="d-flex flex-column justify-content-between align-items-center">
                        <img src="{{ asset('img/illustrations/flood.png') }}" height="100rem" width="100rem"
                            alt="Device Locations">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-location-dot"></i>
                            <p class="my-auto">Klojen, Jawa Timur</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-3">
                <div class="card flex-grow-1">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers d-flex flex-column">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ketinggian Air</p>
                                    <h5 id="ketinggian-air" class="font-weight-bolder fs-3 ">
                                        {{ $data->tinggi_air }} cm
                                    </h5>
                                    <small id="monitor_tinggi"></small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fa-solid fa-droplet opacity-10 fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-grow-1">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers d-flex flex-column">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Debit Air</p>
                                    <h5 id="debit-air" class="font-weight-bolder fs-3 ">
                                        {{ $data->debit_air }} L/s
                                    </h5>
                                    <small id="monitor_debit"></small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="fa-solid fa-water opacity-10 fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-grow-1">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers d-flex flex-column">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Curah Hujan</p>
                                    <h5 id="curah-hujan" class="font-weight-bolder fs-3 ">
                                        {{ $data->curah_hujan }} mm
                                    </h5>
                                    <small id="monitor_hujan"></small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fa-solid fa-cloud-showers-heavy opacity-10 fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row w-100 gap-3">
            <div style="width : 20rem" class="d-flex flex-column gap-3">
                <div class="card flex-grow-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers d-flex flex-column">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Battery</p>
                                    <h5 id="battery" class="font-weight-bolder fs-3 ">
                                        {{ $data->battery }} %
                                    </h5>
                                    <small id="monitor_battery"></small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-primary bg-gradient shadow-secondary text-center rounded-circle">
                                    <i class="fa-solid fa-battery-three-quarters opacity-10 fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-medium">Lokasi Alat</h6>
                                <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
                            </div>
                            {{-- <iframe class="w-100 rounded"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7903.255435853863!2d112.60934059858295!3d-7.933893326400609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1732203645763!5m2!1sen!2sid"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                            <div style="width: 17rem; height: 17rem;" id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-grow-1 card d-flex flex-column p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-medium">Siarang Langsung</h6>
                </div>
                <div class="d-flex">
                    <iframe src=
                "https://www.youtube.com/watch?v=cdjgs48OQ6E" height="500px"
                        width="1000px">
                    </iframe>
                </div>
                {{-- <div id="chart"></div> --}}
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: "AIzaSyAk8vILollBhisVzRS0I-aT6jrLPR09X9o",
            v: "weekly"
        });

        async function initMap() {
            // The location of Uluru
            const position = {
                lat: -6.319261185285547,
                lng: 106.64247435608054
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 4,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Kos Alif",
            });
        }

        initMap();
    </script>
    <script>
        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
    <script>
        function saveHistoryData(status) {
            $.ajax({
                method: 'POST',
                url: '{{ route('data_history.save') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'status': status
                },
                error: function(error) {
                    console.error('AJAX Error:', error.responseJSON.message);
                }
            })
        }

        function fetchStreamData() {
            $.ajax({
                method: 'GET',
                url: '{{ route('stream-data') }}',
                success: function(response) {
                    if (response.status === 'success') {
                        const data = response.data;

                        // Perbarui tampilan nilai sensor
                        $('#ketinggian-air').text(`${data.tinggi_air} cm`);
                        $('#debit-air').text(`${data.debit_air} L/s`);
                        $('#curah-hujan').text(`${data.curah_hujan} mm`);
                        $('#battery').text(`${data.battery} %`);
                        $('#suara').text(`${data.suara != null ? data.suara : '0'} db`);
                        $('#sinyal').text(`${data.sinyal != null ? data.sinyal : '0'} MB/s`);

                        // Dapatkan status untuk setiap sensor
                        const batteryMon = getStatus(data.battery, 'battery');
                        const tinggiMon = getStatus(data.tinggi_air, 'tinggi_air');
                        const debitMon = getStatus(data.debit_air, 'debit_air');
                        const hujanMon = getStatus(data.curah_hujan, 'curah_hujan');

                        // Reset semua kelas warna terlebih dahulu untuk menghindari penumpukan kelas
                        $('#monitor_battery, #monitor_tinggi, #monitor_debit, #monitor_hujan').removeClass(
                            'text-success text-warning text-danger text-secondary fw-bold');
                        console.log(tinggiMon);

                        // Perbarui tampilan status untuk setiap monitor
                        $('#monitor_battery').text(`${batteryMon.text} (${batteryMon.status})`).addClass(
                            `text-${batteryMon.color}`);
                        $('#monitor_tinggi').text(`${tinggiMon.text} (${tinggiMon.status})`).addClass(
                            `text-${tinggiMon.color}`);
                        $('#monitor_debit').text(`${debitMon.text} (${debitMon.status})`).addClass(
                            `text-${debitMon.color}`);
                        $('#monitor_hujan').text(`${hujanMon.text} (${hujanMon.status ?? '-'})`).addClass(
                            `text-${hujanMon.color}`);

                        // Dapatkan kondisi keseluruhan berdasarkan nilai sensor langsung
                        const kondisiDeteksi = getKondisi(data.curah_hujan, data.tinggi_air, data.debit_air);

                        // Atur warna berdasarkan kondisi
                        let warnaKelas;
                        switch (kondisiDeteksi) {
                            case 'Aman':
                                warnaKelas = 'text-success'; // Hijau
                                break;
                            case 'Siaga':
                                warnaKelas = 'text-warning'; // Kuning
                                break;
                            case 'Waspada':
                                saveHistoryData(kondisiDeteksi);
                                warnaKelas = 'text-danger'; // Merah
                                break;
                            case 'Bahaya':
                                saveHistoryData(kondisiDeteksi);
                                warnaKelas = 'text-danger fw-bold'; // Merah Tebal
                                break;
                            default:
                                warnaKelas = 'text-secondary'; // Abu-abu untuk kondisi tidak diketahui
                        }

                        // Hapus kelas warna lama dan tambahkan kelas baru
                        $('#status_deteksi').removeClass(
                                'text-success text-warning text-danger text-secondary fw-bold')
                            .addClass(warnaKelas)
                            .text(kondisiDeteksi);
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(error) {
                    console.error('AJAX Error:', error.responseJSON.message);
                }
            });
        }

        setInterval(fetchStreamData, 5000);

        function getStatus(data, sensor) {
            let color = '';
            let text = '';
            switch (sensor) {
                case 'battery':
                    if (data >= 75 && data <= 100) {
                        return {
                            color: 'success',
                            text: 'Aman',
                            status: '> 75%'
                        }
                    } else if (data >= 50 && data <= 75) {
                        return {
                            color: 'warning fw-bold',
                            text: 'Siaga',
                            status: '> 50%'
                        }
                    } else if (data >= 25 && data <= 50) {
                        return {
                            color: 'danger',
                            text: 'Waspada',
                            status: '> 25%'
                        }
                    } else {
                        return {
                            color: 'danger fw-bold',
                            text: 'Bahaya',
                            status: '< 25%'
                        }
                    }
                    break;
                case 'tinggi_air':
                    if (data >= 0 && data <= 100) {
                        return {
                            color: 'danger fw-bold',
                            text: 'Bahaya',
                            status: '< 100'
                        }
                    } else if (data >= 100 && data <= 120) {
                        return {
                            color: 'danger',
                            text: 'Siaga',
                            status: '> 100'
                        }
                    } else if (data >= 120 && data <= 130) {
                        return {
                            color: 'warning fw-bold',
                            text: 'Waspada',
                            status: '> 120'
                        }
                    } else {
                        return {
                            color: 'success',
                            text: 'Aman',
                            status: '> 130'
                        }
                    }
                    break;
                case 'debit_air':
                    if (data >= 0 && data <= 10) {
                        return {
                            color: 'success',
                            text: 'Lambat',
                            status: '< 10'
                        }
                    } else if (data >= 10 && data <= 20) {
                        return {
                            color: 'warning fw-bold',
                            text: 'Siaga',
                            status: '< 20'
                        }
                    } else if (data >= 20 && data <= 30) {
                        return {
                            color: 'danger',
                            text: 'Waspada',
                            status: '< 30'
                        }
                    } else {
                        return {
                            color: 'danger fw-bold',
                            text: 'Bahaya',
                            status: '> 30'
                        }
                    }
                    break;
                case 'curah_hujan':
                    if (data >= 2800 && data <= 4056) {
                        return {
                            color: 'success',
                            text: 'Aman',
                            status: '< 4056'
                        }
                    } else if (data >= 1800 && data <= 2800) {
                        return {
                            color: 'warning fw-bold',
                            text: 'Siaga',
                            status: '< 2800'
                        }
                    } else if (data >= 800 && data <= 1800) {
                        return {
                            color: 'danger',
                            text: 'Waspada',
                            status: '< 1800'
                        }
                    } else {
                        return {
                            color: 'danger fw-bold',
                            text: 'Bahaya',
                            status: '< 800'
                        }
                    }
                    break;
                default:
                    return {
                        color: 'secondary', text: 'Not Found', class: 'text-secondary'
                    }
                    break;
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchStreamData();
        });
    </script>
    <script>
        function getKondisi(curah_hujan, tinggi_air, debit_air) {
            // Kategorisasi curah hujan
            let kategori_hujan;
            if (curah_hujan >= 2800) {
                kategori_hujan = 't'; // Tidak hujan / Aman
            } else if (curah_hujan >= 1800 && curah_hujan < 2800) {
                kategori_hujan = 'r'; // Ringan
            } else if (curah_hujan >= 800 && curah_hujan < 1800) {
                kategori_hujan = 'sd'; // Sedang
            } else {
                kategori_hujan = 'l'; // Lebat / Bahaya
            }

            // Kategorisasi ketinggian air
            let kategori_air;
            if (tinggi_air >= 130) {
                kategori_air = 'r'; // Rendah / Aman
            } else if (tinggi_air >= 120 && tinggi_air < 130) {
                kategori_air = 'sd'; // Sedang
            } else if (tinggi_air >= 100 && tinggi_air < 120) {
                kategori_air = 't'; // Tinggi
            } else {
                kategori_air = 'st'; // Sangat tinggi / Bahaya
            }

            // Kategorisasi debit air
            let kategori_debit;
            if (debit_air >= 0 && debit_air <= 10) {
                kategori_debit = 'lm'; // Lambat / Aman
            } else if (debit_air > 10 && debit_air <= 20) {
                kategori_debit = 'sd'; // Sedang
            } else if (debit_air > 20 && debit_air <= 30) {
                kategori_debit = 'cp'; // Cepat
            } else {
                kategori_debit = 'sl'; // Sangat Lambat / Bahaya
            }

            // Aturan kondisi berdasarkan kombinasi parameter
            const rules = {
                t: {
                    r: {
                        lm: 'Aman',
                        sd: 'Siaga',
                        cp: 'Waspada',
                        sl: 'Bahaya'
                    },
                    sd: {
                        lm: 'Siaga',
                        sd: 'Waspada',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    t: {
                        lm: 'Waspada',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    st: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    }
                },
                r: {
                    r: {
                        lm: 'Aman',
                        sd: 'Siaga',
                        cp: 'Siaga',
                        sl: 'Waspada'
                    },
                    sd: {
                        lm: 'Siaga',
                        sd: 'Waspada',
                        cp: 'Waspada',
                        sl: 'Bahaya'
                    },
                    t: {
                        lm: 'Waspada',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    st: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    }
                },
                sd: {
                    r: {
                        lm: 'Siaga',
                        sd: 'Waspada',
                        cp: 'Waspada',
                        sl: 'Bahaya'
                    },
                    sd: {
                        lm: 'Waspada',
                        sd: 'Waspada',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    t: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    st: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    }
                },
                l: {
                    r: {
                        lm: 'Siaga',
                        sd: 'Waspada',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    sd: {
                        lm: 'Waspada',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    t: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    },
                    st: {
                        lm: 'Bahaya',
                        sd: 'Bahaya',
                        cp: 'Bahaya',
                        sl: 'Bahaya'
                    }
                }
            };

            // Periksa dan kembalikan kondisi
            return rules[kategori_hujan]?.[kategori_air]?.[kategori_debit] || 'data tidak valid';
        }
        // Aturan kondisi berdasarkan kombinasi parameter
        const rules = {
            t: {
                r: {
                    lm: 'Aman',
                    sd: 'Siaga',
                    cp: 'Waspada',
                    sl: 'Bahaya'
                },
                sd: {
                    lm: 'Siaga',
                    sd: 'Waspada',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                t: {
                    lm: 'Waspada',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                st: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                }
            },
            r: {
                r: {
                    lm: 'Aman',
                    sd: 'Siaga',
                    cp: 'Siaga',
                    sl: 'Waspada'
                },
                sd: {
                    lm: 'Siaga',
                    sd: 'Waspada',
                    cp: 'Waspada',
                    sl: 'Bahaya'
                },
                t: {
                    lm: 'Waspada',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                st: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                }
            },
            sd: {
                r: {
                    lm: 'Siaga',
                    sd: 'Waspada',
                    cp: 'Waspada',
                    sl: 'Bahaya'
                },
                sd: {
                    lm: 'Waspada',
                    sd: 'Waspada',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                t: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                st: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                }
            },
            l: {
                r: {
                    lm: 'Siaga',
                    sd: 'Waspada',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                sd: {
                    lm: 'Waspada',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                t: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                },
                st: {
                    lm: 'Bahaya',
                    sd: 'Bahaya',
                    cp: 'Bahaya',
                    sl: 'Bahaya'
                }
            }
        };

        // Konversi input ke huruf kecil untuk mencocokkan kunci
        tingkat_hujan = tingkat_hujan.toLowerCase();
        ketinggian_air = ketinggian_air.toLowerCase();
        debit_air = debit_air.toLowerCase();

        // Periksa dan kembalikan kondisi
        return rules[tingkat_hujan]?.[ketinggian_air]?.[debit_air] || 'data tidak valid';
        }
    </script>
@endpush
