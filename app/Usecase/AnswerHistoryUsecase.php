<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/14
 * Time: 18:12
 */

namespace App\Usecase;
use App\Dto\ExerciseCountDto;
use App\User;
use App\Domain\Answer;
use App\Domain\Workbook;
use App\Domain\AnswerHistory;
use App\Domain\AnswerHistoryRepository;

class AnswerHistoryUsecase
{
    private $answerHistoryRepository;

    public function __construct(AnswerHistoryRepository $answerHistoryRepository) {
        $this->answerHistoryRepository = $answerHistoryRepository;
    }

    /**
     * 回答した内容を記録に残す
     * @param Answer $answer
     * @param Workbook $workbook
     * @param User $user
     */
    public function addAnswerHistory(Answer $answer, Workbook $workbook, User $user) {
        $answer_history = AnswerHistory::map($answer, $workbook, $user);
        $this->answerHistoryRepository->save($answer_history);
    }

    public function getAnswerHistoryForWorkbook(string $workbook_id) {

    }

    /**
     * ユーザが日毎に解答した問題数を取得する。
     * @param $user_id
     * @param $date_since
     * @param $date_until
     * @return
     */
    public function getExerciseHistoryCountWithUserId($user_id, $date_since, $date_until) {
        $exercise_history_list = $this->answerHistoryRepository->getExerciseHistoryByUserIdWithinTerm($user_id, $date_since, $date_until);
        return ExerciseCountDto::map($exercise_history_list);
    }

    /**
     * 問題の配列より解答回数をセットした連想配列を取得する
     * @param $user
     * @param $exercise_list
     * @return array
     */
    public function getExerciseHistoryCountByExerciseList($user, $exercise_list) {
        $exercise_history_list = $this->answerHistoryRepository->getExerciseHistoryByList($user->getKey(), $exercise_list);
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
