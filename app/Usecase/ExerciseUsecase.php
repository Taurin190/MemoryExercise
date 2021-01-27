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


    public function makeExercise($question, $answer, $permission) {
        return Exercise::create(['question' => $question, 'answer' => $answer, 'permission' => $permission]);
    }

    public function getExercise($uuid, $question, $answer, $permission) {
        return Exercise::create(['exercise_id' => $uuid,'question' => $question, 'answer' => $answer, 'permission' => $permission]);
    }

    public function createExercise($question, $answer, $permission) {
        $exercise = Exercise::create(['question' => $question, 'answer' => $answer, 'permission' => $permission]);
        $this->exerciseRepository->save($exercise);
    }

    public function updateExercise($uuid, $question, $answer, $permission) {
        $exercise = Exercise::create(['exercise_id' => $uuid, 'question' => $question, 'answer' => $answer, 'permission' => $permission]);
        $this->exerciseRepository->save($exercise);
    }

    public function getAllExercises($limit) {
        return $this->exerciseRepository->findAll();
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
        $count = $this->exerciseRepository->searchCount($text);
        $exercise_list = $this->exerciseRepository->search($text, $page);
        return [
            "count" => $count,
            "exercise_list" => $exercise_list,
            "page" => $page
        ];
    }
}
