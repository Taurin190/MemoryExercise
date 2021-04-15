<?php


namespace App\Usecase;


use App\Domain\StudyHistories;
use App\Domain\StudyHistoryRepository;

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
}
