@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Kategori Items</div>
        <div class="card-body">
            <form method="GET" action="{{ route('categories.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" name="nama" value="{{ request('nama') }}" class="form-control" placeholder="Nama kategori">
                </div>
                <div class="col-md-4">
                    <input type="text" name="kode" value="{{ request('kode') }}" class="form-control" placeholder="Kode kategori">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Reset</a>
                    <a href="{{ route('categories.create') }}" class="btn btn-success">+ Kategori</a>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $c)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>{{ $c->nama }}</td>
                        <td>{{ $c->kode }}</td>
                        <td>
                            <a href="{{ route('categories.show', $c) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('categories.edit', $c) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('categories.destroy', $c) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection