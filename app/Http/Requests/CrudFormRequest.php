<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CrudFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->student->id);
        $id = $this->student->id??null;
        return [
            'name'=>['required','string','max:200','min:3'],
            'email'=>['required','email',Rule::unique('students')->ignore($id)],
            'image'=>['nullable','mimes:png,jpg,webp'],
        ];

    }
}
