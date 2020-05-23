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

class ExerciseController extends Controller
{
    protected $exerciseUsecase;

    public function __construct(ExerciseUsecase $usecase)
    {
        $this->exerciseUsecase = $usecase;
    }

    public function search(Request $request)
    {

    }
}
