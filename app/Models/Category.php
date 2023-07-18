<?php

namespace App\Models;

use App\Traits\Instance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Instance;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return Collection
     */
    public static function getPopularCategories(): Collection
    {
        return DB::table('categories as c')
            ->select('c.*', DB::raw("'' as description"), DB::raw("COUNT(r.id) as count"))
            ->join('products as p', 'p.category_id', '=', 'c.id')
            ->join('reviews as r', 'r.product_id', '=', 'p.id')
            ->groupBy('c.id')
            ->orderBy('count', 'desc')
            ->get();
    }
}
