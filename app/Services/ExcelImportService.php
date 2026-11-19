<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Language;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelImportService
{
    public function exportPartners(iterable $partners, string $filename): StreamedResponse
    {
        $headers = ['name', 'contact_name', 'phone', 'email', 'address', 'notes', 'is_active'];

        return response()->streamDownload(function () use ($headers, $partners): void {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Worksheet ss:Name="Partners"><Table>';
            echo '<Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">'.e($header).'</Data></Cell>';
            }
            echo '</Row>';

            foreach ($partners as $partner) {
                $values = [
                    $partner->name,
                    $partner->contact_name,
                    $partner->phone,
                    $partner->email,
                    $partner->address,
                    $partner->notes,
                    $partner->is_active ? 1 : 0,
                ];
                echo '<Row>';
                foreach ($values as $value) {
                    echo '<Cell><Data ss:Type="String">'.e((string) ($value ?? '')).'</Data></Cell>';
                }
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, $filename, ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function exportProducts(iterable $products, string $filename): StreamedResponse
    {
        $headers = ['SKU', 'Tên sản phẩm', 'Danh mục', 'Giá gốc', 'Giá khuyến mãi', 'Tồn kho', 'Nổi bật', 'Bán chạy', 'Trạng thái'];

        return response()->streamDownload(function () use ($headers, $products): void {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Worksheet ss:Name="Products"><Table>';
            echo '<Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">'.e($header).'</Data></Cell>';
            }
            echo '</Row>';

            foreach ($products as $product) {
                $values = [
                    $product->sku,
                    $product->translation()?->name,
                    $product->category?->translation()?->name,
                    $product->price,
                    $product->sale_price,
                    $product->stock,
                    $product->is_featured ? 'Có' : 'Không',
                    $product->is_bestseller ? 'Có' : 'Không',
                    $product->is_active ? 'Hoạt động' : 'Ẩn',
                ];
                echo '<Row>';
                foreach ($values as $value) {
                    echo '<Cell><Data ss:Type="String">'.e((string) ($value ?? '')).'</Data></Cell>';
                }
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, $filename, ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function exportCategories(iterable $categories, string $filename): StreamedResponse
    {
        $headers = ['Tên danh mục', 'Danh mục cha', 'Thứ tự', 'Trạng thái'];

        return response()->streamDownload(function () use ($headers, $categories): void {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Worksheet ss:Name="Categories"><Table>';
            echo '<Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">'.e($header).'</Data></Cell>';
            }
            echo '</Row>';

            foreach ($categories as $category) {
                $values = [
                    $category->translation()?->name,
                    $category->parent?->translation()?->name,
                    $category->sort_order,
                    $category->is_active ? 'Hoạt động' : 'Ẩn',
                ];
                echo '<Row>';
                foreach ($values as $value) {
                    echo '<Cell><Data ss:Type="String">'.e((string) ($value ?? '')).'</Data></Cell>';
                }
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, $filename, ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function downloadTemplate(string $type): StreamedResponse
    {
        $templates = [
            'categories' => ['Tên danh mục', 'Danh mục cha', 'Thứ tự', 'Trạng thái'],
            'products' => ['Mã SKU', 'Tên sản phẩm', 'Tên sản phẩm tiếng Anh', 'Danh mục', 'Tên đối tác', 'Giá gốc', 'Giá khuyến mãi', 'Tồn kho', 'Nổi bật', 'Bán chạy', 'Trạng thái', 'Mô tả ngắn', 'Mô tả chi tiết'],
            'partners' => ['name', 'contact_name', 'phone', 'email', 'address', 'notes', 'is_active'],
            'customer-groups' => ['name', 'discount_percent'],
            'customers' => ['name', 'email', 'phone', 'password', 'customer_group_name', 'address', 'is_active'],
        ];
        $exampleRows = [
            'categories' => [['Google Gemini', '', '1', 'Hoạt động']],
        ];

        abort_unless(isset($templates[$type]), 404);
        $headers = $templates[$type];

        return response()->streamDownload(function () use ($headers, $exampleRows, $type): void {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Worksheet ss:Name="Import"><Table><Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">'.e($header).'</Data></Cell>';
            }
            echo '</Row>';

            foreach ($exampleRows[$type] ?? [] as $exampleRow) {
                echo '<Row>';
                foreach ($exampleRow as $value) {
                    echo '<Cell><Data ss:Type="String">'.e($value).'</Data></Cell>';
                }
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, $type.'-import-template.xls', ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function import(string $type, UploadedFile $file): int
    {
        $rows = $this->readRows($file);

        return match ($type) {
            'categories' => $this->importCategories($rows),
            'products' => $this->importProducts($rows),
            'partners' => $this->importPartners($rows),
            'customer-groups' => $this->importCustomerGroups($rows),
            'customers' => $this->importCustomers($rows),
            default => throw ValidationException::withMessages(['file' => 'Loại dữ liệu import không hợp lệ.']),
        };
    }

    protected function readRows(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $contents = file_get_contents($file->getRealPath());

        if ($extension === 'csv') {
            return $this->readCsvRows($file->getRealPath());
        }

        if ($extension === 'xlsx') {
            return $this->readXlsxRows($file->getRealPath());
        }

        if (! str_contains($contents, '<Workbook')) {
            return $this->readCsvRows($file->getRealPath());
        }

        $xml = simplexml_load_string($contents);
        if ($xml === false) {
            throw ValidationException::withMessages(['file' => 'File Excel không đúng định dạng.']);
        }
        $rows = [];
        $headers = [];
        $spreadsheetNamespace = 'urn:schemas-microsoft-com:office:spreadsheet';
        foreach ($xml->children($spreadsheetNamespace)->Worksheet->Table->Row as $row) {
            $values = [];
            $nextColumnIndex = 0;
            foreach ($row->children($spreadsheetNamespace)->Cell as $cell) {
                $attributes = $cell->attributes($spreadsheetNamespace);
                $columnIndex = isset($attributes['Index'])
                    ? ((int) $attributes['Index']) - 1
                    : $nextColumnIndex;
                $values[$columnIndex] = trim((string) $cell->children($spreadsheetNamespace)->Data);
                $nextColumnIndex = $columnIndex + 1;
            }
            ksort($values);
            $values = $this->normalizeIndexedValues($values);
            if ($headers === []) {
                $headers = $values;

                continue;
            }
            if (count(array_filter($values, fn ($value) => $value !== '')) > 0) {
                $rows[] = $this->combineRow($headers, $values);
            }
        }

        return $rows;
    }

    protected function readCsvRows(string $path): array
    {
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle, null, ',', '"', '') ?: [];
        if ($headers !== []) {
            $headers[0] = ltrim((string) $headers[0], "\xEF\xBB\xBF");
        }
        $rows = [];
        while (($values = fgetcsv($handle, null, ',', '"', '')) !== false) {
            $rows[] = $this->combineRow($headers, $values);
        }
        fclose($handle);

        return $rows;
    }

    protected function readXlsxRows(string $path): array
    {
        $zip = new \ZipArchive;
        if ($zip->open($path) !== true) {
            throw ValidationException::withMessages(['file' => 'File Excel không đúng định dạng.']);
        }

        $sharedStrings = [];
        if ($zip->locateName('xl/sharedStrings.xml') !== false) {
            $sharedStringsXml = simplexml_load_string((string) $zip->getFromName('xl/sharedStrings.xml'));
            if ($sharedStringsXml !== false) {
                foreach ($sharedStringsXml->si as $sharedString) {
                    $pieces = [];
                    foreach ($sharedString->children('http://schemas.openxmlformats.org/spreadsheetml/2006/main')->t as $text) {
                        $pieces[] = (string) $text;
                    }
                    $sharedStrings[] = trim(implode('', $pieces) ?: (string) $sharedString->t);
                }
            }
        }

        $sheetName = null;
        for ($index = 0; $index < $zip->numFiles; $index++) {
            $name = $zip->getNameIndex($index);
            if (preg_match('#^xl/worksheets/sheet\d+\.xml$#', $name ?? '') === 1) {
                $sheetName = $name;

                break;
            }
        }

        if ($sheetName === null) {
            $zip->close();
            throw ValidationException::withMessages(['file' => 'File Excel không đúng định dạng.']);
        }

        $sheetXml = simplexml_load_string((string) $zip->getFromName($sheetName));
        $zip->close();
        if ($sheetXml === false) {
            throw ValidationException::withMessages(['file' => 'File Excel không đúng định dạng.']);
        }

        $rows = [];
        $headers = [];
        foreach ($sheetXml->sheetData->row as $row) {
            $values = [];
            foreach ($row->c as $cell) {
                $cellReference = (string) $cell['r'];
                $columnIndex = $this->xlsxColumnIndex($cellReference);
                $values[$columnIndex] = $this->xlsxCellValue($cell, $sharedStrings);
            }
            ksort($values);
            $rowValues = $this->normalizeIndexedValues($values);

            if ($headers === []) {
                $headers = $rowValues;

                continue;
            }

            if (count(array_filter($rowValues, fn ($value) => $value !== '')) > 0) {
                $rows[] = $this->combineRow($headers, $rowValues);
            }
        }

        return $rows;
    }

    protected function normalizeIndexedValues(array $values): array
    {
        if ($values === []) {
            return [];
        }

        $normalized = [];
        $lastIndex = max(array_keys($values));
        for ($index = 0; $index <= $lastIndex; $index++) {
            $normalized[$index] = $values[$index] ?? '';
        }

        return array_values($normalized);
    }

    protected function combineRow(array $headers, array $values): array
    {
        $headers = array_map(
            fn ($header) => trim((string) $header),
            array_values($headers),
        );
        if ($headers !== []) {
            $headers[0] = ltrim($headers[0], "\xEF\xBB\xBF");
        }

        $columnCount = count($headers);
        if ($columnCount === 0) {
            return [];
        }

        $values = array_map(
            fn ($value) => trim((string) $value),
            array_slice(array_pad(array_values($values), $columnCount, ''), 0, $columnCount),
        );

        return array_combine($headers, $values) ?: [];
    }

    protected function xlsxColumnIndex(string $cellReference): int
    {
        preg_match('/([A-Z]+)/i', strtoupper($cellReference), $matches);
        $column = $matches[1] ?? 'A';
        $index = 0;
        foreach (str_split($column) as $character) {
            $index = $index * 26 + (ord($character) - 64);
        }

        return $index - 1;
    }

    protected function xlsxCellValue(\SimpleXMLElement $cell, array $sharedStrings): string
    {
        $cellType = (string) $cell['t'];

        if ($cellType === 'inlineStr') {
            return trim((string) $cell->is->t);
        }

        if ($cellType === 's') {
            $sharedIndex = (int) trim((string) $cell->v);

            return $sharedStrings[$sharedIndex] ?? '';
        }

        if ($cellType === 'b') {
            $value = strtolower(trim((string) $cell->v));

            return $value === '1' || $value === 'true' ? '1' : '0';
        }

        return trim((string) $cell->v);
    }

    protected function importCategories(array $rows): int
    {
        $language = Language::where('is_active', true)->orderByDesc('is_default')->firstOrFail();
        $columnAliases = [
            'Tên danh mục' => 'name',
            'Danh mục cha' => 'parent_name',
            'Thứ tự' => 'sort_order',
            'Trạng thái' => 'is_active',
        ];

        return DB::transaction(function () use ($rows, $language, $columnAliases): int {
            foreach ($rows as $index => $row) {
                foreach ($columnAliases as $label => $column) {
                    if (array_key_exists($label, $row) && ! array_key_exists($column, $row)) {
                        $row[$column] = $row[$label];
                    }
                }

                $this->requireColumns($row, ['name'], $index);
                $translation = $this->findTranslation('category', $row['name'], $language->id);
                $category = $translation ? Category::find($translation->category_id) : Category::create([]);
                $activeValue = $row['is_active'] ?? true;
                $isActive = match (Str::lower(trim((string) $activeValue))) {
                    'hoạt động' => true,
                    'ẩn' => false,
                    default => $this->boolean($activeValue),
                };
                $category->update(['parent_id' => $this->categoryId($row['parent_name'] ?? null, $language->id), 'sort_order' => $this->integer($row['sort_order'] ?? 0), 'is_active' => $isActive]);
                $category->translations()->updateOrCreate(['language_id' => $language->id], ['name' => $row['name'], 'slug' => Str::slug($row['name'])]);
            }

            return count($rows);
        });
    }

    protected function importProducts(array $rows): int
    {
        $language = Language::where('is_active', true)->orderByDesc('is_default')->firstOrFail();
        $englishLanguage = Language::where('code', 'en')->first();
        $columnAliases = [
            'Mã SKU' => 'sku',
            'Tên sản phẩm' => 'name',
            'Tên sản phẩm tiếng Anh' => 'name_en',
            'Danh mục' => 'category_name',
            'Tên đối tác' => 'partner_name',
            'Giá gốc' => 'price',
            'Giá khuyến mãi' => 'sale_price',
            'Tồn kho' => 'stock',
            'Nổi bật' => 'is_featured',
            'Bán chạy' => 'is_bestseller',
            'Trạng thái' => 'is_active',
            'Mô tả ngắn' => 'short_description',
            'Mô tả chi tiết' => 'description',
        ];

        return DB::transaction(function () use ($rows, $language, $englishLanguage, $columnAliases): int {
            foreach ($rows as $index => $row) {
                foreach ($columnAliases as $label => $column) {
                    if (array_key_exists($label, $row) && ! array_key_exists($column, $row)) {
                        $row[$column] = $row[$label];
                    }
                }

                $this->requireColumns($row, ['sku', 'name', 'category_name', 'price'], $index);
                $categoryId = $this->categoryId($row['category_name'], $language->id);
                if (! $categoryId) {
                    throw ValidationException::withMessages(['file' => 'Dòng '.($index + 2).': không tìm thấy danh mục.']);
                }
                $partnerName = $this->nullableString($row['partner_name'] ?? null);
                $partnerId = $partnerName === null ? null : Partner::where('name', $partnerName)->value('id');
                if ($partnerName !== null && $partnerId === null) {
                    throw ValidationException::withMessages(['file' => 'Dòng '.($index + 2).': không tìm thấy đối tác.']);
                }

                $englishName = $this->nullableString($row['name_en'] ?? null) ?? Str::ascii($row['name']);
                if ($englishLanguage === null) {
                    throw ValidationException::withMessages(['file' => 'Dòng '.($index + 2).': chưa cấu hình ngôn ngữ tiếng Anh.']);
                }

                $product = Product::firstOrNew(['sku' => $row['sku']]);
                $productData = ['category_id' => $categoryId, 'price' => $row['price'], 'sale_price' => $row['sale_price'] ?: null, 'stock' => $this->integer($row['stock'] ?? 0), 'is_featured' => $this->boolean($row['is_featured'] ?? false), 'is_bestseller' => $this->boolean($row['is_bestseller'] ?? false), 'is_active' => $this->boolean($row['is_active'] ?? true)];
                if ($partnerName !== null) {
                    $productData['partner_id'] = $partnerId;
                }
                $product->fill($productData)->save();
                $product->translations()->updateOrCreate(['language_id' => $language->id], ['name' => $row['name'], 'slug' => Str::slug($row['name']).'-'.$product->id, 'short_description' => $row['short_description'] ?? null, 'description' => $row['description'] ?? null]);

                $product->translations()->updateOrCreate(['language_id' => $englishLanguage->id], ['name' => $englishName, 'slug' => Str::slug($englishName).'-'.$product->id]);
            }

            return count($rows);
        });
    }

    protected function importPartners(array $rows): int
    {
        return DB::transaction(function () use ($rows): int {
            foreach ($rows as $index => $row) {
                $this->requireColumns($row, ['name'], $index);

                $activeValue = trim((string) ($row['is_active'] ?? ''));
                $partnerData = [
                    'name' => trim((string) $row['name']),
                    'contact_name' => $this->nullableString($row['contact_name'] ?? null),
                    'phone' => $this->nullableString($row['phone'] ?? null),
                    'email' => $this->nullableString($row['email'] ?? null),
                    'address' => $this->nullableString($row['address'] ?? null),
                    'notes' => $this->nullableString($row['notes'] ?? null),
                    'is_active' => $activeValue === '' ? true : $this->boolean($activeValue),
                ];
                $validator = Validator::make($partnerData, [
                    'name' => 'required|string|max:255',
                    'contact_name' => 'nullable|string|max:255',
                    'phone' => 'nullable|string|max:30',
                    'email' => 'nullable|email|max:255',
                    'address' => 'nullable|string|max:1000',
                    'notes' => 'nullable|string|max:2000',
                    'is_active' => 'boolean',
                ]);

                if ($validator->fails()) {
                    throw ValidationException::withMessages([
                        'file' => 'Dòng '.($index + 2).': '.$validator->errors()->first(),
                    ]);
                }

                Partner::updateOrCreate(['name' => $partnerData['name']], $partnerData);
            }

            return count($rows);
        });
    }

    protected function importCustomerGroups(array $rows): int
    {
        return DB::transaction(function () use ($rows): int {
            foreach ($rows as $index => $row) {
                $this->requireColumns($row, ['name'], $index);
                CustomerGroup::updateOrCreate(['name' => $row['name']], ['discount_percent' => $row['discount_percent'] ?? 0]);
            }

            return count($rows);
        });
    }

    protected function importCustomers(array $rows): int
    {
        return DB::transaction(function () use ($rows): int {
            foreach ($rows as $index => $row) {
                $this->requireColumns($row, ['name', 'email', 'password'], $index);
                $customer = Customer::firstOrNew(['email' => $row['email']]);
                $customer->fill(['name' => $row['name'], 'phone' => $row['phone'] ?? null, 'address' => $row['address'] ?? null, 'customer_group_id' => CustomerGroup::where('name', $row['customer_group_name'] ?? '')->value('id'), 'is_active' => $this->boolean($row['is_active'] ?? true)]);
                if (! $customer->exists || filled($row['password'])) {
                    $customer->password = $row['password'];
                }
                $customer->save();
            }

            return count($rows);
        });
    }

    protected function categoryId(?string $name, int $languageId): ?int
    {
        return $name ? $this->findTranslation('category', $name, $languageId)?->category_id : null;
    }

    protected function findTranslation(string $type, string $name, int $languageId): mixed
    {
        $model = $type === 'category' ? CategoryTranslation::class : ProductTranslation::class;

        return $model::where('language_id', $languageId)->where('name', $name)->first();
    }

    protected function requireColumns(array $row, array $columns, int $index): void
    {
        foreach ($columns as $column) {
            if (! isset($row[$column]) || trim((string) $row[$column]) === '') {
                throw ValidationException::withMessages(['file' => 'Dòng '.($index + 2).': thiếu cột '.$column.'.']);
            }
        }
    }

    protected function boolean(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? ((int) $value === 1);
    }

    protected function integer(mixed $value): int
    {
        return (int) ($value ?: 0);
    }

    protected function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
