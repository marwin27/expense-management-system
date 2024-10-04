<?php
namespace App\Http\Controllers;

use App\Models\ExpensesCategories; 
use Illuminate\Http\Request;

class ExpensesCategoriesController extends Controller
{
    public function showExpensesCategories()
    {
        $categories = ExpensesCategories::all();
        return view('expensecategories', compact('categories'));
    }
    public function storeCategory(Request $request)
    {
        $request->validate([
            'expensecategory' => 'required|string|max:255|unique:expensescategories,expensecategory', 
            'description' => 'nullable|string|max:255', 
        ]);
    
        ExpensesCategories::create([
            'expensecategory' => $request->expensecategory,
            'description' => $request->description, 
        ]);
    
        return redirect()->route('expensecategories')->with('success', 'Expense category added successfully!');
    }
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'expensecategory' => 'required|string|max:255|unique:expensescategories,expensecategory,' . $id, 
            'description' => 'nullable|string|max:255', 
        ]);
    
        $category = ExpensesCategories::findOrFail($id);
        $category->expensecategory = $request->expensecategory;
        $category->description = $request->description;
        $category->save();
    
        return redirect()->route('expensecategories')->with('success', 'Expense category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = ExpensesCategories::findOrFail($id);
        $category->delete();
    
        return redirect()->route('expensecategories')->with('success', 'Expense category deleted successfully!');
    }

}
