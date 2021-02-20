<?php

namespace App\Usecase;
use App\Domain\Exercise;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;
use Exception;

class ExerciseUsecase
{
    protected $exerciseRepository;

    public function __construct(ExerciseRepository $repository) {
        $this->exerciseRepository = $repository;
    }

    /**
     * リクエストからドメイン層に問い合わせてDTOを取得する
     * インスタンス作成のみでInfra層への問い合わせは行わない
     *
     * @param ExerciseRequest $exercise_request
     * @param $user_id
     * @param null $uuid 既存のExerciseの場合のみ指定する
     * @return ExerciseDto
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function getExerciseDtoByRequest(ExerciseRequest $exercise_request, $user_id, $uuid = null) {
        return Exercise::create([
            'exercise_id' => $uuid,
            'question' => $exercise_request->get('question'),
            'answer' => $exercise_request->get('answer'),
            'permission' => $exercise_request->get('permission'),
            'author_id' => $user_id,
            'label' => $exercise_request->get('label')
        ])->getExerciseDto();
    }

    /**
     * ExerciseのIDからInfra層に問い合わせてDTOを取得する
     *
     * @param $exercise_id
     * @param $user_id
     * @return ExerciseDto
     * @throws \App\Exceptions\DataNotFoundException exercise_idが存在しない場合に例外を投げる
     */
    public function getExerciseDtoById($exercise_id, $user_id) {
        return $this->exerciseRepository->findByExerciseId($exercise_id, $user_id)->getExerciseDto();
    }

    /**
     * リクエストからExerciseを登録する
     *
     * @param ExerciseRequest $exercise_request
     * @param $user_id
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function registerExercise(ExerciseRequest $exercise_request, $user_id) {
        $exercise = Exercise::create([
            'question' => $exercise_request->get('question'),
            'answer' => $exercise_request->get('answer'),
            'permission' => $exercise_request->get('permission'),
            'author_id' => $user_id,
            'label' => $exercise_request->get('label')
        ]);
        $this->exerciseRepository->save($exercise);
    }

    /**
     * 指定したIDのExerciseをリクエストの情報を元に更新する
     *
     * @param ExerciseRequest $exercise_request
     * @param $user_id
     * @param $exercise_id
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function updateExerciseByRequest(ExerciseRequest $exercise_request, $user_id, $exercise_id) {
        $exercise = Exercise::create([
            'exercise_id' => $exercise_id,
            'question' => $exercise_request->get('question'),
            'answer' => $exercise_request->get('answer'),
            'permission' => $exercise_request->get('permission'),
            'author_id' => $user_id,
            'label' => $exercise_request->get('label')
        ]);
        $this->exerciseRepository->save($exercise);
    }

    public function getAllExercises($limit = 10, $user = null, $page = 1) {
        return $this->exerciseRepository->findAll($limit, $user, $page);
    }

    public function getExerciseCount($user = null) {
        return $this->exerciseRepository->count($user);
    }

    /**
     * 指定されたIDの配列より対象のExerciseのドメインモデル格納した配列を取得する
     * @param $id_list
     * @return array
     */
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
