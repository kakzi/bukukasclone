<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kategori Bisnis</h3>
                <p class="text-subtitle text-muted">Data kategori bisnis</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>


    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <h4 class="card-title">Data Kategori Bisnis</h4> --}}
                <a href="{{ route('category.create') }}" class="btn btn-success text-right">Tambah Data</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Nama Kategori Bisnis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <div class="avatar bg-warning me-3">
                                        <img src="{{ $category->image }}" alt="" srcset="" />
                                    </div>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="#" class="badge bg-primary">Edit</a>
                                    <a href="#" class="badge bg-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                Data Belum Tersedia!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
