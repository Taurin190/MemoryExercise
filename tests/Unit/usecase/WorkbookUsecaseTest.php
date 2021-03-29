<?php


namespace Tests\Unit\usecase;


use App\Domain\Exercises;
use App\Domain\Workbook;
use App\Domain\Workbooks;
use App\Dto\WorkbookDto;
use App\Exceptions\PermissionException;
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

    public function testGetMergedWorkbookWithoutPermission()
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
        try {
            $workbook_usecase->getMergedWorkbook(
                'workbook-test-1',
                15,
                $workbook_dto
            );
        } catch (PermissionException $e) {
            self::assertSame("User doesn't have permission to edit", $e->getMessage());
        }
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

    public function testGetWorkbookWithExerciseIdList()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $exercise_orm_list = factory(\App\Exercise::class, 2)->make();
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $exercise_repository->shouldReceive('findAllByExerciseIdList')
            ->with(["exercise-test-1", "exercise-test-2"], 10)
            ->andReturn(Exercises::convertByOrmList($exercise_orm_list));
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $actual = $workbook_usecase->getWorkbookWithExerciseIdList(
            $workbook_dto,
            ["exercise-test-1", "exercise-test-2"],
            $user
        );
        self::assertTrue($actual instanceof WorkbookDto);
        self::assertTrue(is_array($actual->exercise_list));
        self::assertSame(2, count($actual->exercise_list));
    }

    public function testGetWorkbookDtoList()
    {
        $workbook_orm_list = factory(\App\Workbook::class, 10)->make();
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findWorkbooks')
            ->andReturn(Workbooks::convertByOrmList($workbook_orm_list));
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $actual = $workbook_usecase->getWorkbookDtoList();
        self::assertTrue(is_array($actual));
        self::assertSame(10, count($actual));
        self::assertTrue($actual[0] instanceof WorkbookDto);
    }

    public function testRegisterWorkbook()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10
        );
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('save')
            ->andReturn();
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $workbook_usecase->registerWorkbook($workbook_dto, $user);
    }

    public function testEditWorkbook()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10,
            'workbook-test-1'
        );
        $workbook_domain = Workbook::createByDto($workbook_dto, $user);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook_domain);
        $workbook_repository->shouldReceive('update')
            ->andReturn();
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $workbook_usecase->editWorkbook('workbook-test-1', $workbook_dto, $user);
    }

    public function testEditWorkbookWithoutPermission()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $editor = factory(\App\User::class)->make(['id' => 15]);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10,
            'workbook-test-1'
        );
        $workbook_domain = Workbook::createByDto($workbook_dto, $user);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook_domain);
        $workbook_repository->shouldReceive('update')
            ->andReturn();
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        try {
            $workbook_usecase->editWorkbook('workbook-test-1', $workbook_dto, $editor);
        } catch (PermissionException $e) {
            self::assertSame("User doesn't have permission to edit", $e->getMessage());
        }
    }

    public function testDeleteWorkbook()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10,
            'workbook-test-1'
        );
        $workbook_domain = Workbook::createByDto($workbook_dto, $user);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook_domain);
        $workbook_repository->shouldReceive('delete')
            ->andReturn();
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        $workbook_usecase->deleteWorkbook('workbook-test-1', 10);
    }

    public function testDeleteWorkbookWithoutPermission()
    {
        $user = factory(\App\User::class)->make(['id' => 10]);
        $workbook_dto = new WorkbookDto(
            "test workbook",
            "This is an example of workbook.",
            [],
            10,
            'workbook-test-1'
        );
        $workbook_domain = Workbook::createByDto($workbook_dto, $user);
        $exercise_repository = m::mock('\App\Domain\ExerciseRepository');
        $workbook_repository = m::mock('\App\Domain\WorkbookRepository');
        $workbook_repository->shouldReceive('findByWorkbookId')
            ->with('workbook-test-1')
            ->andReturn($workbook_domain);
        $workbook_repository->shouldReceive('delete')
            ->andReturn();
        $workbook_usecase = new WorkbookUsecase($workbook_repository, $exercise_repository);
        try {
            $workbook_usecase->deleteWorkbook('workbook-test-1', 15);
        } catch (PermissionException $e) {
            self::assertSame("User doesn't have permission to delete", $e->getMessage());
        }
    }
}
