<?php


namespace App\Domain;


use ArrayAccess;

class StudyHistory implements ArrayAccess
{
    private $exercise_id;

    private $score;

    private function __construct($exercise_id, $score)
    {
        $this->exercise_id = $exercise_id;
        $this->score = $score;
    }

    public static function create(string $exercise_id, int $score)
    {
        return new StudyHistory($exercise_id, $score);
    }

    public function offsetExists($offset)
    {
        if ($offset == 'exercise_id') return true;
        if ($offset == 'score') return true;
        return false;
    }

    public function offsetGet($offset)
    {
        if ($offset == 'exercise_id') return $this->exercise_id;
        if ($offset == 'score') return $this->score;
    }

    public function offsetSet($offset, $value)
    {
        // Not use this method
    }

    public function offsetUnset($offset)
    {
        // Not use this method
    }
}
