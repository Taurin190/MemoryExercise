<?php

namespace App\Usecase;

use App\Domain\ExerciseRepository;
use App\Domain\Exercises;
use App\Domain\Workbook;
use App\Domain\WorkbookRepository;
use App\Dto\WorkbookDto;
use App\Exceptions\PermissionException;

class WorkbookUsecase
{
    private $workbookRepository;

    private $exerciseRepository;

    public function __construct(WorkbookRepository $workbookRepository, ExerciseRepository $exerciseRepository)
    {
        $this->workbookRepository = $workbookRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * 指定した問題集を取得する
     * @param $workbook_id string 問題集のID
     * @return Workbook 取得した問題集
     */
    public function getWorkbook($workbook_id)
    {
        return $this->workbookRepository->findByWorkbookId($workbook_id);
    }

    public function getMergedWorkbook($workbook_id, $user_id, WorkbookDto $workbook_dto, array $exercise_id_list = null)
    {
        $workbook_domain = $this->workbookRepository->findByWorkbookId($workbook_id);
        if (!$workbook_domain->hasEditPermission($user_id)) {
            throw new PermissionException("User doesn't have permission to edit");
        }
        $exercises_domain = null;
        if (isset($exercise_id_list)) {
            $exercises_domain = $this->exerciseRepository->findAllByExerciseIdList($exercise_id_list);
        }
        $workbook_domain->edit([
            'title' => $workbook_dto->title,
            'explanation' => $workbook_dto->explanation,
            'exercise_list' => $exercises_domain
        ]);

        return $workbook_domain->getWorkbookDto();
    }

    public function getWorkbookWithExerciseIdList(
        WorkbookDto $workbook_dto,
        array $exercise_id_list,
        $user,
        $workbook_id = null
    )
    {
        $exercise_list_domain = $this->exerciseRepository->findAllByExerciseIdList($exercise_id_list, $user->getKey());
        return Workbook::create([
            'title' => $workbook_dto->title,
            'explanation' => $workbook_dto->explanation,
            'exercise_list' => $exercise_list_domain,
            'user' => $user,
            'workbook_id' => $workbook_id
        ])->getWorkbookDto();
    }

    /**
     * 問題集を全て取得する
     */
    public function getAllWorkbook()
    {
        return $this->workbookRepository->findAll();
    }

    public function registerWorkbook(WorkbookDto $workbook_dto, $user)
    {
        $workbook_domain = Workbook::create([
            'title' => $workbook_dto->title,
            'explanation' => $workbook_dto->explanation,
            'exercise_list' => Exercises::convertByDtoList($workbook_dto->exercise_list),
            'user' => $user
        ]);
        return $this->workbookRepository->save($workbook_domain);
    }

    public function editWorkbook($workbook_id, WorkbookDto $workbook_dto, $user)
    {
        $workbook_domain = $this->workbookRepository->findByWorkbookId($workbook_id);
        if (!$workbook_domain->hasEditPermission($user->getKey())) {
            throw new PermissionException("User doesn't have permission to edit");
        }
        $workbook_domain->edit([
            'title' => $workbook_dto->title,
            'explanation' => $workbook_dto->explanation,
            'exercise_list' => Exercises::convertByDtoList($workbook_dto->exercise_list)
        ]);
        return $this->workbookRepository->update($workbook_domain);
    }

    /**
     * 問題集を削除する
     * @param $wordbook_id String 削除する問題集のID
     * @param $user_id
     * @throws PermissionException
     */
    public function deleteWorkbook($wordbook_id, $user_id)
    {
        $workbook_domain = $this->workbookRepository->findByWorkbookId($wordbook_id);
        if (!$workbook_domain->hasEditPermission($user_id)) {
            throw new PermissionException("User doesn't have permission to delete");
        }
        $this->workbookRepository->delete($wordbook_id);
    }

    /**
     * 問題を問題集に登録する
     * @param $workbook_id int 問題集のID
     * @param $exercise_id int 登録する問題のID
     */
    public function addExercise($workbook_id, $exercise_id)
    {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->addExercise($exercise);
        $this->workbookRepository->update($newWorkbook);
    }

    /**
     * 問題を問題集から削除する
     * @param $workbook_id String 問題集のID
     * @param $exercise_id int 削除する問題のID
     */
    public function deleteExercise($workbook_id, $exercise_id)
    {
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
    public function modifyExerciseOrder($workbook_id, $exercise_id, $order_num)
    {
        $workbook = $this->workbookRepository->findByWorkbookId($workbook_id);
        $exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        $newWorkbook = $workbook->modifyOrder($exercise, $order_num);
        $this->workbookRepository->save($newWorkbook);
    }
}
