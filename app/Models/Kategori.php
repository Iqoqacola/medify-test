<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama', 'kode'];

    public function items()
    {
        return $this->belongsToMany(MasterItem::class, 'kategori_item', 'category_id', 'master_item_id')->withTimestamps();
    }
}
