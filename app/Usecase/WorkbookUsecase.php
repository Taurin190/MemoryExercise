<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/04/24
 * Time: 18:13
 */

namespace App\Usecase;


use App\Domain\ExerciseRepository;
use App\Domain\WorkbookRepository;
use App\Domain\Workbook;
use App\Http\Requests\WorkbookRequest;

class WorkbookUsecase
{
    private $workbookRepository;

    private $exerciseRepository;

    public function __construct(WorkbookRepository $workbookRepository, ExerciseRepository $exerciseRepository) {
        $this->workbookRepository = $workbookRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * 指定した問題集を取得する
     * @param $workbook_id string 問題集のID
     * @return Workbook 取得した問題集
     */
    public function getWorkbook($workbook_id) {
        return $this->workbookRepository->findByWorkbookId($workbook_id);
    }

    /**
     * 問題集を全て取得する
     */
    public function getAllWorkbook() {
        return $this->workbookRepository->findAll();
    }

    /**
     * 問題集を作成する
     * @param $name string 問題集名
     * @param $description string 問題集の説明
     * @return int 問題集のID
     * @throws \App\Domain\WorkbookDomainException
     */
    public function createWorkbook($name, $description) {
        $workbook = Workbook::create($name, $description);
        return $this->workbookRepository->save($workbook);
    }

    /**
     * 問題集を編集する
     * @param $wordbook_id int 問題集のID
     * @param $title string 問題集の名前
     * @param $description string 問題集の説明
     */
    public function modifyWorkbook($wordbook_id, $title, $description) {
        $workbook = $this->workbookRepository->findByWorkbookId($wordbook_id);
        $workbook->modifyTitle($title);
        $workbook->modifyDescription($description);
        $this->workbookRepository->save($workbook);
    }

    /**
     * 問題集を削除する
     * @param $wordbook_id int 削除する問題集のID
     */
    public function deleteWorkbook($wordbook_id) {
        $this->workbookRepository->delete($wordbook_id);
    }

    /**
     * 問題を問題集に登録する
     * @param $workbook_id int 問題集のID
     * @param $exercise_id int 登録する問題のID
     */
    public function addExercise($workbook_id, $exercise_id) {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->addExercise($exercise);
        $this->workbookRepository->save($newWorkbook);
    }

    /**
     * 問題を問題集から削除する
     * @param $workbook_id int 問題集のID
     * @param $exercise_id int 削除する問題のID
     */
    public function deleteExercise($workbook_id, $exercise_id) {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->deleteExercise($exercise);
        $this->workbookRepository->save($newWorkbook);
    }

    /**
     * 問題の順番を変更する
     * @param $exercise_id int 変更する問題のID
     * @param $order_num int 変更後の順番
     */
    public function modifyExerciseOrder($workbook_id, $exercise_id, $order_num) {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->modifyOrder($exercise, $order_num);
        $this->workbookRepository->save($newWorkbook);
    }

    /**
     * WorkbookRequestからWorkbookドメインモデルを作成して返す
     * @param WorkbookRequest $request
     * @return Workbook ドメインモデル
     * @throws \App\Domain\WorkbookDomainException
     */
    public function getWorkbookDomainFromRequest(WorkbookRequest $request) {
        return Workbook::create($request->get('title'), $request->get('explanation', ''));
    }

    /**
     * RequestからWorkbookのデータを作成する
     * @param WorkbookRequest $request
     * @throws \App\Domain\WorkbookDomainException
     */
    public function createWorkbookFromRequest(WorkbookRequest $request) {
        $workbook = Workbook::create($request->get('title'), $request->get('explanation', ''));
        $this->workbookRepository->save($workbook);
    }
}
