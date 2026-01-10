<?php

use App\Helpers\ImageHelper;

if (!function_exists('product_image')) {
    /**
     * Get product image URL with automatic fallback to placeholder
     * 
     * @param  string|null  $imagePath
     * @param  int|null  $productId
     * @return string
     */
    function product_image($imagePath, $productId = null)
    {
        return ImageHelper::getProductImage($imagePath, $productId);
    }
}

if (!function_exists('product_thumbnail')) {
    /**
     * Get product thumbnail URL
     * 
     * @param  string|null  $imagePath
     * @param  int|null  $productId
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    function product_thumbnail($imagePath, $productId = null, $width = 200, $height = 200)
    {
        return ImageHelper::getThumbnail($imagePath, $productId, $width, $height);
    }
}