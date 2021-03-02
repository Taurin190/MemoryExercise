<?php


namespace App\Domain;


use Illuminate\Support\Facades\Log;

class ExerciseQuery
{
    private $exerciseRepository;

    private $exerciseListDomain;

    private $totalCount;

    private $page;

    private $queryText;

    public function __construct(ExerciseRepository $exercise_repository)
    {
        $this->exerciseRepository = $exercise_repository;
    }

    public function search($query_text, $limit, $page, $user = null) {
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

        return [
            "count" => $this->totalCount,
            "exercise_list" => $this->exerciseListDomain->getExerciseDtoList(),
            "page" => $this->page
        ];
    }
}
