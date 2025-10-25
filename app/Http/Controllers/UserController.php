<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserPasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $users = $query->paginate(10)->onEachSide(1);


        return view("user.index", [
            'users' => $users,
            'request' => $request,
        ]);

    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view("user.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserPasswordUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->input("password")),
        ]);
        return redirect()->route("users.index")->with("success", "password updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("users.index")->with("success", "user archived successfully.");
    }

    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route("users.index", ['archived' => 'true'])->with("success", "user restored successfully.");
    }
}
