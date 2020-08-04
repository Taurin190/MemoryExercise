<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:25
 */

namespace App\Domain;


class ExerciseHistory
{
    private $exercise_history_id;

    private $score;

    private $user;

    private $exercise;

    public static function create($user, $exercise, $score) {
        return new ExerciseHistory($user, $exercise, $score);
    }

    private function __construct($user, $exercise, $score, $exercise_history_id = null) {
        $this->user = $user;
        $this->exercise = $exercise;
        switch ($score) {
            case "ok":
                $this->score = 2;
                break;
            case "ng":
                $this->score = -1;
                break;
            case "studying":
                $this->score = 1;
                break;
            default:
                $this->score = 0;
                break;
        }
        if (isset($exercise_history_id)) {
            $this->exercise_history_id = $exercise_history_id;
        }
    }

    public function getExerciseHistoryId() {
        return $this->exercise_history_id;
    }

    public function getScore() {
        return $this->score;
    }

    public function getUser() {
        return $this->user;
    }

    public function getExercise() {
        return $this->exercise;
    }
}
