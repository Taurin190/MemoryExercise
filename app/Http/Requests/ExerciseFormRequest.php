<?php

namespace App\Http\Requests;

use App\Dto\ExerciseDto;
use Illuminate\Foundation\Http\FormRequest;

class ExerciseFormRequest extends FormRequest
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

    public function messages()
    {
        return [
            'question.required' => '質問は必須です。',
            'question.max' => '質問は最大100文字です。',
            'answer.required' => '解答は必須です。',
            'answer.max' => '解答は最大100文字です。',
        ];
    }

    public function convertDtoByRequest($user_id, $exercise_id = null)
    {
        $validated = $this->validated();
        return new ExerciseDto(
            $validated->get('question'),
            $validated->get('answer'),
            $validated->get('permission'),
            $user_id,
            $exercise_id,
            $validated->get('label')
        );
    }

    public function storeSessions(ExerciseDto $exercise_dto, $postfix = '')
    {
        $this->session()->put('question' . $postfix, $exercise_dto->question);
        $this->session()->put('answer' . $postfix, $exercise_dto->answer);
        $this->session()->put('permission' . $postfix, $exercise_dto->permission);
        $this->session()->put('label' . $postfix, $exercise_dto->label_list);
    }
}
