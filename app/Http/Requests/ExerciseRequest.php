<?php


namespace App\Http\Requests;

use App\Dto\ExerciseDto;
use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function convertDtoBySession($user_id, $post_fix = '', $exercise_id = null)
    {
        return new ExerciseDto(
            $this->session()->pull('question' . $post_fix, ''),
            $this->session()->pull('answer' . $post_fix, ''),
            $this->session()->pull('permission' . $post_fix, 1),
            $user_id,
            $exercise_id,
            $this->session()->pull('label' . $post_fix, [])
        );
    }
}
