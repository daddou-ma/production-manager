<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Client;

class ClientRequest extends FormRequest
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
       $client = Client::find($this->client);
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
                    'full_name' => 'required|unique:clients|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'full_name' => 'required|unique:clients,full_name,'.$client->id.'|max:255',
                ];
            }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'full_name.required' => 'Le client doit avoir un nom !',
            'full_name.unique' => 'Le nom d\'un client doit etre unique !',
        ];
    }
}
