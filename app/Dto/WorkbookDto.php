<?php

namespace App\Dto;


use Illuminate\Support\Facades\Log;

class WorkbookDto
{
    public $workbook_id;

    public $title;

    public $explanation;

    public $exercise_list = [];

    public $user_id;

    function __construct($title, $explanation, $exercise_list, $user_id, $workbook_id = null)
    {
        $this->title = $title;
        $this->explanation = $explanation;
        $this->exercise_list = $exercise_list;
        $this->user_id = $user_id;
        $this->workbook_id = $workbook_id;
    }

    public function toArray()
    {
        $exercise_list_array = [];
        foreach ($this->exercise_list as $exercise) {
            $exercise_list_array[] = $exercise->toArray();
        }
        return [
            'title' => $this->title,
            'explanation' => $this->explanation,
            'user_id' => $this->user_id,
            'workbook_id' => $this->workbook_id,
            'exercise_list' => $exercise_list_array
        ];
    }
}
