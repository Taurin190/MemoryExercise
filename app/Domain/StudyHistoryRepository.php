<?php

namespace App\Domain;

interface StudyHistoryRepository
{
    public function save(StudyHistories $studyHistories): void;
}
