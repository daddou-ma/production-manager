<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Fabrication;

class FabricationRequest extends FormRequest
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
       $fabrication = Fabrication::find($this->fabrication);
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
                    'product_id' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'product_id' => 'required',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Le fabrication doit avoir un produit !',
        ];
    }
    public function response(array $errors){
        return response()->json($errors, 422);
    }
}
