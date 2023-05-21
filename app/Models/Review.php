<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'content',
    ];

    protected $dates = [
        'deleted_at',
    ];

    // Определите отношение к модели "Товары"
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Определите отношение к модели "Пользователи"
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
