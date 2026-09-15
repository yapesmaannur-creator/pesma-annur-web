<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = User::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }
        $users = $query->latest()->paginate(15)->appends(request()->query());
        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,editor,ustadz,pengasuh,pengurus,santri,alumni,kontributor',
            'phone_number' => 'nullable|string|max:20',
            'social_fb' => 'nullable|url|max:255',
            'social_ig' => 'nullable|url|max:255',
            'social_x' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_scholar' => 'nullable|url|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'social_fb' => $request->social_fb,
            'social_ig' => $request->social_ig,
            'social_x' => $request->social_x,
            'social_linkedin' => $request->social_linkedin,
            'social_scholar' => $request->social_scholar,
        ]);

        try {
            // Ambil email semua anggota tim redaksi (role: editor) dan admin
            $redaksiEmails = User::whereIn('role', ['editor', 'admin'])->pluck('email')->filter(function ($email) use ($user) {
                return $email !== $user->email; // Jangan kirim ulang ke user baru jika ia juga admin/editor
            })->toArray();

            $mail = \Illuminate\Support\Facades\Mail::to($user->email);
            
            if (!empty($redaksiEmails)) {
                $mail->bcc($redaksiEmails);
            }

            $mail->send(new \App\Mail\UserRegisteredMail($user, $request->password));

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan dan notifikasi email telah dikirim (termasuk tembusan ke Tim Redaksi).');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send registration email: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan, namun notifikasi email gagal dikirim. Silakan beritahu ' . $user->name . ' kredensialnya secara lisan.');
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,editor,ustadz,pengasuh,pengurus,santri,alumni,kontributor',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string|max:500',
            'social_fb' => 'nullable|url|max:255',
            'social_ig' => 'nullable|url|max:255',
            'social_x' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_scholar' => 'nullable|url|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_number = $request->phone_number;
        $user->bio = $request->bio;
        $user->social_fb = $request->social_fb;
        $user->social_ig = $request->social_ig;
        $user->social_x = $request->social_x;
        $user->social_linkedin = $request->social_linkedin;
        $user->social_scholar = $request->social_scholar;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
