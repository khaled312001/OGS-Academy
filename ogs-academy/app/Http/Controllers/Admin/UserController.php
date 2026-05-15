<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validateData($request, $user);
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'تم تحديث المستخدم.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'لا يمكنك حذف حسابك الحالي.']);
        }
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم.');
    }

    private function validateData(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name'      => ['required', 'string', 'max:160'],
            'email'     => ['required', 'email', 'max:160', Rule::unique('users')->ignore($user?->id)],
            'phone'     => ['nullable', 'string', 'max:32'],
            'role'      => ['required', 'in:superadmin,admin,editor'],
            'is_active' => ['nullable', 'boolean'],
            'password'  => [$user ? 'nullable' : 'required', 'nullable', 'string', 'min:8', 'confirmed'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}
