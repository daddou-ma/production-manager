<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Command;

class DeliveryRequest extends FormRequest
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
       $delivery = Command::find($this->delivery);
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
                    'client_id' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'client_id' => 'required',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'client_id.required' => 'Le delivery doit avoir un Fournisseur !',
        ];
    }
}
