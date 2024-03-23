<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $rules['name']          = 'required|max:255';
        $rules['category_ids']  = 'required';
        $rules['category_id']   = ['required', Rule::in($this->category_ids)];
        $rules['unit']         = 'sometimes|required';
        $rules['min_qty']      = 'sometimes|required|numeric';
        $rules['unit_price']    = 'sometimes|required|numeric';
        if ($this->get('discount_type') == 'amount') {
            $rules['discount'] = 'sometimes|required|numeric|lt:unit_price';
        } else {
            $rules['discount'] = 'sometimes|required|numeric|lt:100';
        }
        $rules['current_stock'] = 'sometimes|required|numeric';
        $rules['starting_bid']  = 'sometimes|required|numeric|min:1';
        $rules['auction_date_range']  = 'sometimes|required';

        return $rules;
    }

    /**
     * Get the validation messages of rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'             => translate('Product name is required'),
            'category_ids.required'     => translate('Product category is required'),
            'category_id.required'      => translate('Main Category is required'),
            'category_id.in'            => translate('Main Category must be within selected categories'),
            'unit.required'             => translate('Product unit is required'),
            'min_qty.required'          => translate('Minimum purchase quantity is required'),
            'min_qty.numeric'           => translate('Minimum purchase must be numeric'),
            'unit_price.required'       => translate('Unit price is required'),
            'unit_price.numeric'        => translate('Unit price must be numeric'),
            'discount.required'         => translate('Discount is required'),
            'discount.numeric'          => translate('Discount must be numeric'),
            'discount.lt:unit_price'    => translate('Discount cannot be gretaer than unit price'),
            'current_stock.required'    => translate('Current stock is required'),
            'current_stock.numeric'     => translate('Current stock must be numeric'),
            'starting_bid.required'     => translate('Starting Bid is required'),
            'starting_bid.numeric'      => translate('Starting Bid must be numeric'),
            'starting_bid.required'     => translate('Minimum Starting Bid is 1'),
            'auction_date_range.required' => translate('Auction Date Range is required')
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        // dd($this->expectsJson());
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'message' => $validator->errors()->all(),
                'result' => false
            ], 422));
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
