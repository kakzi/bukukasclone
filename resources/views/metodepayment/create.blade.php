<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Metode Pembayaran</h3>
                <p class="text-subtitle text-muted">Input Data Metode Pembayaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('metode_payment.index') }}">Metode Payment</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Form Metode Pembayaran
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>


    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Data Metode Payment</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('metode_payment.store') }}" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Metode Payment</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Metode Payment" />
                            </div>
                            <div class="col-md-4">
                                <label>Icon</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input class="form-control" name="icon" type="file" id="formFile" />
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>