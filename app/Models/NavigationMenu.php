<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $table = 'navigation_menus';

    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'order',
        'target',
        'is_active',
        'show_on_homepage',
        'description',
        'content',
        'icon',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'order' => 'integer',
        'parent_id' => 'integer',
    ];

    /**
     * Get parent menu.
     */
    public function parent()
    {
        return $this->belongsTo(NavigationMenu::class, 'parent_id');
    }

    /**
     * Get child menus ordered by position.
     */
    public function children()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')->orderBy('order', 'asc');
    }
}
