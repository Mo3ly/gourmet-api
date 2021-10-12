<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $category_id
 * @property integer $media_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $desc_ar
 * @property string $desc_en
 * @property int $price
 * @property string $options
 * @property string $additions
 * @property string $group_id
 * @property string $created_at
 * @property string $updated_at
 * @property MenuCategory $menuCategory
 * @property Medium $medium
 */
class MenuProduct extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 
        'media_id', 
        'name_ar', 
        'name_en', 
        'desc_ar', 
        'desc_en', 
        'price', 
        'isNew', 
        'isSpecial', 
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCategory()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getMedia()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
