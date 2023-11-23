<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // dd($this);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $table->id();
        // $table->string('name');
        // $table->string('username');
        // $table->string('email')->unique();
        // $table->string('phone');
        // $table->string('region_code', 13);
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('photo_url')->nullable();
        // $table->string('password');
        // $table->string('bank_actnumber')->nullable();
        // $table->boolean('is_admin')->default(false);
        // $table->foreign('region_code')->references('code')->on('regions');
        // $table->rememberToken();
        // $table->timestamps();
        return [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|max:20',
            'region_code' => 'required|max:13|exists:regions,code',
            'password' => 'required|min:4|max:255',
            'photo' => 'required|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
