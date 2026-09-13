<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelImportService
{
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

    public function downloadTemplate(string $type): StreamedResponse
    {
        $templates = [
            'categories' => ['name', 'parent_name', 'sort_order', 'is_active'],
            'products' => ['sku', 'name', 'category_name', 'price', 'sale_price', 'stock', 'is_featured', 'is_bestseller', 'is_active', 'short_description', 'description'],
            'customer-groups' => ['name', 'discount_percent'],
            'customers' => ['name', 'email', 'phone', 'password', 'customer_group_name', 'address', 'is_active'],
        ];

        abort_unless(isset($templates[$type]), 404);
        $headers = $templates[$type];

        return response()->streamDownload(function () use ($headers): void {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Worksheet ss:Name="Import"><Table><Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">'.e($header).'</Data></Cell>';
            }
            echo '</Row></Table></Worksheet></Workbook>';
        }, $type.'-import-template.xls', ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function import(string $type, UploadedFile $file): int
    {
        $rows = $this->readRows($file);

        return match ($type) {
            'categories' => $this->importCategories($rows),
            'products' => $this->importProducts($rows),
            'customer-groups' => $this->importCustomerGroups($rows),
            'customers' => $this->importCustomers($rows),
            default => throw ValidationException::withMessages(['file' => 'Loại dữ liệu import không hợp lệ.']),
        };
    }

    protected function readRows(UploadedFile $file): array
    {
        $contents = file_get_contents($file->getRealPath());
        if (strtolower($file->getClientOriginalExtension()) === 'csv' || ! str_contains($contents, '<Workbook')) {
            $handle = fopen($file->getRealPath(), 'r');
            $headers = fgetcsv($handle) ?: [];
            $rows = [];
            while (($values = fgetcsv($handle)) !== false) {
                $rows[] = array_combine($headers, array_pad($values, count($headers), '')) ?: [];
            }
            fclose($handle);

            return $rows;
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
            foreach ($row->children($spreadsheetNamespace)->Cell as $cell) {
                $values[] = trim((string) $cell->children($spreadsheetNamespace)->Data);
            }
            if ($headers === []) {
                $headers = $values;

                continue;
            }
            if (count(array_filter($values, fn ($value) => $value !== '')) > 0) {
                $rows[] = array_combine($headers, array_pad($values, count($headers), '')) ?: [];
            }
        }

        return $rows;
    }

    protected function importCategories(array $rows): int
    {
        $language = Language::where('is_active', true)->orderByDesc('is_default')->firstOrFail();

        return DB::transaction(function () use ($rows, $language): int {
            foreach ($rows as $index => $row) {
                $this->requireColumns($row, ['name'], $index);
                $translation = $this->findTranslation('category', $row['name'], $language->id);
                $category = $translation ? Category::find($translation->category_id) : Category::create([]);
                $category->update(['parent_id' => $this->categoryId($row['parent_name'] ?? null, $language->id), 'sort_order' => $this->integer($row['sort_order'] ?? 0), 'is_active' => $this->boolean($row['is_active'] ?? true)]);
                $category->translations()->updateOrCreate(['language_id' => $language->id], ['name' => $row['name'], 'slug' => Str::slug($row['name'])]);
            }

            return count($rows);
        });
    }

    protected function importProducts(array $rows): int
    {
        $language = Language::where('is_active', true)->orderByDesc('is_default')->firstOrFail();

        return DB::transaction(function () use ($rows, $language): int {
            foreach ($rows as $index => $row) {
                $this->requireColumns($row, ['sku', 'name', 'category_name', 'price'], $index);
                $categoryId = $this->categoryId($row['category_name'], $language->id);
                if (! $categoryId) {
                    throw ValidationException::withMessages(['file' => 'Dòng '.($index + 2).': không tìm thấy danh mục.']);
                }
                $product = Product::firstOrNew(['sku' => $row['sku']]);
                $product->fill(['category_id' => $categoryId, 'price' => $row['price'], 'sale_price' => $row['sale_price'] ?: null, 'stock' => $this->integer($row['stock'] ?? 0), 'is_featured' => $this->boolean($row['is_featured'] ?? false), 'is_bestseller' => $this->boolean($row['is_bestseller'] ?? false), 'is_active' => $this->boolean($row['is_active'] ?? true)])->save();
                $product->translations()->updateOrCreate(['language_id' => $language->id], ['name' => $row['name'], 'slug' => Str::slug($row['name']).'-'.$product->id, 'short_description' => $row['short_description'] ?? null, 'description' => $row['description'] ?? null]);
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
}
