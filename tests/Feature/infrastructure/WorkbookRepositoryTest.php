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

    public function testUpdate()
    {
        $workbook_repository = new WorkbookRepository();
        $workbook_domain = $workbook_repository->findByWorkbookId('test2');
        $workbook_domain->edit([
            'title' => 'modified test workbook2',
            'explanation' => 'this is modified sample workbook no.2'
        ]);
        $workbook_repository->update($workbook_domain);
        $acutal = $workbook_repository->findByWorkbookId('test2');
        $dto = $acutal->getWorkbookDto();
        self::assertSame('modified test workbook2', $dto->title);
        self::assertSame('this is modified sample workbook no.2', $dto->explanation);
    }

    public function testDelete()
    {
        $workbook_domain = Workbook::create([
            'title' => 'test new domain',
            'explanation' => 'This is test new domain.',
        ]);
        $workbook_repository = new WorkbookRepository();
        $workbook_repository->save($workbook_domain);
        $workbooks = $workbook_repository->findWorkbooks();
        self::assertSame(5, $workbooks->count());
        $workbook_id = '';
        foreach ($workbooks->getWorkbookDtoList() as $dto) {
            if ($dto->workbook_id != 'test1'
                && $dto->workbook_id != 'test2'
                && $dto->workbook_id != 'test3'
                && $dto->workbook_id != 'test4') {
                $workbook_id = $dto->workbook_id;
                break;
            }
        }
        $workbook_repository->delete($workbook_id);
        $workbooks = $workbook_repository->findWorkbooks();
        self::assertSame(4, $workbooks->count());
        try {
            $workbook_repository->findByWorkbookId($workbook_id);
        } catch (DataNotFoundException $e) {
            self::assertSame('Data Not Fount: Invalid Workbook Id.', $e->getMessage());
        }
    }
}
