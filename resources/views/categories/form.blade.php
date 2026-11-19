@extends('layouts.app')
@section('content')
<div class="container">
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-2">Kembali</a>

    <div class="card">
        <div class="card-header">{{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori' }}</div>
        <div class="card-body">
            <form method="POST"
                action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                @csrf
                @if ($category->exists)
                @method('PUT')
                @endif

                <div class="mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $category->nama) }}">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-2">
                    <label>Kode</label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                        value="{{ old('kode', $category->kode) }}">
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection