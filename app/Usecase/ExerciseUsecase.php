<?php

namespace App\Usecase;

use App\Domain\Exercise;
use App\Dto\ExerciseDto;
use App\Exceptions\PermissionException;
use App\Http\Requests\ExerciseFormRequest;
use App\Infrastructure\ExerciseRepository;
use Exception;
use Illuminate\Http\Request;

class ExerciseUsecase
{
    protected $exerciseRepository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->exerciseRepository = $repository;
    }

    /**
     * @param ExerciseDto $exercise_dto
     * @param $user_id
     * @throws \App\Domain\DomainException
     */
    public function validate(ExerciseDto $exercise_dto, $user_id)
    {
        Exercise::create([
            'question' => $exercise_dto->question,
            'answer' => $exercise_dto->answer,
            'permission' => $exercise_dto->permission,
            'author_id' => $user_id,
            'label_list' => $exercise_dto->label_list
        ]);
    }

    /**
     * ExerciseのIDからInfra層に問い合わせてDTOを取得する
     *
     * @param $exercise_id
     * @param $user_id
     * @return ExerciseDto
     * @throws \App\Exceptions\DataNotFoundException exercise_idが存在しない場合に例外を投げる
     */
    public function getExerciseDtoById($exercise_id, $user_id)
    {
        return $this->exerciseRepository->findByExerciseId($exercise_id, $user_id)->getExerciseDto();
    }

    public function getMergedExercise($exercise_id, $user_id, ExerciseDto $exercise_dto)
    {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if (!$exercise_domain->hasEditPermission($user_id)) {
            throw new PermissionException("User doesn't have permission to edit");
        }
        $exercise_domain->edit([
            'question' => $exercise_dto->question,
            'answer' => $exercise_dto->answer,
            'permission' => $exercise_dto->permission,
            'label_list' => $exercise_dto->label_list
        ]);
        return $exercise_domain->getExerciseDto();
    }

    public function registerExercise(ExerciseDto $exercise_dto)
    {
        $exercise_domain = Exercise::createFromDto($exercise_dto);
        $this->exerciseRepository->save($exercise_domain);
    }

    /**
     * @param $exercise_id
     * @param $user_id
     * @param ExerciseDto $exercise_dto
     * @throws PermissionException
     * @throws \App\Exceptions\DataNotFoundException
     */
    public function editExercise($exercise_id, $user_id, ExerciseDto $exercise_dto)
    {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if (!$exercise_domain->hasEditPermission($user_id)) {
            throw new PermissionException("User doesn't have permission to edit");
        }
        $exercise_domain->edit([
            'question' => $exercise_dto->question,
            'answer' => $exercise_dto->answer,
            'permission' => $exercise_dto->permission,
            'label_list' => $exercise_dto->label_list
        ]);
        $this->exerciseRepository->save($exercise_domain);
    }

    public function getAllExercises($limit = 10, $user = null, $page = 1)
    {
        return $this->exerciseRepository->findAll($limit, $user, $page);
    }

    public function getExerciseCount($user = null)
    {
        return $this->exerciseRepository->count($user);
    }

    /**
     * 指定されたIDの配列より対象のExerciseのドメインモデル格納した配列を取得する
     * @param $id_list
     * @return \App\Domain\ExerciseList
     */
    public function getAllExercisesWithIdList($id_list)
    {
        //TODO user_idを渡して自分が作成したprivateの問題を見れるようにする。
        return $this->exerciseRepository->findAllByExerciseIdList($id_list);
    }

    public function getExerciseDtoListByIdListOfRequest(Request $request)
    {
        $exercise_dto_list = [];
        $exercise_id_list = $request->get('exercise');
        if (is_null($exercise_id_list)) {
            return $exercise_dto_list;
        }
        $exercise_list_domain = $this->exerciseRepository->findAllByExerciseIdList($exercise_id_list);

        return $exercise_list_domain->getExerciseDtoList();
    }

    public function searchExercise($text, $page, $user = null)
    {
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
    public function checkEditPermission($exercise_id, $user_id)
    {
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
    public function deleteExercise($exercise_id, $user_id)
    {
        $exercise_domain = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        if ($exercise_domain->hasEditPermission($user_id)) {
            $this->exerciseRepository->delete($exercise_id);
        }
        throw new PermissionException("User doesn't have permission to delete");
    }
}
