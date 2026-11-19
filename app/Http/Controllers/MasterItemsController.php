<?php

namespace App\Http\Controllers;

use App\Exports\MasterItemsExport;
use App\Models\Kategori;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $data_search = MasterItem::query();

        if ($request->filled('kode')) {
            $data_search->where('kode', $request->kode);
        }
        if ($request->filled('nama')) {
            $data_search->where('nama', 'LIKE', '%' . $request->nama . '%');
        }
        if ($request->filled('hargamin')) {
            $data_search->where('harga_beli', '>=', $request->hargamin);
        }
        if ($request->filled('hargamax')) {
            $data_search->where('harga_beli', '<=', $request->hargamax);
        }

        $data_search = $data_search->with('categories')
            ->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')
            ->orderBy('id')
            ->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
        }

        $data['item'] = $item;
        $data['method'] = $method;
        $data['categories'] = Kategori::orderBy('nama')->get();

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('categories')->where('kode', $kode)->firstOrFail();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'img'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'nama'         => ['required', 'string', 'max:255'],
            'harga_beli'   => ['required', 'integer', 'min:0'],
            'laba'         => ['required', 'integer', 'min:0'],
            'supplier'     => ['required', 'in:Tokopaedi,Bukulapuk,TokoBagas,E Commurz,Blublu'],
            'jenis'        => ['required', 'in:Obat,Alkes,Matkes,Umum,ATK'],
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['exists:kategoris,id'],
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $last_id = MasterItem::withTrashed()->max('id');
            $kode = str_pad(($last_id ?? 0) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        if ($request->hasFile('img')) {
            $data_item->img = $request->file('img')->store('master-items', 'public');
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        $data_item->categories()->sync($request->input('categories', []));

        return redirect('master-items');
    }

    public function exportExcel()
    {
        return Excel::download(new MasterItemsExport, 'master-items.xlsx');
    }

    public function delete($id)
    {
        MasterItem::findOrFail($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
