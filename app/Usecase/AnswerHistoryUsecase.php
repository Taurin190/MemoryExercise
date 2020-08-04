<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/14
 * Time: 18:12
 */

namespace App\Usecase;
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
     * 問題の解答履歴を対象の問題配列より取得する
     * @param User $user
     * @param $exercise_list
     * @return array
     */
    public function getExerciseHistoryFromExerciseList(User $user, $exercise_list) {
        return [];
    }
}
