<?php

namespace App\Http\Requests;

use App\Dto\WorkbookDto;
use Illuminate\Foundation\Http\FormRequest;

class WorkbookFormRequest extends FormRequest
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
            'title' => 'required|max:256',
            'explanation' => 'max:3000',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは最大256文字です。',
            'explanation.max' => '説明文は最大3000文字です。',
        ];
    }

    public function convertDtoByRequest($user_id, $workbook_id = null)
    {
        return new WorkbookDto(
            $this->get('title'),
            $this->get('explanation', ''),
            $this->get('exercise_list', []),
            $user_id,
            $workbook_id
        );
    }

    public function storeSessions(WorkbookDto $workbook_dto, $postfix = '')
    {
        $this->session()->put('title' . $postfix, $workbook_dto->title);
        $this->session()->put('explanation' . $postfix, $workbook_dto->explanation);
        $this->session()->put('exercise_list' . $postfix, $workbook_dto->exercise_list);
    }
}
