<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/04/24
 * Time: 18:13
 */

namespace App\Usecase;


use App\Domain\WorkbookRepository;

class WorkbookUsecase
{
    private $repository;

    public function __construct(WorkbookRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * 指定した問題集を取得する
     * @param $workbook_id int 問題集のID
     */
    public function getWorkbook($workbook_id) {

    }

    /**
     * 問題集を全て取得する
     */
    public function getAllWorkbook() {

    }

    /**
     * 問題集を作成する
     * @param $name string 問題集名
     * @param $description string 問題集の説明
     * @return int 問題集のID
     */
    public function createWorkbook($name, $description) {
        return $this->repository->add($name, $description);
    }

    /**
     * 問題集を編集する
     * @param $wordbook_id int 問題集のID
     * @param $name string 問題集の名前
     * @param $description string 問題集の説明
     * @return int 問題集のID
     */
    public function modifyWorkbook($wordbook_id, $name, $description) {
        return $this->repository->modify($wordbook_id, $name, $description);
    }

    /**
     * 問題集を削除する
     * @param $wordbook_id int 削除する問題集のID
     */
    public function deleteWorkbook($wordbook_id) {

    }

    /**
     * 問題を問題集に登録する
     * @param $workbook_id int 問題集のID
     * @param $exercise_id int 登録する問題のID
     */
    public function addExercise($workbook_id, $exercise_id) {

    }

    /**
     * 問題を問題集から削除する
     * @param $exercise_id int 削除する問題のID
     */
    public function deleteExercise($exercise_id) {

    }

    /**
     * 問題の順番を変更する
     * @param $exercise_id int 変更する問題のID
     * @param $order_num int 変更後の順番
     */
    public function modifyExerciseOrder($exercise_id, $order_num) {

    }
}
