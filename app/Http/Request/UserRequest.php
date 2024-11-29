<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'document' => 'required|string|unique:users,document,' . $this->user,
            'document_type' => 'required|string',
            'phone_number' => 'nullable|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user,
            'password' => 'sometimes|required|string|min:8',
            'google_id' => 'nullable|string|unique:users,google_id,' . $this->user,
            'github_id' => 'nullable|string|unique:users,github_id,' . $this->user,
        ];
    }
}
