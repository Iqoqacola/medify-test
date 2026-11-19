@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('categories.create') }}" class="btn btn-secondary">+ Kategori Baru</a>
            </div>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Daftar Kategori Items</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('categories.index') }}">
                        <h4>Filter</h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ request('nama') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{ request('kode') }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-1">Filter</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-light mt-1">Reset</a>
                    </form>

                    <table class="table table-striped mt-3" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jumlah Item</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $c)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td>{{ $c->kode }}</td>
                                <td>{{ $c->nama }}</td>
                                <td>{{ $c->items_count }}</td>
                                <td><a href="{{ route('categories.show', $c) }}" class="btn btn-primary">View</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
