<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\CategoryCollection;
use App\Models\BusinessSetting;
use App\Models\Category;
use Cache;

class CategoryController extends Controller
{

    public function index($parent_id = 0)
    {
        if(request()->has('parent_id') && is_numeric (request()->get('parent_id'))){
          $parent_id = request()->get('parent_id');
        }
        
            return new CategoryCollection(Category::where('parent_id', $parent_id)->whereDigital(0)->get());
    }

    public function featured()
    {
            return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function home()
    {
            return new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_categories')))->get());
    }

    public function top()
    {   
            return new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_categories')))->limit(20)->get());
    }
}
