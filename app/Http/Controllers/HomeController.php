<?php

namespace App\Http\Controllers;

use App\Usecase\StudyHistoryUsecase;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $answerHistoryUsecase;

    protected $studyHistoryUsecase;

    /**
     * Create a new controller instance.
     *
     * @param StudyHistoryUsecase $studyHistoryUsecase
     */
    public function __construct(
        StudyHistoryUsecase $studyHistoryUsecase
    )
    {
        $this->studyHistoryUsecase = $studyHistoryUsecase;
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
            $study_summary_dto = $this->studyHistoryUsecase->getStudySummary(Auth::id());
            return view('home')
                ->with('user', $user)
                ->with('study_summary', $study_summary_dto)
                ->with('graph_data', $study_summary_dto->graphData);
        } else {
            return view('index');
        }
    }
}
