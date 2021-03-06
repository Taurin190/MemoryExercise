<?php

namespace App\Domain;

use DateTime;

class StudyHistories
{
    private $studyId;

    private $userId;

    private $workbookId;

    private $studyHistoryList = [];

    private function __construct(array $parameters)
    {
        if (isset($parameters['study_id'])) {
            $this->studyId = $parameters['study_id'];
        }
        if (empty($parameters['user_id'])) {
            throw new DomainException('user_idが設定されていません。');
        }
        $this->userId = $parameters['user_id'];

        if (empty($parameters['workbook_id'])) {
            throw new DomainException('workbook_idが設定されていません。');
        }
        $this->workbookId = $parameters['workbook_id'];

        if (empty($parameters['exercise_study_map'])) {
            throw new DomainException('exercise_study_mapが設定されていません。');
        }
        foreach ($parameters['exercise_study_map'] as $exercise_id => $score) {
            $this->studyHistoryList[] = StudyHistory::create($exercise_id, $score);
        }
    }

    public function setStudyId($studyId)
    {
        if (isset($this->studyId)) {
            throw new DomainException('既にstudyIdが設定されています。');
        }
        $this->studyId = $studyId;
    }

    /**
     * @param array $parameters
     * @return StudyHistories
     * @throws DomainException
     */
    public static function createFromArray(array $parameters)
    {
        return new StudyHistories($parameters);
    }


    public function toRecords()
    {
        $studyHistoryArray = [];
        $now = new DateTime();
        foreach ($this->studyHistoryList as $studyHistory) {
            $studyHistoryArray[] = [
                'study_id' => $this->studyId,
                'workbook_id' => $this->workbookId,
                'exercise_id' => $studyHistory['exercise_id'],
                'user_id' => $this->userId,
                'score' => $studyHistory['score'],
                'created_at' => $now
            ];
        }
        return $studyHistoryArray;
    }
}
