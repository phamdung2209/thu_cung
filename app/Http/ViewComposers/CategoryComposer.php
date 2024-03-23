<?php
namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer {


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories_query = Category::query()->with('coverImage');
        $categories = $categories_query->where('level', 0)->orderBy('order_level', 'desc')->get();
        
        $view->with(['categories' => $categories]);
    }

}