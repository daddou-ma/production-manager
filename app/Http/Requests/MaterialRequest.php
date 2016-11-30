<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Material;

class MaterialRequest extends FormRequest
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
       $material = Material::find($this->material);
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
                    'name' => 'required|unique:materials|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:materials,name,'.$material->id.'|max:255',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'name.required' => 'Le material doit avoir un nom !',
            'name.unique' => 'Le nom d\'un material doit etre unique !',
        ];
    }
    public function response(array $errors){
        return response()->json($errors, 422);
    }
}
