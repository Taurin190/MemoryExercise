<?php


namespace App\Domain;


use App\Exceptions\PermissionException;

class ExerciseOperator
{
    private $exercise;

    private $exerciseRepository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->exerciseRepository = $repository;
    }

    public function create($parameter) {
        $this->exercise = Exercise::create($parameter);
    }

    public function save($user_id) {
        if (is_null($this->exercise)) throw new DomainException("Exercise Domain isn't set properly");
        if ($this->isRegisteredExercise()) {
            $this->checkEditPermission($user_id);
        }
        $this->exerciseRepository->save($this->exercise);
    }

    public function delete($user_id, $exercise_id = null) {
        if (is_null($this->exercise) && is_null($exercise_id)) throw new DomainException("Exercise Domain isn't set properly");
        if (is_null($this->exercise)) {
            $this->exercise = $this->exerciseRepository->findByExerciseId($exercise_id);
        }
        if ($this->isRegisteredExercise()) {
            $this->checkEditPermission($user_id);
            $this->exerciseRepository->delete($this->exercise->getExerciseId());
        }
    }

    public function getDomain($exercise_id, $user_id) {
        $this->exercise = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        return $this->exercise;
    }

    public function getEditableDomain($exercise_id, $user_id) {
        $this->exercise = $this->exerciseRepository->findByExerciseId($exercise_id, $user_id);
        $this->checkEditPermission($user_id);
        return $this->exercise;
    }

    private function isRegisteredExercise() {
        $exercise_id = $this->exercise->getExerciseId();
        return isset($exercise_id);
    }

    private function checkEditPermission($user_id) {
        if (is_null($this->exercise)) throw new DomainException("Exercise Domain isn't set properly");
        if ($this->exercise->getAuthorId() != $user_id) {
            throw new PermissionException("User doesn't have permission to edit");
        }
    }
}
