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
        $route = $this->route()->getName();

        $route = $this->route()->getName();

        $rule = [
            'title' => 'required|string|max:50',
            'genre'=>'re',
            // 'due_date' => 'required|after_or_equal:today',
            'image'=>'required|file|image',
            'description' => 'required|string|max:2000',
            // 'is_published' => 'nullable|boolean',
        ];

        if ($route === 'posts.update') {
            $rule['due_date'] = 'required|date';
        }

        return $rule;

        if ($route === 'posts.update') {
            $rule['due_date'] = 'required|date';
        }

        return $rule;
    }
}
