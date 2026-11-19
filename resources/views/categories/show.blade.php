@extends('layouts.app')
@section('content')
<div class="container">
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-2">Kembali</a>

    <div class="card">
        <div class="card-header">Detail Kategori</div>
        <div class="card-body">
            <p><b>Nama:</b> {{ $category->nama }}</p>
            <p><b>Kode:</b> {{ $category->kode }}</p>

            <h6>Item dalam kategori ini</h6>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Supplier</th>
                        <th>Harga Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->items as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->kode }}</td>
                        <td>{{ $i->nama }}</td>
                        <td>{{ $i->jenis }}</td>
                        <td>{{ $i->supplier }}</td>
                        <td>{{ number_format($i->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada item</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection