<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/14
 * Time: 18:12
 */

namespace App\Usecase;
use App\Domain\Answer;
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
     */
    public function addAnswerHistory(Answer $answer) {
        $answer_history = AnswerHistory::map($answer);
        $this->answerHistoryRepository->save($answer_history);
    }

    public function getAnswerHistoryForWorkbook(string $workbook_id) {

    }
}
