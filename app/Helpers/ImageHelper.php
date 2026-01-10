<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get product image URL with fallback to placeholder
     * 
     * @param string|null $imagePath
     * @param int $productId
     * @return string
     */
    public static function getProductImage($imagePath, $productId = null)
    {
        // If image exists, return storage URL
        if ($imagePath && file_exists(storage_path('app/public/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
        
        // Fallback to placeholder image with seed for consistency
        $seed = $productId ?? rand(1, 1000);
        return "https://picsum.photos/seed/product{$seed}/600/600";
    }
    
    /**
     * Get thumbnail image URL
     * 
     * @param string|null $imagePath
     * @param int $productId
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function getThumbnail($imagePath, $productId = null, $width = 200, $height = 200)
    {
        if ($imagePath && file_exists(storage_path('app/public/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
        
        $seed = $productId ?? rand(1, 1000);
        return "https://picsum.photos/seed/product{$seed}/{$width}/{$height}";
    }
}