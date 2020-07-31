<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/14
 * Time: 18:12
 */

namespace App\Usecase;
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
     */
    public function addAnswerHistory(Answer $answer, Workbook $workbook) {
        $answer_history = AnswerHistory::map($answer, $workbook);
        $this->answerHistoryRepository->save($answer_history);
    }

    public function getAnswerHistoryForWorkbook(string $workbook_id) {

    }
}
