<?php


namespace App\Domain;


use Illuminate\Support\Facades\Log;

class SearchExerciseList
{
    private $exerciseRepository;

    private $exerciseListDomain;

    private $totalCount;

    private $page;

    private $queryText;

    public function __construct(ExerciseRepository $exercise_repository, $query_text, $limit, $page, $user = null)
    {
        $this->exerciseRepository = $exercise_repository;

        if (mb_strlen($query_text) < 2) {
            $this->totalCount = $this->exerciseRepository->count($user);
            $exercise_list = $this->exerciseRepository->findAll($limit, $user, $page);
            Log::error(mb_strlen($exercise_list));
            $this->exerciseListDomain = new ExerciseList($exercise_list);
            return;
        }
        //TODO 検索した場合に権限のない問題も見れてしまうので修正する
        $exercise_list = $this->exerciseRepository->search($query_text, $page);

        $this->queryText = $query_text;
        $this->page = $page;
        $this->totalCount = $this->exerciseRepository->searchCount($query_text);
        $this->exerciseListDomain = new ExerciseList($exercise_list);
    }

    public function getResult() {
        return [
            "count" => $this->totalCount,
            "exercise_list" => $this->exerciseListDomain->getExerciseDtoList(),
            "page" => $this->page
        ];
    }

    public static function searchExercise(ExerciseRepository $exercise_repository, $query_text, $limit = 10, $page = 1, $user = null) {
        return new SearchExerciseList($exercise_repository, $query_text, $limit, $page, $user);

        //TODO 検索した場合に権限のない問題も見れてしまうので修正する
        $count = $exercise_repository->searchCount($query_text);
        $exercise_list = $exercise_repository->search($query_text, $page);
        return [
            "count" => $count,
            "exercise_list" => $exercise_list,
            "page" => $page
        ];
    }
}
