<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kategori {{ $category->nama }}</title>
    <style>
        @page { margin: 40px 40px 60px 40px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 4px; }
        .info td { padding: 2px 6px 2px 0; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 12px; }
        table.items th, table.items td { border: 1px solid #444; padding: 5px; }
        table.items th { background: #eee; }
        .right { text-align: right; }
        footer { position: fixed; bottom: -40px; left: 0; right: 0; font-size: 10px; color: #555; border-top: 1px solid #ccc; padding-top: 4px; }
    </style>
</head>
<body>
    <footer>Dicetak pada: {{ $printed_at }}</footer>

    <h2>Detail Kategori</h2>
    <table class="info">
        <tr><td><b>Nama Kategori</b></td><td>: {{ $category->nama }}</td></tr>
        <tr><td><b>Kode Kategori</b></td><td>: {{ $category->kode }}</td></tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Laba (%)</th>
                <th>Harga Jual</th>
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
                <td class="right">{{ number_format($i->harga_beli, 0, ',', '.') }}</td>
                <td class="right">{{ $i->laba }}</td>
                <td class="right">{{ number_format($i->harga_beli + $i->harga_beli * $i->laba / 100, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center">Belum ada item</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
