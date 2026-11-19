@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Kategori Item</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{ $category->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $category->nama }}</td>
                        </tr>
                    </table>

                    <h5 class="mt-3">Daftar Item</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($category->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ url('master-items/view/' . $item->kode) }}">{{ $item->kode }}</a></td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->harga_beli }}</td>
                                <td>{{ $item->harga_beli + $item->harga_beli * $item->laba / 100 }}</td>
                                <td>{{ $item->supplier }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada item di kategori ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a class="btn btn-success" href="{{ route('categories.pdf', $category) }}">Download PDF</a>
                    <a class="btn btn-info" href="{{ route('categories.edit', $category) }}">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
