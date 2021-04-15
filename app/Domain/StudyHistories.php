<?php

namespace App\Domain;

class StudyHistories
{
    private $studyId;

    private $userId;

    private $workbookId;

    private $studyHistoryList = [];

    private function __construct(array $parameters)
    {
        $this->studyId = $parameters['study_id'];

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
        foreach ($this->studyHistoryList as $studyHistory) {
            $studyHistoryArray[] = [
                'study_id' => $this->studyId,
                'workbook_id' => $this->workbookId,
                'exercise_id' => $studyHistory['exercise_id'],
                'user_id' => $this->userId,
                'score' => $studyHistory['score']
            ];
        }
        return $studyHistoryArray;
    }
}
