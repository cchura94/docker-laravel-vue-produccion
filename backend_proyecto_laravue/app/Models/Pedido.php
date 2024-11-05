<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    use HasFactory;

    public function cliente(): BelongsTo{
        return $this->belongsTo(Cliente::class);
    }

    public function productos(): BelongsToMany {
        return $this->belongsToMany(Producto::class)->withPivot(["cantidad"])
                                                    ->withTimestamps();
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
