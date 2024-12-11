@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Gambar'])
    <div class="container-fluid py-4">
        <form class="d-flex flex-row justify-content-end p-3 align-items-center card mb-3" action="#">
            <div class="d-flex flex-row me-3">
                <label for="tanggal" class="form-label text-nowrap me-3 my-auto">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih tanggal">
            </div>
            <button id="filterButton" type="submit" class="btn btn-success my-auto">Cari</button>
        </form>

        <div id="gambarContainer" class="d-flex flex-wrap">
            @foreach ($data as $d)
                <div class="card p-2 mx-3">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset($d->file) }}" class="card-img-top" alt="Gambar {{ $d->file }}">
                        <div class="card-body">
                            <p class="card-text text-center">{{ $d->waktu }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    @push('js')
        <script>
            const getGambarData = () => {
                const tanggal = $('#tanggal').val();

                $.ajax({
                    url: '/gambar',
                    method: 'GET',
                    data: {
                        tanggal: tanggal,
                    },
                    success: function(response) {
                        // Clear existing content
                        $('#gambarContainer').empty();

                        // Append new data
                        response.forEach(item => {
                            $('#gambarContainer').append(`
                                <div class="card p-2 mx-3">
                                    <div class="card" style="width: 18rem;">
                                        <img src="${item.file}" class="card-img-top" alt="Gambar ${item.file}">
                                        <div class="card-body">
                                            <p class="card-text text-center">${item.waktu}</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    },
                    error: function(error) {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal memuat data gambar. Silakan coba lagi.');
                    }
                });
            }

            // Event listener for button
            $('#filterButton').on('click', function() {
                getGambarData();
            });

            // Initial load on page ready
            $(document).ready(function() {
                getGambarData();
            });
        </script>
    @endpush
@endsection
