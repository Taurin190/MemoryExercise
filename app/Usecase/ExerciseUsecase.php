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

    /**
     * ExerciseRequestからExerciseドメインモデルを作成して返す
     * @param ExerciseRequest $request
     * @return Exercise
     * @throws \App\Domain\DomainException
     */
    public function getExerciseDomainFromRequest(ExerciseRequest $request) {
        return Exercise::create($request->get('question'), $request->get('answer'));
    }

    /**
     * ExerciseRequestからExerciseデータを作成する
     * @param ExerciseRequest $request
     * @throws \App\Domain\DomainException
     */
    public function createExerciseFromRequest(ExerciseRequest $request) {
        $exercise = Exercise::create($request->get('question'), $request->get('answer'));
        $this->exerciseRepository->save($exercise);
    }
}
