<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Provider;

class ProviderRequest extends FormRequest
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
       $provider = Provider::find($this->provider);
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
                    'full_name' => 'required|unique:providers|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'full_name' => 'required|unique:providers,full_name,'.$provider->id.'|max:255',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'full_name.required' => 'Le provider doit avoir un nom !',
            'full_name.unique' => 'Le nom d\'un provider doit etre unique !',
        ];
    }
    public function response(array $errors){
        return response()->json($errors, 422);
    }
}
