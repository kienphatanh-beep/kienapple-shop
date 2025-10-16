<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // 🧩 Danh sách người dùng
    public function index()
    {
        $list = User::whereIn('roles', ['admin', 'customer'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('backend.user.index', compact('list'));
    }

    // 🧩 Form thêm người dùng
    public function create()
    {
        return view('backend.user.create');
    }

    // 🧩 Thêm người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|in:admin,customer',
            'status' => 'required|boolean',
            'phone' => 'required|string|unique:user,phone',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $username = $request->username ?: strtolower(str_replace(' ', '.', $request->name));
        if (User::where('username', $username)->exists()) {
            return redirect()->back()->with('error', 'Username đã tồn tại.');
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatarPath = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/user'), $avatarPath);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles,
            'status' => $request->status,
            'phone' => $request->phone,
            'username' => $username,
            'address' => '',
            'avatar' => $avatarPath,
            'created_by' => Auth::id() ?? 1,
        ]);

        return redirect()->route('admin.user.index')->with('success', '✅ Thêm người dùng thành công.');
    }

    // 🧩 Hiển thị form sửa
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.edit', compact('user'));
    }

    // 🧩 Cập nhật người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id,
            'roles' => 'required|in:admin,customer',
            'status' => 'required|boolean',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && File::exists(public_path('assets/images/user/' . $user->avatar))) {
                File::delete(public_path('assets/images/user/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $avatarPath = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/user'), $avatarPath);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles,
            'status' => $request->status,
            'phone' => $request->phone,
            'avatar' => $avatarPath,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.user.index')->with('success', '✏️ Cập nhật người dùng thành công.');
    }

    // 🧩 Xóa mềm
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', '🗑 Đã chuyển vào thùng rác.');
    }

    // 🧩 Thùng rác
    public function trash()
    {
        $list = User::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);
        return view('backend.user.trash', compact('list'));
    }

    // 🧩 Khôi phục
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.user.trash')->with('success', '♻️ Khôi phục người dùng thành công.');
    }

    // 🧩 Xóa vĩnh viễn
    public function delete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->avatar && File::exists(public_path('assets/images/user/' . $user->avatar))) {
            File::delete(public_path('assets/images/user/' . $user->avatar));
        }

        $user->forceDelete();

        return redirect()->route('admin.user.trash')->with('success', '❌ Xóa vĩnh viễn người dùng thành công.');
    }

    // 🧩 Chi tiết người dùng
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.show', compact('user'));
    }

    // 🧩 Đổi trạng thái
    public function status($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->updated_by = Auth::id() ?? 1;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', '🔄 Đã cập nhật trạng thái người dùng.');
    }
}
