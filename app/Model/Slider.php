<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the desktop image asset URL.
     *
     * @return string|null
     */
    public function getDesktopImageUrlAttribute()
    {
        if (!$this->image_url) {
            return null;
        }

        if (file_exists(public_path('storage/images/sliders/desktop/' . $this->image_url))) {
            return asset('storage/images/sliders/desktop/' . $this->image_url);
        }

        return asset('storage/images/sliders/' . $this->image_url);
    }

    /**
     * Get the mobile image asset URL.
     *
     * @return string|null
     */
    public function getMobileImageUrlAttribute()
    {
        if ($this->mobile_image) {
            if (file_exists(public_path('storage/images/sliders/mobile/' . $this->mobile_image))) {
                return asset('storage/images/sliders/mobile/' . $this->mobile_image);
            }
            if (file_exists(public_path('storage/images/sliders/' . $this->mobile_image))) {
                return asset('storage/images/sliders/' . $this->mobile_image);
            }
            return asset('storage/images/sliders/mobile/' . $this->mobile_image);
        }

        return $this->desktop_image_url;
    }
}
