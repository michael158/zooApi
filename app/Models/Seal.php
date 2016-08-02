<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seal extends Model
{
    protected $table = 'seals';

    protected $fillable = ['name', 'date_birth', 'qtd_childrens'];


    public function babies()
    {
        return $this->hasMany(BabySeal::class);
    }
}
