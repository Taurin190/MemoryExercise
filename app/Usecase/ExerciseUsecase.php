<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/21
 * Time: 6:32
 */

namespace App\Usecase;
use App\Exceptions\PermissionException;
use App\Infrastructure\ExerciseRepository;
use Exception;

class ExerciseUsecase
{
    protected $exerciseRepository;

    public function __construct(ExerciseRepository $repository) {
        $this->exerciseRepository = $repository;
    }


    public function makeExercise($question, $answer, $permission, $user_id) {
        return Exercise::create([
            'question' => $question,
            'answer' => $answer,
            'permission' => $permission,
            'author_id' => $user_id
        ]);
    }

    public function getExercise($uuid, $question, $answer, $permission, $user_id) {
        return Exercise::create([
            'exercise_id' => $uuid,
            'question' => $question,
            'answer' => $answer,
            'permission' => $permission,
            'author_id' => $user_id
        ]);
    }

    public function createExercise($question, $answer, $permission, $user_id) {
        $exercise = Exercise::create([
            'question' => $question,
            'answer' => $answer,
            'permission' => $permission,
            'author_id' => $user_id
            ]);
        $this->exerciseRepository->save($exercise);
    }

    public function updateExercise($uuid, $question, $answer, $permission, $user_id) {
        $exercise = Exercise::create([
            'exercise_id' => $uuid,
            'question' => $question,
            'answer' => $answer,
            'permission' => $permission,
            'author_id' => $user_id
        ]);
        $this->exerciseRepository->save($exercise);
    }

    public function getAllExercises($limit = 10, $user = null, $page = 1) {
        return $this->exerciseRepository->findAll($limit, $user, $page);
    }

    public function getExerciseCount($user = null) {
        return $this->exerciseRepository->count($user);
    }

    // TODO 変数名がわかりにくいので変えたい
    public function getExercises($uuid, $user = null) {
        return $this->exerciseRepository->findByExerciseId($uuid, $user);
    }

    public function getAllExercisesWithIdList($id_list) {
        return $this->exerciseRepository->findAllByExerciseIdList($id_list);
    }

    public function searchExercise($text, $page, $user = null) {
        if (mb_strlen($text) < 2) {
            $count = $this->exerciseRepository->count($user);
            $exercise_list = $this->exerciseRepository->findAll(10, $user, $page);
            return [
                "count" => $count,
                "exercise_list" => $exercise_list,
                "page" => $page
            ];
        }
        //TODO 検索した場合に権限のない問題も見れてしまうので修正する
        $count = $this->exerciseRepository->searchCount($text);
        $exercise_list = $this->exerciseRepository->search($text, $page);
        return [
            "count" => $count,
            "exercise_list" => $exercise_list,
            "page" => $page
        ];
    }

    /**
     * ユーザが編集画面にアクセスする権限があるか確認する。
     * 権限がない場合はPermissionExceptionを投げる。
     * @param $exercise_id
     * @param $user_id
     * @return bool
     * @throws PermissionException
     */
    public function checkEditPermission($exercise_id, $user_id) {
        $has_permission = $this->exerciseRepository->checkEditPermission($exercise_id, $user_id);
        if ($has_permission) {
            return true;
        }
        throw new PermissionException("User doesn't have permission to access edit page");
    }

    /**
     * 作成者である場合に問題を削除する
     * @param $exercise_id
     * @param $user_id
     * @throws Exception
     */
    public function deleteExercise($exercise_id, $user_id) {
        $has_permission = $this->exerciseRepository->checkEditPermission($exercise_id, $user_id);
        if ($has_permission) {
            $this->exerciseRepository->delete($exercise_id);
        } else{
            throw new PermissionException("User doesn't have permission to delete");
        }
    }
}
