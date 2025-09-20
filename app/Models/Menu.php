<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * The categories that belong to the menu.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_menu')
            ->withPivot(['id', 'parent_id', 'order']) // <-- 'id' اضافه شد
            ->orderBy('pivot_order'); // <-- بهتر است به pivot_order تغییر کند
    }
}
