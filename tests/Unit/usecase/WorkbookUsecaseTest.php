<?php


namespace Tests\Unit\usecase;


use App\Domain\Exercises;
use App\Domain\Workbook;
use App\Dto\WorkbookDto;
use App\Usecase\WorkbookUsecase;
use Mockery as m;
use Tests\TestCase;

class WorkbookUsecaseTest extends TestCase
{
    public function testGetWorkbook()
    {
        $workbook = Workbook::create([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook.",
        ]);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook);
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $actual = $workbook_usecase->getWorkbook('workbook-test-1');
        self::assertTrue($actual instanceof WorkbookDto);
        self::assertSame("test workbook", $actual->title);
        self::assertSame("This is an example of workbook.", $actual->explanation);
    }

    public function testGetMergedWorkbook()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook = Workbook::create([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook.",
            'user' => $user
        ]);
        $workbook_dto = new WorkbookDto(
            "Modified test workbook",
            "Modified This is an example of workbook.",
            [],
            10
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook);
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $actual = $workbook_usecase->getMergedWorkbook(
            'workbook-test-1',
            10,
            $workbook_dto
        );
        self::assertTrue($actual instanceof WorkbookDto);
        self::assertSame("Modified test workbook", $actual->title);
        self::assertSame("Modified This is an example of workbook.", $actual->explanation);
    }

    public function testGetMergedWorkbookWithExerciseList()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $exercise_orm_list = factory(\App\Exercise::class, 2)->make();
        $workbook = Workbook::create([
            'title' => "test workbook",
            'explanation' => "This is an example of workbook.",
            'user' => $user
        ]);
        $workbook_dto = new WorkbookDto(
            "Modified test workbook",
            "Modified This is an example of workbook.",
            [],
            10
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook);
        $exercise_repository->shouldReceive('findAllByExerciseIdList')
            ->with(["exercise-test-1", "exercise-test-2"])
            ->andReturn(Exercises::convertByOrmList($exercise_orm_list));
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $actual = $workbook_usecase->getMergedWorkbook(
            'workbook-test-1',
            10,
            $workbook_dto,
            ["exercise-test-1", "exercise-test-2"]
        );
        self::assertTrue($actual instanceof WorkbookDto);
        self::assertTrue(is_array($actual->exercise_list));
        self::assertSame(2, count($actual->exercise_list));
    }
}
