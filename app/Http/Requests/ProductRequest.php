<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Product;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    protected $forceJsonResponse = true;

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
       $product = Product::find($this->product);
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'Le product doit avoir un nom !',
        ];
    }
}
