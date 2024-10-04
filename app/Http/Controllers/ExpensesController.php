<?php
namespace App\Http\Controllers;

use App\Models\Expense; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function expenses()
    {
        $expenses = Auth::user()->role === 'Admin'
            ? Expense::all() 
            : Expense::where('user_id', Auth::id())->get(); 

        return view('expenses', compact('expenses'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'expensecategory' => 'required|string|in:Travel,Entertainment', 
            'date' => 'required|date',
        ]);
    
        Expense::create([
            'amount' => $request->amount,
            'expensecategory' => $request->expensecategory,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('expenses')->with('success', 'Expense added successfully!');
    }
    
    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'expensecategory' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $expense = Expense::findOrFail($id);

        if (Auth::user()->role !== 'Admin' && $expense->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $expense->update($request->only(['amount', 'description', 'date']));

        return redirect()->route('expenses')->with('success', 'Expense updated successfully!');
    }
    public function totalExpenses()
{
    $totals = Expense::select('expensecategory', DB::raw('SUM(amount) as total_amount'))
        ->groupBy('expensecategory')
        ->get();

    return view('dashboard', compact('totals'));
}

}
