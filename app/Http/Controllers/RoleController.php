<?php
namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showRoles(){
        $roles = Roles::all(); 
        return view('roles', compact('roles'));
    }
    public function addRole(Request $request){

        $validatedData = $request->validate([
            'displayname' => 'required|string|max:255|unique:roles,displayname', 
            'description' => 'required|string',
        ]);
        $role = new Roles();
        $role->displayname = $validatedData['displayname'];
        $role->description = $validatedData['description'];
        $role->save();
        return redirect()->back()->with('success', 'Role added successfully!');
    }
    public function deleteRole($id)
    {
        $role = Roles::findOrFail($id);
        try {
            $role->delete();
            return redirect()->route('roles')->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('roles')->withErrors(['delete_error' => 'Failed to delete role.']);
        }
    }
    public function updateRole(Request $request, $id)
    {
        $role = Roles::findOrFail($id); 
        $validatedData = $request->validate([
            'displayname' => 'required|string|max:255|unique:roles,displayname,' . $id, 
            'description' => 'required|string',
        ]);
        $role->displayname = $validatedData['displayname'];
        $role->description = $validatedData['description'];
        $role->save();

        return redirect()->route('roles')->with('success', 'Role updated successfully!');
    }
}
