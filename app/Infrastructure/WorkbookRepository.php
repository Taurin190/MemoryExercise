<?php
namespace App\Infrastructure;
use App\Domain\Workbook;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkbookRepository implements \App\Domain\WorkbookRepository
{
    function findByWorkbookId($workbook_id)
    {
        $model = \App\Workbook::where('workbook_id', $workbook_id);
        if (is_null($model->first())) {
            throw new DataNotFoundException("Data Not Fount: Invalid Workbook Id.");
        }
        return Workbook::convertDomain($model->first());
    }

    function findAll()
    {
        $domain_list = [];
        $all_model = \App\Workbook::all();
        foreach ($all_model as $model) {
            $domain_list[] = Workbook::convertDomain($model);
        }
        return $domain_list;
    }

    function save(Workbook $workbook)
    {
        if ($workbook->getCountOfExercise() > 0) {
            DB::beginTransaction();
            try {
                $workbook_model = \App\Workbook::convertOrm($workbook);
                $workbook_model->save();
                $uuid = $workbook_model->getKey();
                $workbook_model->exercises()->attach(
                    $workbook->getWorkbookExerciseRelationList($uuid)
                );
                DB::commit();
            } catch (\Exception $e) {
                Log::error("DB Exception: " . $e);
            }
        } else {
            \App\Workbook::convertOrm($workbook)->save();
        }
    }

    function update(Workbook $workbook)
    {
        DB::beginTransaction();
        try {
            $workbook_model = \App\Workbook::convertOrm($workbook);
            $workbook_model->save();
            $uuid = $workbook_model->getKey();
            $workbook_model->exercises()->detach();
            // 紐付いたExerciseを多対多で登録する
            if ($workbook->getCountOfExercise() > 0) {
                $workbook_model->exercises()->attach(
                    $workbook->getWorkbookExerciseRelationList($uuid)
                );
            } else {
                // 一つも登録されていない場合にRelationを削除する
                $workbook_model->exercises()->detach();
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error("DB Exception: " . $e);
        }
    }

    function delete($workbook_id)
    {
        \App\Workbook::where('workbook_id', $workbook_id)->delete();
    }

    function checkEditPermission($workbook_id, $user_id) {
        $target_workbook = \App\Workbook::select(['author_id'])->where('workbook_id', $workbook_id)->first();
        if ($target_workbook->author_id == $user_id) return true;
        return false;
    }
}
