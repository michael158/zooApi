<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabySeal extends Model
{

    protected $table = 'baby_seals';


    protected $fillable = ['name', 'date_birth', 'live','seal_id'];

    public function mother()
    {
        return $this->belongsTo(Seal::class, 'seal_id');
    }

}
