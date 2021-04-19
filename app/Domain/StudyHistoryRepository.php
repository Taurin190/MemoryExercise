<?php

namespace App\Domain;

use DateTime;

interface StudyHistoryRepository
{
    public function save(StudyHistories $studyHistories): void;

    public function inquireStudySummary($user_id, DateTime $date_since, DateTime $date_until): StudySummary;
}
