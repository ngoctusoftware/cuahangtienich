<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\ExcelImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PartnerController extends Controller
{
    public function downloadTemplate(ExcelImportService $excel): StreamedResponse
    {
        return $excel->downloadTemplate('partners');
    }

    public function import(Request $request, ExcelImportService $excel): RedirectResponse
    {
        $request->validate(['file' => 'required|file|mimes:xls,csv|max:10240']);
        $count = $excel->import('partners', $request->file('file'));

        return back()->with('success', "Đã import {$count} đối tác.");
    }

    public function exportCurrent(Request $request, ExcelImportService $excel): StreamedResponse
    {
        $page = $request->integer('page', 1);
        $partners = Partner::orderBy('name')->paginate(15, ['*'], 'page', $page)->getCollection();

        return $excel->exportPartners($partners, 'partners-page-'.$page.'.xls');
    }

    public function exportAll(ExcelImportService $excel): StreamedResponse
    {
        return $excel->exportPartners(Partner::orderBy('name')->get(), 'partners-all.xls');
    }

    public function index(): View
    {
        $partners = Partner::withCount('products')->orderBy('name')->paginate(15);

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.form', ['partner' => new Partner]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Đã thêm đối tác.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Đã cập nhật đối tác.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->products()->exists()) {
            return back()->withErrors(['partner' => 'Không thể xóa đối tác đang được gắn với sản phẩm.']);
        }

        $partner->delete();

        return back()->with('success', 'Đã xóa đối tác.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'is_active' => 'nullable|boolean',
        ]);
    }
}
