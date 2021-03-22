<?php


namespace App\Http\Requests;

use App\Dto\WorkbookDto;
use Illuminate\Foundation\Http\FormRequest;

class WorkbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function convertDtoBySession($user_id, $post_fix = '', $workbook_id = null)
    {
        return new WorkbookDto(
            $this->session()->pull('title' . $post_fix, ''),
            $this->session()->pull('explanation' . $post_fix, ''),
            $this->session()->pull('exercise_list' . $post_fix, null),
            $user_id,
            $workbook_id
        );
    }
}
