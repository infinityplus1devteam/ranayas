<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ShopByBudget;
use App\Model\MapShopByBudgetProduct;
use App\Model\TxnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use DB;

class ShopByBudgetController extends Controller
{
    public function index()
    {
        $budgets = ShopByBudget::orderBy('sort_index', 'ASC')->paginate(50);
        return view('backend.admin.shop_by_budgets.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
        ],
        [
            'name.required' => 'Please Enter Budget Title',
        ]);

        ShopByBudget::create([
            'name' => $request->name,
            'budget' => 0,
            'description' => $request->description,
            'is_active' => true,
        ]);

        connectify('success', 'Shop By Budget Added', 'Budget section has been Added Successfully!');

        return redirect(route('admin.shop_by_budgets.index'));
    }

    public function edit($id)
    {
        try {
            $budget = ShopByBudget::where('id', $id)->firstOrFail();
            return view('backend.admin.shop_by_budgets.edit', compact('budget'));
        } catch (\Exception $ex) {
            connectify('error', 'Budget Edit', 'Whoops, Budget Not Found!');
            return redirect(route('admin.shop_by_budgets.index'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
        ]);

        try {
            $budget = ShopByBudget::where('id', $id)->firstOrFail();
            $budget->update([
                'name' => $request->name,
                'budget' => 0,
                'description' => $request->description,
                'is_active' => $request->is_active ?? 0,
            ]);

            connectify('success', 'Budget Updated', 'Budget has been updated successfully!');
            return redirect()->back();
        } catch (\Exception $ex) {
            connectify('error', 'Budget Update', 'Whoops, Something Went Wrong!');
            return redirect(route('admin.shop_by_budgets.index'));
        }
    }

    public function destroy($id)
    {
        try {
            $budget = ShopByBudget::where('id', $id)->firstOrFail();
            $budget->delete();
            
            // Delete pivot table records
            MapShopByBudgetProduct::where('shop_by_budget_id', $id)->delete();

            connectify('success', 'Budget Deleted', 'Budget has been deleted successfully!');
            return redirect(route('admin.shop_by_budgets.index'));
        } catch (\Exception $ex) {
            connectify('error', 'Budget Delete', 'Whoops, Something Went Wrong!');
            return redirect(route('admin.shop_by_budgets.index'));
        }
    }

    public function assignPage($id)
    {
        try {
            $budget = ShopByBudget::where('id', $id)->firstOrFail();
            
            // All active products
            $products = TxnProduct::with('colors')->where('status', true)->get();
            
            // Assigned products
            $assignedProducts = MapShopByBudgetProduct::where('shop_by_budget_id', $id)
                                    ->with(['product', 'product.colors'])
                                    ->orderBy('sort_index')
                                    ->get();
                                    
            return view('backend.admin.shop_by_budgets.assign', compact('products', 'budget', 'assignedProducts'));

        } catch (\Exception $ex) {
            connectify('error', 'Assign View', 'Whoops, Budget Not Found!');
            return redirect(route('admin.shop_by_budgets.index'));
        }
    }

    public function assignProduct(Request $request, $id)
    {
        $request->validate([
            'assign' => 'required|array',
        ],
        [
            'assign.required' => 'Please Select Atleast One Product',
        ]);

        try {
            $budget = ShopByBudget::where('id', $id)->firstOrFail();

            foreach ($request->assign as $productId) {
                // Check if already assigned
                $exists = MapShopByBudgetProduct::where('shop_by_budget_id', $budget->id)
                                ->where('product_id', $productId)
                                ->exists();
                
                if(!$exists) {
                    // Get max sort index
                    $maxSort = MapShopByBudgetProduct::where('shop_by_budget_id', $budget->id)->max('sort_index');
                    
                    MapShopByBudgetProduct::create([
                        'shop_by_budget_id' => $budget->id,
                        'product_id' => $productId,
                        'sort_index' => $maxSort ? $maxSort + 1 : 1
                    ]);
                }
            }

            connectify('success', 'Products Assigned', 'Products assigned to ' . $budget->name . ' successfully!');
            return redirect()->back();
        } catch (\Exception $ex) {
            Log::error(['Assign Budget Product' => $ex->getMessage()]);
            connectify('error', 'Assign Product', 'Whoops, Something Went Wrong!');
            return redirect()->back();
        }
    }

    public function removeAssign(Request $request, $id)
    {
        $request->validate([
            'remove_assign' => 'required|array',
        ]);

        try {
            foreach ($request->remove_assign as $mapId) {
                MapShopByBudgetProduct::where('id', $mapId)->delete();
            }

            connectify('success', 'Removed Assign Product', 'Products Removed successfully!');
            return redirect()->back();

        } catch (\Exception $ex) {
            connectify('error', 'Remove Assigned Product', 'Whoops, Something Went Wrong!');
            return redirect()->back();
        }
    }

    public function updateSort(Request $request, $id)
    {
        if ($request->has('sort_data') && is_array($request->sort_data)) {
            foreach ($request->sort_data as $mapId => $sortIndex) {
                MapShopByBudgetProduct::where('id', $mapId)->update(['sort_index' => $sortIndex]);
            }
            connectify('success', 'Sort Updated', 'Sort order updated successfully!');
        }
        return redirect()->back();
    }

    public function updateBudgetsSort(Request $request)
    {
        if ($request->has('sort_data') && is_array($request->sort_data)) {
            foreach ($request->sort_data as $budgetId => $sortIndex) {
                ShopByBudget::where('id', $budgetId)->update(['sort_index' => $sortIndex]);
            }
            connectify('success', 'Sort Updated', 'Budgets sort order updated successfully!');
        }
        return redirect()->back();
    }
}
