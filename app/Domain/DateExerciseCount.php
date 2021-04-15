<?php


namespace App\Domain;

use ArrayAccess;

class DateExerciseCount implements ArrayAccess
{
    private $date;

    private $exerciseCount;

    public function __construct($date, int $exerciseCount)
    {
        $this->date = $date;
        $this->exerciseCount = $exerciseCount;
    }

    public function offsetExists($offset)
    {
        if ($offset == 'date') {
            return true;
        }
        if ($offset == 'count') {
            return true;
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if ($offset == 'date') {
            return $this->date;
        }
        if ($offset == 'count') {
            return $this->exerciseCount;
        }
        return null;
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
