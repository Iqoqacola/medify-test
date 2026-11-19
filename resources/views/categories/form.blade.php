@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">{{ $category->exists ? 'Edit Kategori' : 'Buat Kategori Baru' }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                        @csrf
                        @if ($category->exists)
                        @method('PUT')
                        @endif

                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" required value="{{ old('kode', $category->kode) }}">
                            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" required value="{{ old('nama', $category->nama) }}">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
