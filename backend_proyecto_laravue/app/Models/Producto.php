<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function pedidos(): BelongsToMany {
        return $this->belongsToMany(Pedido::class)->withPivot(["cantidad"])
                                                    ->withTimestamps();
    }
}
