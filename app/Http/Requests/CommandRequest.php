<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Command;

class CommandRequest extends FormRequest
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
       $command = Command::find($this->command);
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
                    'provider_id' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'provider_id' => 'required',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'provider_id.required' => 'Le command doit avoir un Fournisseur !',
        ];
    }
    public function response(array $errors){
        return response()->json($errors, 422);
    }
}
