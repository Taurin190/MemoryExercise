<?php

namespace App\Usecase;
use App\Domain\Exercise;
use App\Domain\SearchExerciseList;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;
use Exception;
use Illuminate\Http\Request;

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
     * @return ExerciseDto
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function getExerciseDtoByRequest(ExerciseRequest $exercise_request, $user_id) {
        return Exercise::create([
            'question' => $exercise_request->get('question'),
            'answer' => $exercise_request->get('answer'),
            'permission' => $exercise_request->get('permission'),
            'author_id' => $user_id,
            'label_list' => $exercise_request->get('label')
        ])->getExerciseDto();
    }

    /**
     * @param $exercise_id
     * @param ExerciseRequest $exercise_request
     * @param $user_id
     * @return ExerciseDto
     * @throws PermissionException
     * @throws \App\Domain\DomainException
     * @throws \App\Exceptions\DataNotFoundException
     */
    public function getEditedExerciseDtoByRequest($exercise_id, ExerciseRequest $exercise_request, $user_id) {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if ($exercise_domain->hasEditPermission($user_id)) {
            $exercise_domain->edit([
                'question' => $exercise_request->get('question'),
                'answer' => $exercise_request->get('answer'),
                'permission' => $exercise_request->get('permission'),
                'label_list' => $exercise_request->get('label')
            ]);
            return $exercise_domain->getExerciseDto();
        }
        throw new PermissionException("User doesn't have permission to edit");
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
        return $this->exerciseRepository->findByExerciseId($exercise_id, $user_id)->getExerciseDto();
    }

    /**
     * @param $exercise_id
     * @param $user_id
     * @param $request
     * @param string $post_fix
     * @return ExerciseDto
     * @throws PermissionException
     * @throws \App\Exceptions\DataNotFoundException
     */
    public function getExerciseDtoByIdWithSessionModification($exercise_id, $user_id, Request $request, $post_fix = '') {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if (!$exercise_domain->hasEditPermission($user_id)) {
            throw new PermissionException("User doesn't have permission to edit");
        }
        $exercise_domain->edit([
            'question' => $request->session()->pull('question' . $post_fix, ''),
            'answer' => $request->session()->pull('answer' . $post_fix, ''),
            'permission' => $request->session()->pull('permission' . $post_fix, ''),
            'label_list' => $request->session()->pull('label' . $post_fix, '')
        ]);
        return $exercise_domain->getExerciseDto();

    }

    /**
     * リクエストからExerciseを登録する
     *
     * @param Request $exercise_request
     * @param $user_id
     * @param string $post_fix
     * @throws \App\Domain\DomainException リクエストの情報が不適当な場合に例外を投げる
     */
    public function registerExerciseByRequestSession(Request $exercise_request, $user_id, $post_fix = '') {
        $exercise_domain = Exercise::create([
            'question' => $exercise_request->session()->pull('question' . $post_fix, ''),
            'answer' => $exercise_request->session()->pull('answer' . $post_fix, ''),
            'permission' => $exercise_request->session()->pull('permission' . $post_fix),
            'author_id' => $user_id,
            'label_list' => $exercise_request>session()->pull('label' . $post_fix)
        ]);
        $this->exerciseRepository->save($exercise_domain);
    }

    /**
     * @param $exercise_id
     * @param Request $exercise_request
     * @param $user_id
     * @param string $post_fix
     * @throws \App\Domain\DomainException
     * @throws \App\Exceptions\DataNotFoundException
     * @throws PermissionException
     */
    public function editExerciseByRequestSession($exercise_id, Request $exercise_request, $user_id, $post_fix = '') {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if ($exercise_domain->hasEditPermission($user_id)) {
            $exercise_domain->edit([
                'question' => $exercise_request->session()->pull('question' . $post_fix, ''),
                'answer' => $exercise_request->session()->pull('answer' . $post_fix, ''),
                'permission' => $exercise_request->session()->pull('permission' . $post_fix, ''),
                'label_list' => $exercise_request->session()->pull('label' . $post_fix, '')
            ]);
            $this->exerciseRepository->save($exercise_domain);
        }
        throw new PermissionException("User doesn't have permission to edit");
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
        $search_domain = $this->exerciseRepository->search($text, $user, $page, 10);
        return $search_domain->getExerciseListDto();
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
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if ($exercise_domain->hasEditPermission($user_id)) {
            $this->exerciseRepository->delete($exercise_id);
        }
        throw new PermissionException("User doesn't have permission to delete");
    }
}
