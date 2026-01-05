<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_name',
        'section_key',
        'content',
        'content_type',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active contents
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for specific page
    public function scopeForPage($query, $pageName)
    {
        return $query->where('page_name', $pageName);
    }

    // Helper method to get content by page and section
    public static function getContent($pageName, $sectionKey, $default = '')
    {
        $content = self::active()
                      ->forPage($pageName)
                      ->where('section_key', $sectionKey)
                      ->first();
        
        return $content ? $content->content : $default;
    }
}
