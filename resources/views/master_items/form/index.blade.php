@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-items')}}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="card">

                @if($method == 'new')
                <div class="card-header">Buat Master Item Baru</div>
                @else
                <div class="card-header">Edit Master Item</div>
                @endif

                <div class="card-body">
                    @include('master_items.form.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        var file = e.target.files[0];
        var preview = document.getElementById('preview');
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    });
</script>
@endsection