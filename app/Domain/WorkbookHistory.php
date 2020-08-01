<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:26
 */

namespace App\Domain;
use App\Domain\Workbook;
use App\Domain\Answer;
use App\User;

class WorkbookHistory
{
    private $exercise_count;

    private $ok_count;

    private $ng_count;

    private $studying_count;

    private $workbook;

    private function __construct(Answer $answer, Workbook $workbook, User $user) {
        $this->exercise_count = $answer->getExerciseCount();
        $this->ok_count = $answer->getOKCount();
        $this->ng_count = $answer->getNGCount();
        $this->studying_count = $answer->getStudyingCount();
        $this->workbook = $workbook;
    }

    public static function map(Answer $answer, Workbook $workbook, User $use) {
        return new WorkbookHistory($answer, $workbook, $use);
    }
}
