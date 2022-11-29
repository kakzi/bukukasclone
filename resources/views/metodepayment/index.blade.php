<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Metode Payment</h3>
                <p class="text-subtitle text-muted">Data Metode Payment</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Metode Payment</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>


    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <h4 class="card-title">Data Kategori Bisnis</h4> --}}
                <a href="{{ route('metode_payment.create') }}" class="btn btn-success text-right">Tambah Data</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Metode Payment</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($metodePayments as $category)
                            <tr>
                                <td>
                                    <div class="avatar bg-warning me-3">
                                        <img src="{{ $category->icon }}" alt="" srcset="" />
                                    </div>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="#" class="badge bg-primary">Edit</a>
                                    <a href="#" class="badge bg-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger text-center">Data Belum Tersedia</div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
