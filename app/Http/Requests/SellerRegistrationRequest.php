<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SellerRegistrationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        
        $rules['name']          = 'required|string|max:255';
        $rules['email']         = 'required|email|unique:users|max:255';
        $rules['password' ]     = 'required|string|min:6|confirmed';
        $rules['shop_name' ]    = 'required|max:255';
        $rules['address']       = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => translate('Name is required'),
            'name.string'           => translate('Name should be string type'),
            'name.max'              => translate('Max 255 characters'),
            'email.required'        => translate('Email is required'),
            'email.email'           => translate('Please type a valid email'),
            'email.unique'          => translate('Email should be unique'),
            'email.max'             => translate('Max 255 characters'),
            'password.required'     => translate('Password is required'),
            'password.string'       => translate('Password should be string type'),
            'password.min'          => translate('Min 6 characters'),
            'password.confirmed'    => translate('Confirm password do not matched'),
            'shop_name.required'    => translate('Shop name is required'),
            'shop_name.max'         => translate('Max 255 characters'),
            'address.required'      => translate('Address is required'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
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
