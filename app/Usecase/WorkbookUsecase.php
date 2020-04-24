<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/04/24
 * Time: 18:13
 */

namespace App\Usecase;


class WorkbookUsecase
{
    /**
     * 問題集を作成します
     */
    public function createWorkbook() {

    }

    /**
     * 問題を問題集に登録します
     * @param $exercise_id int 登録する問題のID
     */
    public function addExercise($exercise_id) {

    }

    /**
     * 問題を問題集から削除します
     * @param $exercise_id int 削除する問題のID
     */
    public function deleteExercise($exercise_id) {

    }

    /**
     * 問題の順番を変更します
     * @param $exercise_id int 変更する問題のID
     * @param $order_num int 変更後の順番
     */
    public function modifyExerciseOrder($exercise_id, $order_num) {

    }
}
