<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'data_nascimento',
        'user_id',
        'endereco_id',
        'codigo_cus'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function endereco(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }
}
