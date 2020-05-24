<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/23
 * Time: 14:57
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usecase\ExerciseUsecase;
use App\Http\Requests\ExerciseSearchRequest;

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    public function __construct(ExerciseUsecase $usecase)
    {
        $this->exerciseUsecase = $usecase;
    }

    public function search(ExerciseSearchRequest $request)
    {
        $text = $request->input('text', '');
        $page = $request->input('page');
        $result = $this->exerciseUsecase->searchExercise($text, $page);
        $exercise_list = [];
        foreach($result as $exercise) {
            $exercise_list = $exercise->toArray();
        }
        return response()->json(['apple' => 'red', 'peach' => 'pink']);
    }
}
