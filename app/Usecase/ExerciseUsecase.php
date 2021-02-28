<?php

namespace App\Usecase;
use App\Domain\Exercise;
use App\Domain\ExerciseOperator;
use App\Domain\SearchExerciseList;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExerciseUsecase
{
    protected $exerciseRepository;

    protected $exerciseOperator;

    public function __construct(ExerciseRepository $repository) {
        $this->exerciseRepository = $repository;
        $this->exerciseOperator = new ExerciseOperator($repository);
    }

    /**
     * リクエストからドメイン層に問い合わせてDTOを取得する
     * インスタンス作成のみでInfra層への問い合わせは行わない
     *
     * @param ExerciseRequest $exercise_request
     * @param $user_id
     * @param null $exercise_id 既存のExerciseの場合のみ指定する
     * @return ExerciseDto
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function getExerciseDtoByRequest(ExerciseRequest $exercise_request, $user_id, $exercise_id = null) {
        return Exercise::create([
            'exercise_id' => $exercise_id,
            'question' => $exercise_request->get('question'),
            'answer' => $exercise_request->get('answer'),
            'permission' => $exercise_request->get('permission'),
            'author_id' => $user_id,
            'label_list' => $exercise_request->get('label')
        ])->getExerciseDto();
    }

    /**
     * SessionからExerciseDtoを取得する
     * 作成画面で出すためにDTOに値を渡し値の確認を行わない
     * DB登録などバリデーションが必要な時に使わない
     *
     * @param Request $exercise_request
     * @param $user_id
     * @param string $post_fix
     * @param null $exercise_id
     * @return ExerciseDto
     */
    public function getExerciseDtoBySession(Request $exercise_request, $user_id, $post_fix = '', $exercise_id = null) {
        return new ExerciseDto(
            $exercise_request->session()->pull('question' . $post_fix),
            $exercise_request->session()->pull('answer' . $post_fix),
            $exercise_request->session()->pull('permission' . $post_fix),
            $user_id,
            $exercise_id,
            $exercise_request->session()->pull('label' . $post_fix)
        );
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
        return $this->exerciseOperator->getDomain($exercise_id, $user_id)->getExerciseDto();

    }

    public function getExerciseDtoByIdForEdit($exercise_id, $user_id) {
        return $this->exerciseOperator->getEditableDomain($exercise_id, $user_id)->getExerciseDto();
    }

    /**
     * リクエストからExerciseを登録する
     *
     * @param Request $exercise_request
     * @param $user_id
     * @param string $post_fix
     * @param null $exercise_id
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function registerExerciseByRequestSession(Request $exercise_request, $user_id, $post_fix = '', $exercise_id = null) {
        $this->exerciseOperator->create([
            'exercise_id' => $exercise_id,
            'question' => $exercise_request->session()->pull('question' . $post_fix, ''),
            'answer' => $exercise_request->session()->pull('answer' . $post_fix, ''),
            'permission' => $exercise_request->session()->pull('permission' . $post_fix),
            'author_id' => $user_id,
            'label' => $exercise_request>session()->pull('label' . $post_fix)
        ]);
        $this->exerciseOperator->save($user_id);

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
        //TODO user_idを渡して自分が作成したprivateの問題を見れるようにする。
        return $this->exerciseRepository->findAllByExerciseIdList($id_list);
    }

    public function searchExercise($text, $page, $user = null) {
        $searchDomain = new SearchExerciseList($this->exerciseRepository, $text, 10, $page, $user);
        return $searchDomain->getResult();
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
        $this->exerciseOperator->delete($user_id, $exercise_id);
    }
}
