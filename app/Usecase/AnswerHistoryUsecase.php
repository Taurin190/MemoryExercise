<?php

namespace App\Usecase;

use App\Domain\Answer;
use App\Domain\AnswerHistory;
use App\Domain\AnswerHistoryRepository;
use App\Domain\Workbook;
use App\Dto\AnswerDto;
use App\Dto\StudyHistoryDto;
use App\Dto\WorkbookDto;
use DateTime;

class AnswerHistoryUsecase
{
    private $answerHistoryRepository;

    public function __construct(
        AnswerHistoryRepository $answerHistoryRepository
    ) {
        $this->answerHistoryRepository = $answerHistoryRepository;
    }

    public function registerAnswerHistory(WorkbookDto $workbook_dto, AnswerDto $answer_dto, $user)
    {
        $workbook_domain = Workbook::createByDto($workbook_dto, $user);
        $answer_domain = Answer::createFromDto($answer_dto);
        $answer_history = AnswerHistory::map($answer_domain, $workbook_domain, $user);
        $this->answerHistoryRepository->save($answer_history);
    }

    /**
     * ユーザの学習履歴を取得する
     * @param $user_id
     * @param $date_since
     * @param $date_until
     * @return StudyHistoryDto
     */
    public function getStudyHistoryOfUser($user_id, $date_since, $date_until)
    {
        $graph_date_since = new DateTime('first day of this month');
        $graph_date_until = new DateTime('last day of this month');
        $exercise_history_table = $this->answerHistoryRepository
            ->getExerciseHistoryDailyCountTableWithinTerm(
                $user_id,
                $graph_date_since,
                $graph_date_until
            );
        $monthly_count = $this->answerHistoryRepository
            ->getExerciseHistoryCountByUserIdWithinTerm(
                $user_id,
                $graph_date_since,
                $graph_date_until
            );
        $total_count = $this->answerHistoryRepository->getExerciseHistoryTotalCount($user_id);
        $total_days = $this->answerHistoryRepository->getExerciseHistoryTotalDays($user_id);
        return StudyHistoryDto::map($exercise_history_table, $monthly_count, $total_count, $total_days);
    }

    /**
     * 問題の配列より解答回数をセットした連想配列を取得する
     * @param $user
     * @param $exercise_list
     * @return array
     */
    public function getExerciseHistoryCountByExerciseList($user, $exercise_list)
    {
        $exercise_history_list = $this->answerHistoryRepository
            ->getExerciseHistoryByList(
                $user->getKey(),
                $exercise_list
            );
        $exercise_count_list = [];
        foreach ($exercise_history_list as $exercise_history) {
            $exercise_id = $exercise_history->exercise_id;
            if (array_key_exists($exercise_id, $exercise_count_list)) {
                $tmp_count = $exercise_count_list[$exercise_id];
                $exercise_count_list[$exercise_id] = $tmp_count + 1;
            } else {
                $exercise_count_list[$exercise_id] = 1;
            }
        }
        return $exercise_count_list;
    }
}
