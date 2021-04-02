<?php
namespace App\Infrastructure;

use App\Domain\Workbook;
use App\Domain\Workbooks;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkbookRepository implements \App\Domain\WorkbookRepository
{
    public function findByWorkbookId($workbook_id)
    {
        $workbook_orm = \App\Workbook::where('workbook_id', $workbook_id);
        if (is_null($workbook_orm->first())) {
            throw new DataNotFoundException("Data Not Fount: Invalid Workbook Id.");
        }
        return Workbook::convertDomain($workbook_orm->first());
    }

    public function findWorkbooks(): Workbooks
    {
        $workbook_list_orm = \App\Workbook::all();
        return Workbooks::convertByOrmList($workbook_list_orm);
    }

    public function save(Workbook $workbook_domain)
    {
        $workbook_id = '';
        if ($workbook_domain->getCountOfExercise() > 0) {
            DB::beginTransaction();
            try {
                $workbook_orm = \App\Workbook::convertOrm($workbook_domain);
                $workbook_orm->save();
                $workbook_id = $workbook_orm->getKey();
                $relations = $workbook_domain->getWorkbookExerciseRelationList($workbook_id);
                $workbook_orm->exercises()->attach($relations);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("DB Exception: " . $e);
            }
        } else {
            $workbook_orm = \App\Workbook::convertOrm($workbook_domain);
            $workbook_orm->save();
            $workbook_id = $workbook_orm->getKey();
        }
        return $workbook_id;
    }

    public function update(Workbook $workbook_domain)
    {
        DB::beginTransaction();
        try {
            $workbook_orm = \App\Workbook::convertOrm($workbook_domain);
            $workbook_orm->save();
            $uuid = $workbook_orm->getKey();
            $workbook_orm->exercises()->detach();
            // 紐付いたExerciseを多対多で登録する
            if ($workbook_domain->getCountOfExercise() > 0) {
                $workbook_orm->exercises()->attach(
                    $workbook_domain->getWorkbookExerciseRelationList($uuid)
                );
            } else {
                // 一つも登録されていない場合にRelationを削除する
                $workbook_orm->exercises()->detach();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("DB Exception: " . $e);
        }
    }

    public function delete($workbook_id)
    {
        \App\Workbook::where('workbook_id', $workbook_id)->delete();
    }

}
