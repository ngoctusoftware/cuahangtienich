<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerGroupController extends Controller
{
    public function index(): View
    {
        return view('admin.customer-groups.index', ['groups' => CustomerGroup::withCount('customers')->get()]);
    }

    public function create(): View
    {
        return view('admin.customer-groups.form', ['group' => new CustomerGroup()]);
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
