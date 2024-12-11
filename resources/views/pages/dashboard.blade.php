@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="d-flex flex-column gap-3 w-100 mb-3">
            <div class="card bg-white w-100 px-4 py-2">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex flex-column justify-content-between">
                        <h3>Status Banjir</h3>
                        <h1>Aman</h1>
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
                                    <h5 class="font-weight-bolder fs-3 ">
                                        {{ $data->tinggi_air }} cm
                                    </h5>
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
                                    <h5 class="font-weight-bolder fs-3 ">
                                        {{ $data->debit_air }} L/s
                                    </h5>
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
                                    <h5 class="font-weight-bolder fs-3 ">
                                        {{ $data->curah_hujan }} mm
                                    </h5>
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
                                    <h5 class="font-weight-bolder fs-3 ">
                                        {{ $data->battery }} %
                                    </h5>
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
@endpush
