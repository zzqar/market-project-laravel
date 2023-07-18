<?php

namespace App\Models;

use App\Traits\Instance;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


/**
 * App\Models\Product
 *
 * @property int $id
 * @property string|null $title
 * @property string $description
 * @property string $image
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Instance;

    protected $fillable = [
        'title', 'description', 'cost', 'category_id', 'image'
    ];

    public function products()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param int $categoryID
     * @return \Illuminate\Support\Collection
     */
    public function getProductsByCategoryId(int $categoryID): \Illuminate\Support\Collection
    {
        return DB::table('products as p')
            ->select('p.*', DB::raw("COUNT(r.id) as count"))
            ->where('category_id', '=', $categoryID)
            ->leftJoin('reviews as r', 'r.product_id', '=', 'p.id')
            ->groupBy('p.id')->get();
    }
}
