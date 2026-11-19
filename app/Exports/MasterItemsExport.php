<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterItemsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return MasterItem::with('categories')->orderBy('id')->get()->values()->map(function ($item, $index) {
            $harga_jual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

            return [
                $index + 1,
                $item->categories->pluck('nama')->implode(', '),
                $item->nama,
                $item->supplier,
                $item->harga_beli,
                $item->laba,
                $harga_jual,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Kategori', 'Nama Items', 'Nama Supplier', 'Harga', 'Laba', 'Harga Jual'];
    }
}
