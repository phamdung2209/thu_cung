<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\SliderCollection;
use Cache;

class SliderController extends Controller
{
    public function sliders()
    {
        $sliders = get_setting('home_slider_images', null, request()->header('App-Language'));
        return new SliderCollection($sliders != null ? json_decode($sliders, true) : []);
    }

    public function bannerOne()
    {
        $bannersOne = get_setting('home_banner1_images', null, request()->header('App-Language'));
        return new SliderCollection($bannersOne != null ? json_decode($bannersOne, true) : []);
    }

    public function bannerTwo()
    {
        $bannersTwo = get_setting('home_banner2_images', null, request()->header('App-Language'));
        return new SliderCollection($bannersTwo != null ? json_decode($bannersTwo, true) : []);
    }

    public function bannerThree()
    {
        $bannersThree = get_setting('home_banner3_images', null, request()->header('App-Language'));
        return new SliderCollection($bannersThree != null ? json_decode($bannersThree, true) : []);
    }
}
