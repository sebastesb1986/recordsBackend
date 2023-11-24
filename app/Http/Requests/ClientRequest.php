<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;


class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = ( ($this->getMethod() === 'PUT') ? $this->id : null);

        return [

            'businessid' => 'required', 
            'email' => 'required|email|unique:clients,email,'.$id,
            'phone' => 'required', 
            'start_at' => 'required|date', 
            'end_at' => 'required|date|after_or_equal:start_at',

        ];
    }

    public function attributes()
    {
        return [

            'businessid' => 'Identificador de negocio', 
            'email' => 'Coreo electrónico',
            'phone' => 'Teléfono', 
            'start_at' => 'Fecha inicial', 
            'end_at' => 'Fecha final'
             
        ];
    }

    public function messages()
    {
      
        return [

            'businessid.required' => 'Digite nombre(s)',
            'email.required' => 'Digite correo electrónico',
            'email.unique' => 'El correo electrónico ya se encuentra registrado',
            'email.email' => 'Correo electrónico no valido',
            'phone.required' => 'Digite teléfono',
            'start_at.required' => 'Digite fecha inicial',
            'start_at.date' => 'Fecha inicial NO valida',
            'end_at.required' => 'Digite fecha final',
            'end_at.date' => 'Fecha final NO valida',
            'end_at.after_or_equal' => 'La fecha final no puede ser inferior a la fecha inicial',

           
        ];
    }

    public function failedValidation(Validator $validator) { 
        //write your bussiness logic here otherwise it will give same old JSON response
       throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422)); 
   }
}
