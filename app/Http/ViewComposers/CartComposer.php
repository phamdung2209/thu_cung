<?php

namespace App\Http\ViewComposers;

use App\Models\Cart;
use Illuminate\View\View;

class CartComposer {
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $carts = [];
        if (auth()->user() != null) {
            $carts = Cart::where('user_id', auth()->user()->id)->get();
        } else {
            $temp_user_id = Session()->get('temp_user_id');
            if ($temp_user_id) {
                $carts = Cart::where('temp_user_id', $temp_user_id)->get();
            }
        }

        $view->with(['carts' => $carts]);
    }
}