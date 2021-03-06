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

    public function getWorkbook($workbook_id): WorkbookDto
    {
        $workbook_domain = $this->workbookRepository->findByWorkbookId($workbook_id);
        return $workbook_domain->getWorkbookDto();
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

    public function getWorkbookDtoList()
    {
        $workbooks_domain = $this->workbookRepository->findWorkbooks();
        return $workbooks_domain->getWorkbookDtoList();
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

}
