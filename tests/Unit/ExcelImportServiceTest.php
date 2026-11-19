<?php

namespace Tests\Unit;

use App\Services\ExcelImportService;
use PHPUnit\Framework\TestCase;

class ExcelImportServiceTest extends TestCase
{
    public function test_csv_rows_do_not_throw_when_a_row_has_extra_columns(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'excel-import-');
        file_put_contents($path, "name,email\nAlice,alice@example.com,extra\nBob,bob@example.com");

        try {
            $method = new \ReflectionMethod(ExcelImportService::class, 'readCsvRows');
            $rows = $method->invoke(new ExcelImportService, $path);
        } finally {
            unlink($path);
        }

        $this->assertSame([
            ['name' => 'Alice', 'email' => 'alice@example.com'],
            ['name' => 'Bob', 'email' => 'bob@example.com'],
        ], $rows);
    }
}
