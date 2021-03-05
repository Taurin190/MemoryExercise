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
use App\Dto\WorkbookDto;
use App\Exceptions\PermissionException;
use App\Http\Requests\WorkbookRequest;
use Illuminate\Http\Request;

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
     * @param $description string
     * @param $exercise_list Array 問題モデルの配列
     * @param null $user
     * @return int 問題集のID
     * @throws \App\Domain\WorkbookDomainException
     */
    public function createWorkbook($name, $description, $exercise_list = null, $user = null) {
        $workbook = Workbook::create([
            'title' => $name,
            'explanation' => $description,
            'exercise_list' => $exercise_list,
            'user' =>$user
        ]);
        return $this->workbookRepository->save($workbook);
    }

    /**
     * 問題集を作成する
     * @param $name string 問題集名
     * @param $description string 問題集の説明
     * @param null $exercise_list
     * @param null $workbook_id
     * @param null $user
     * @return Workbook 問題集のドメインモデル
     * @throws \App\Domain\WorkbookDomainException
     */
    public function makeWorkbook($name, $description, $exercise_list = null, $workbook_id = null, $user = null) {
        return $workbook = Workbook::create([
            'title' => $name,
            'explanation' => $description,
            'exercise_list' => $exercise_list,
            'workbook_id' => $workbook_id,
            'user' =>$user
        ]);
    }

    /**
     * リクエストよりWorkbookのDTOを取得する
     * infra層への問い合わせを行わない
     * @param WorkbookRequest $request
     * @param $user_id
     * @param null $workbook_id
     * @return \App\Dto\WorkbookDto
     * @throws \App\Domain\WorkbookDomainException
     */
    public function getWorkbookDtoByRequest(WorkbookRequest $request, $user_id, $workbook_id = null) {
        $exercise_id_list = $request->get('exercise');
        $exercise_list = $this->exerciseRepository->findAllByExerciseIdList($exercise_id_list);
        return $workbook = Workbook::create([
            "title" => $request->get('title'),
            "explanation" => $request->get('explanation'),
            "exercise_list" => $exercise_list,
            "author_id" => $user_id,
            'workbook_id' => $workbook_id
        ])->getWorkbookDto();
    }

    public function getWorkbookDtoByRequestSession(Request $request, $postfix = '') {
        return new WorkbookDto(
            $request->session()->pull('title' . $postfix, ''),
            $request->session()->pull('explanation' . $postfix, ''),
            $request->session()->pull('exercise_list' . $postfix, ''),
            $request->session()->pull('author_id' . $postfix, ''),
            $request->session()->pull('workbook_id' . $postfix, '')
        );
    }

    /**
     * 問題集を編集する
     * @param $wordbook_id int 問題集のID
     * @param $title string 問題集の名前
     * @param $description string 問題集の説明
     * @param null $exercise_list
     */
    public function modifyWorkbook($wordbook_id, $title, $description, $exercise_list = null) {
        $workbook = $this->workbookRepository->findByWorkbookId($wordbook_id);
        $workbook->modifyTitle($title);
        $workbook->modifyExplanation($description);
        if (isset($exercise_list)) {
            $workbook->setExerciseDomainList($exercise_list);
        }
        $this->workbookRepository->update($workbook);
    }

    /**
     * 問題集を削除する
     * @param $wordbook_id String 削除する問題集のID
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
     * @param $workbook_id String 問題集のID
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
     * @param $workbook_id String 変更する問題のID
     * @param $order_num int 変更後の順番
     */
    public function modifyExerciseOrder($workbook_id, $exercise_id, $order_num) {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->modifyOrder($exercise, $order_num);
        $this->workbookRepository->save($newWorkbook);
    }

    public function checkEditPermission($workbook_id, $user_id) {
        $has_permission = $this->workbookRepository->checkEditPermission($workbook_id, $user_id);
        if ($has_permission) return;
        throw new PermissionException("User doesn't have permission to edit workbook.");
    }
}
