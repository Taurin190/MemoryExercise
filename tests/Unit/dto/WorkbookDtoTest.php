<?php


namespace Tests\Unit\dto;


use App\Dto\WorkbookDto;
use Tests\TestCase;

class WorkbookDtoTest extends TestCase
{
    public function testToArray()
    {
        $workbook_dto = new WorkbookDto(
            'test-title',
            'this is test workbook',
            [],
            10,
            'test-workbook-1'
        );
        $actual = $workbook_dto->toArray();
        self::assertSame('test-title', $actual['title']);
        self::assertSame('this is test workbook', $actual['explanation']);
        self::assertSame([], $actual['exercise_list']);
        self::assertSame('test-workbook-1', $actual['workbook_id']);
    }
}
