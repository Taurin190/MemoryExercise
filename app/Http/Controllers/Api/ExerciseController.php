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
use App\User;

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    public function __construct(ExerciseUsecase $usecase)
    {
        $this->exerciseUsecase = $usecase;
    }

    public function search(ExerciseSearchRequest $request)
    {
        $token = $request->get('api_token');
        $user = null;
        if (isset($token)) {
            $user = User::where('api_token', $token)->first();
        }
        $text = $request->input('text', '');
        $page = $request->input('page', 1);
        $search_exercise_list_dto = $this->exerciseUsecase->searchExercise($text, $page, $user);
        $exercise_list = [];
        if (isset($search_exercise_list_dto->exercise_dto_list)) {
            foreach ($search_exercise_list_dto->exercise_dto_list as $exercise) {
                $exercise_list[] = $exercise->toArray();
            }
        }
        $response = [
            'exercise_list' => $exercise_list,
            'count' => $search_exercise_list_dto->total_count,
            'page' => $search_exercise_list_dto->page
        ];
        return response()->json($response);
    }

    public function list(Request $request)
    {
        $token = $request->get('api_token');
        $user = null;
        if (isset($token)) {
            $user = User::where('api_token', $token)->first();
        }
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $result = $this->exerciseUsecase->getAllExercises($limit, $user, $page);
        $count = $this->exerciseUsecase->getExerciseCount($user);
        $exercise_list = [];
        if (isset($result)) {
            foreach ($result as $exercise) {
                $exercise_list[] = $exercise->toArray();
            }
        }
        $response = [
            'exercise_list' => $exercise_list,
            'count' => $count,
            'page' => $page
        ];
        return response()->json($response);
    }
}
