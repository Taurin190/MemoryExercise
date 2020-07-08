<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/21
 * Time: 6:32
 */

namespace App\Usecase;
use App\Domain\Exercise;
use App\Http\Requests\ExerciseRequest;
use App\Infrastructure\ExerciseRepository;

class ExerciseUsecase
{
    protected $exerciseRepository;

    public function __construct(ExerciseRepository $repository) {
        $this->exerciseRepository = $repository;
    }


    public function makeExercise($question, $answer) {
        return Exercise::create($question, $answer);
    }

    public function createExercise($question, $answer) {
        $exercise = Exercise::create($question, $answer);
        $this->exerciseRepository->save($exercise);
    }

    public function getAllExercises($limit) {
        return $this->exerciseRepository->findAll();
    }

    public function getAllExercisesWithIdList($id_list) {
        return $this->exerciseRepository->findAllByExerciseIdList($id_list);
    }

    public function searchExercise($text, $page) {
        if (mb_strlen($text) < 2) {
            return $this->exerciseRepository->findAll();
        }
        return $this->exerciseRepository->search($text, $page);
    }
}
