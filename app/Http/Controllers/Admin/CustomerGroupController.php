<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use App\Services\ExcelImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerGroupController extends Controller
{
    public function downloadTemplate(ExcelImportService $excel): mixed
    {
        return $excel->downloadTemplate('customer-groups');
    }

    public function import(Request $request, ExcelImportService $excel): RedirectResponse
    {
        $request->validate(['file' => 'required|file|mimes:xls,csv|max:10240']);
        $count = $excel->import('customer-groups', $request->file('file'));

        return back()->with('success', "Đã import {$count} nhóm khách hàng.");
    }

    public function index(): View
    {
        return view('admin.customer-groups.index', ['groups' => CustomerGroup::withCount('customers')->get()]);
    }

    public function create(): View
    {
        return view('admin.customer-groups.form', ['group' => new CustomerGroup]);
    }

    public function store(Request $request): RedirectResponse
    {
        CustomerGroup::create($this->validated($request));

        return redirect()->route('admin.customer-groups.index')->with('success', 'Đã thêm nhóm khách hàng.');
    }

    public function edit(CustomerGroup $customerGroup): View
    {
        return view('admin.customer-groups.form', ['group' => $customerGroup]);
    }

    public function update(Request $request, CustomerGroup $customerGroup): RedirectResponse
    {
        $customerGroup->update($this->validated($request));

        return redirect()->route('admin.customer-groups.index')->with('success', 'Đã cập nhật nhóm khách hàng.');
    }

    public function destroy(CustomerGroup $customerGroup): RedirectResponse
    {
        $customerGroup->delete();

        return back()->with('success', 'Đã xoá nhóm khách hàng.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);
    }
}
