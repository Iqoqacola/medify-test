<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-group">
        <label for="image">Foto</label>

        <div class="mb-2">
            <img id="preview"
                src="{{ !empty($item->img) ? asset('storage/' . $item->img) : '' }}"
                alt="Preview"
                class="img-thumbnail {{ empty($item->img) ? 'd-none' : '' }}"
                style="max-width: 200px;">
        </div>

        <input type="file" name="img" id="image" accept="image/*">
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected=='' ) selected @endif value="">--Pilih--</option>
            <option @if($selected=='Tokopaedi' ) selected @endif>Tokopaedi</option>
            <option @if($selected=='Bukulapuk' ) selected @endif>Bukulapuk</option>
            <option @if($selected=='TokoBagas' ) selected @endif>TokoBagas</option>
            <option @if($selected=='E Commurz' ) selected @endif>E Commurz</option>
            <option @if($selected=='Blublu' ) selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected=='' ) selected @endif value="">--Pilih--</option>
            <option @if($selected=='Obat' ) selected @endif>Obat</option>
            <option @if($selected=='Alkes' ) selected @endif>Alkes</option>
            <option @if($selected=='Matkes' ) selected @endif>Matkes</option>
            <option @if($selected=='Umum' ) selected @endif>Umum</option>
            <option @if($selected=='ATK' ) selected @endif>ATK</option>
        </select>
    </div>

    @php $selected_categories = old('categories', !empty($item) ? $item->categories->pluck('id')->toArray() : []); @endphp
    <div class="form-group">
        <label>Kategori</label>
        <div>
            @forelse ($categories as $category)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="categories[]" id="kategori-{{ $category->id }}" value="{{ $category->id }}" @if(in_array($category->id, $selected_categories)) checked @endif>
                <label class="form-check-label" for="kategori-{{ $category->id }}">{{ $category->nama }}</label>
            </div>
            @empty
            <small class="text-muted">Belum ada kategori, <a href="{{ route('categories.create') }}">tambah kategori</a></small>
            @endforelse
        </div>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>