<?php

namespace App\Dto;


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
}
