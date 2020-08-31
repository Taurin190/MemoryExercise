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
            $study_history_dto = $this->answerHistoryUsecase->getStudyHistoryOfUser($user->getKey(), null, null);
            return view('home')
                ->with('user', $user)
                ->with('exercise_history_count', $study_history_dto->getGraphData())
                ->with('monthly_count', $study_history_dto->getMonthlyCount())
                ->with('total_count', $study_history_dto->getTotalCount())
                ->with('total_days', $study_history_dto->getTotalDays());
        } else {
            return view('index');
        }
    }
}
