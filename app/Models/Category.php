<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    /**
     * Get the parent for the category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the children for the category.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    /**
     * The sections that belong to the category.
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    /**
     * The menus that belong to the category.
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class)
            ->withPivot(['parent_id', 'order']);
    }
}
