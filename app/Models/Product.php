<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'imagem',
        'categoria',
        'valor',
        'tem_estoque',
        'client_id',
    ];

    public function client(): HasMany
    {
        return $this->HasMany(Client::class);
    }
}
