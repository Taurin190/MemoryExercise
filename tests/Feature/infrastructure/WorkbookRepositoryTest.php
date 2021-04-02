<?php


namespace Tests\Feature\infrastructure;


use App\Domain\Workbook;
use App\Domain\Workbooks;
use App\Exceptions\DataNotFoundException;
use App\Infrastructure\WorkbookRepository;
use Tests\TestCase;

class WorkbookRepositoryTest extends TestCase
{
    public function testFindByWorkbookId()
    {
        $workbook_repository = new WorkbookRepository();
        $actual = $workbook_repository->findByWorkbookId('test1');
        self::assertTrue($actual instanceof Workbook);
        $dto = $actual->getWorkbookDto();
        self::assertSame('test workbook1', $dto->title);
        self::assertSame('this is sample workbook no.1', $dto->explanation);
    }

    public function testFindByWorkbookIdWithInvalidId()
    {
        $workbook_repository = new WorkbookRepository();
        try {
            $workbook_repository->findByWorkbookId('test999');
        } catch (DataNotFoundException $e) {
            self::assertSame('Data Not Fount: Invalid Workbook Id.', $e->getMessage());
        }
    }

    public function testFindWorkbooks()
    {
        $workbook_repository = new WorkbookRepository();
        $actual = $workbook_repository->findWorkbooks();
        self::assertTrue($actual instanceof Workbooks);
        self::assertSame(4, $actual->count());
    }
}
