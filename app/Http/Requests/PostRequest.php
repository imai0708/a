<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
        return [
            'title' => 'required|string|max:50',
            'item_id' => 'required|exists:items,id',
            'genre_id' => 'required|exists:genres,id',
            'situation_id' => 'required|exists:situation,id',
            'due_date' => 'required|after_or_equal:today',
            'description' => 'required|string|max:2000',
            'status' => 'nullable|boolean',
        ];
    }
}
