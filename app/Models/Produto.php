<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['id_produto'];
    use HasFactory;

    function vendas()
    {
        return $this->belongsToMany(Venda::class);
    }
}
