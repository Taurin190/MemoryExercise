<?php

namespace App\Http\Controllers;

use App\Usecase\AnswerHistoryUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $answerHistoryUsecase;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AnswerHistoryUsecase $answerHistoryUsecase)
    {
        $this->answerHistoryUsecase = $answerHistoryUsecase;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $exercise_count_dto = $this->answerHistoryUsecase->getExerciseHistoryCountWithUserId($user->getKey(), null, null);
            return view('home')
                ->with('exercise_history_count', $exercise_count_dto->getGraphData())
                ->with('monthly_count', $exercise_count_dto->getMonthlyCount())
                ->with('total_count', $exercise_count_dto->getTotalCount())
                ->with('total_days', $exercise_count_dto->getTotalDays());
        } else {
            return view('index');
        }
    }
}
