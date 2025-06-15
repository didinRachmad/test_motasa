<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;

use App\Models\Menu;
use App\Models\Produksi;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('setting.users.index');
    }

    public function data()
    {
        $menu = currentMenu(); // helper dari AppServiceProvider

        $query = User::query()
            ->select('users.id', 'users.name', 'users.email')
            ->with('roles');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('roles', function ($row) {
                return $row->roles->pluck('name')->implode(', '); // Ambil nama role dan gabungkan
            })
            ->addColumn('can_reset_password', fn ($row) => Auth::user()->hasMenuPermission($menu->id, 'edit'))
            ->addColumn('can_edit', fn ($row) => Auth::user()->hasMenuPermission($menu->id, 'edit'))
            ->addColumn('can_delete', fn ($row) => Auth::user()->hasMenuPermission($menu->id, 'destroy'))
            ->addColumn('reset_password_url', fn ($row) => route('users.reset-password', $row->id))
            ->addColumn('edit_url', fn ($row) => route('users.edit', $row->id))
            ->addColumn('delete_url', fn ($row) => route('users.destroy', $row->id))
            ->make(true);
    }

    public function create()
    {
        // Ambil semua role (Anda bisa menyaring role yang diperbolehkan untuk assignment)
        $roles = Role::all();
        return view('setting.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users',
            'password'     => 'required|string|min:8|confirmed',
            'role_id'      => 'required|exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            // Assign role ke user baru
            $role = Role::find($validated['role_id']);
            $user->assignRole($role);

            DB::commit();

            session()->flash('success', 'User baru berhasil ditambahkan.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat membuat users baru: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat user baru. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('setting.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email',
            'role_id'  => 'required|exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update role user
            $role = Role::find($validated['role_id']);
            $user->syncRoles($role); // pakai syncRoles untuk mengganti role lama ke role baru

            DB::commit();
            session()->flash('success', 'Data user berhasil diperbarui.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memperbarui users: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function resetPassword(User $user)
    {
        // Untuk keamanan, Anda dapat menambahkan konfirmasi lebih lanjut (misalnya, modal konfirmasi di view)
        $defaultPassword = '12345678';

        DB::beginTransaction();
        try {
            // Update password menggunakan Hash (bcrypt)
            $user->update([
                'password' => Hash::make($defaultPassword),
            ]);

            Log::info("Password untuk user {$user->email} telah direset oleh " . Auth::user()->email);
            DB::commit();
            session()->flash('success', 'Password user telah direset ke default.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat reset password users: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat reset password. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        // Cegah super_admin menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::beginTransaction();
        try {
            $user->forceDelete();
            DB::commit();
            session()->flash('success', 'Data user berhasil dinonaktifkan.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menghapus user: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function getUsersByRole($roleId)
    {
        $users = User::whereHas('roles', function ($query) use ($roleId) {
            $query->where('id', $roleId);
        })->get(['id', 'email']);

        return response()->json([
            'data' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->email
                ];
            })
        ]);
    }
}
