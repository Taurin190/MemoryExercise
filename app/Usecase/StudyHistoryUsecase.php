<?php


namespace App\Usecase;


use App\Domain\StudyHistories;
use App\Domain\StudyHistoryRepository;
use DateTime;

class StudyHistoryUsecase
{
    private $studyHistoryRepository;

    public function __construct(StudyHistoryRepository $studyHistoryRepository)
    {
        $this->studyHistoryRepository = $studyHistoryRepository;
    }

    public function saveStudyHistory($workbookId, $answerMap, $userId)
    {
        $studyHistoriesDomain = StudyHistories::createFromArray([
            'workbook_id' => $workbookId,
            'user_id' => $userId,
            'exercise_study_map' => $answerMap
        ]);
        $this->studyHistoryRepository->save($studyHistoriesDomain);
    }

    public function getStudySummary($user_id, $date_since = null, $date_until = null)
    {
        if (is_null($date_since)) {
            $date_since = new DateTime('first day of this month');
        }
        if (is_null($date_until)) {
            $date_until = new DateTime('last day of this month');
        }
        return $this->studyHistoryRepository->inquireStudySummary($user_id, $date_since, $date_until)->getDto();
    }
}
