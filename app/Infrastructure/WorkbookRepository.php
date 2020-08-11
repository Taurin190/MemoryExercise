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
        return Workbook::map($model->first());
    }

    function findAll()
    {
        $domain_list = [];
        $all_model = \App\Workbook::all();
        foreach ($all_model as $model) {
            $domain_list[] = Workbook::map($model);
        }
        return $domain_list;
    }

    function save(Workbook $workbook)
    {
        if ($workbook->getExerciseList() != null && count($workbook->getExerciseList()) > 0) {
            DB::beginTransaction();
            try {
                $workbook_model = \App\Workbook::map($workbook);
                $workbook_model->save();
                $uuid = $workbook_model->getKey();
                foreach ($workbook->getExerciseList() as $exercise) {
                    $workbook_model->exercises()->attach(
                        ['workbook_id' => $uuid],
                        ['exercise_id' => $exercise->getExerciseId()]
                    );
                }
                DB::commit();
            } catch (\Exception $e) {
                Log::error("DB Exception: " . $e);
            }
        } else {
            \App\Workbook::map($workbook)->save();
        }
    }

    function update(Workbook $workbook)
    {
        DB::beginTransaction();
        try {
            $workbook_model = \App\Workbook::map($workbook);
            $workbook_model->save();
            $uuid = $workbook_model->getKey();
            $workbook_model->exercises()->detach();
            if ($workbook->getExerciseList() != null && count($workbook->getExerciseList()) > 0) {
                foreach ($workbook->getExerciseList() as $exercise) {
                    $workbook_model->exercises()->attach(
                        ['workbook_id' => $uuid],
                        ['exercise_id' => $exercise->getExerciseId()]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error("DB Exception: " . $e);
        }
    }

    function delete(int $workbook_id)
    {
        \App\Workbook::find($workbook_id)->delete();
    }
}
