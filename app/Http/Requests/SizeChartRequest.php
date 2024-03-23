<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SizeChartRequest extends FormRequest
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
        return [
            'name'                => ['required', 'max:255'],
            'category_id'         => ['required', 'numeric', Rule::unique('size_charts')->ignore($this->id)],
            'fit_type'            => ['nullable'],
            'stretch_type'        => ['nullable'],
            'photos'              => ['nullable'],
            'description'         => ['nullable'],
            'measurement_points'  => ['required'],
            'size_options'        => ['required'],
            'measurement_option'  => ['required'],
            'size_chart_values.*' => ['required']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'                => translate('Chart Name is required'),
            'name.max'                     => translate('Chart Name allow max 255 characters'),
            'category_id.required'         => translate('Category is required'),
            'category_id.numeric'          => translate('Category should be numeric type'),
            'category_id.unique'           => translate('This Category is already been taken'),
            'measurement_points.required'  => translate('Measurement points are required'),
            'size_options.required'        => translate('Size options are required'),
            'measurement_option.required'  => translate('Measurement Type is required'),
            'size_chart_values.*.required' => translate('Size chart values are required'),
        ];
    }

    protected function prepareForValidation()
    {
        $measurement_points = json_encode($this->measurement_points);
        $size_options = json_encode($this->size_options);
        $measurement_option = isset($this->measurement_option) ? json_encode($this->measurement_option) :  null;

        $this->merge([
            'measurement_points' => $measurement_points,
            'size_options'       => $size_options,
            'measurement_option' => $measurement_option
        ]);
    }
}
