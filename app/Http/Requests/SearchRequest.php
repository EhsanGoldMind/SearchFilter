<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'sometimes|nullable|numeric|between:0,2',
            'customer' => 'sometimes|nullable|string|max:12',
            'amount' => 'sometimes|nullable|between:0,9000000|regex:/^\d{1,3}(_\d{3})*$/'
        ];
    }

    public function messages()
    {
        return [
            'customer.max' => 'مقدار وارد شده برای مشتری نباید بیش از ۱۲ کاراکتر باشد.',
            'status.numeric' => 'وضعیت باید عددی باشد.',
            'status.between' => 'وضعیت باید عددی بین 0 تا 2 باشد.',
            'amount.between' => 'مبلغ باید بین 0 تا 9,000,000 باشد.',
            'amount.regex' => 'فرمت مبلغ باید با الگوی 1_000_000 مطابقت داشته باشد.',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            failValidate($validator)
        );
    }
}
