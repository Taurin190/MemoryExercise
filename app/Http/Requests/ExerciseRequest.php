<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
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
            'question' => 'required|max:100',
            'answer' => 'required|max:100',
        ];
    }

    public function messages(){
        return [
            'question.required' => '質問は必須です。',
            'question.max' => '質問は最大100文字です。',
            'answer.required' => '解答は必須です。',
            'answer.max' => '解答は最大100文字です。',
        ];
    }
}
