<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
        // $table->id();
        //     $table->boolean('is_public')->default(false);
        //     $table->string('name');
        //     $table->string('type');
        //     $table->string('condition');
        //     $table->text('description');
        //     $table->integer('price');
        //     $table->integer('stock')->default(1);
        //     $table->foreignId('seller_id')->constrained('users');
        //     $table->timestamps();
        return [
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'condition' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
