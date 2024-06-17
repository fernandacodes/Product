<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'expiration_date',
        'image',
        'category_id' // Adicionando a chave estrangeira
    ];

    public function category() // Definindo a relação
    {
        return $this->belongsTo(Category::class); // Assumindo que existe um modelo Category
    }
}
