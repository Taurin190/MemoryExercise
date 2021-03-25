<?php

namespace App\Domain;

use App\User;

class WorkbookHistory
{
    private $workbook_history_id;

    private $exercise_count;

    private $ok_count;

    private $ng_count;

    private $studying_count;

    private $workbook;

    private $user;

    private function __construct(Answer $answer, Workbook $workbook, User $user)
    {
        $this->exercise_count = $answer->getExerciseCount();
        $this->ok_count = $answer->getOKCount();
        $this->ng_count = $answer->getNGCount();
        $this->studying_count = $answer->getStudyingCount();
        $this->workbook = $workbook;
        $this->user = $user;
    }

    public static function map(Answer $answer, Workbook $workbook, User $use)
    {
        return new WorkbookHistory($answer, $workbook, $use);
    }

    public function getWorkbookHistoryId()
    {
        return $this->workbook_history_id;
    }

    public function getExerciseCount()
    {
        return $this->exercise_count;
    }

    public function getOKCount()
    {
        return $this->ok_count;
    }

    public function getNGCount()
    {
        return $this->ng_count;
    }

    public function getStudyingCount()
    {
        return $this->studying_count;
    }

    public function getWorkbook()
    {
        return $this->workbook;
    }

    public function getUser()
    {
        return $this->user;
    }
}
