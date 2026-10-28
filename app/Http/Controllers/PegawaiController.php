<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    /**
     * Display a listing of pegawai
     */
    public function index()
    {
        // Get all pegawai accounts
        $pegawai = Pegawai::orderBy('created_at', 'desc')->get();

        // Count statistics
        $totalPegawai = $pegawai->count();
        $activePegawai = $pegawai->where('is_blocked', false)->count();
        $blockedPegawai = $pegawai->where('is_blocked', true)->count();

        return view('admin.pegawai.index', compact(
            'pegawai',
            'totalPegawai',
            'activePegawai',
            'blockedPegawai'
        ));
    }

    /**
     * Store a newly created pegawai
     */
    public function store(Request $request)
    {
        // Ambil input email atau prefix username email
        $rawEmail = $request->input('email');
        if (empty($rawEmail)) {
            $rawEmail = $request->input('email_prefix', $request->input('email_username', ''));
        }
        $rawEmail = trim((string) $rawEmail);

        // Jika hanya memasukkan nama sebelum email (contoh: "satria"), otomatis tambahkan "@telkom.com"
        if ($rawEmail !== '' && !str_contains($rawEmail, '@')) {
            $rawEmail .= '@telkom.com';
        }

        $request->merge(['email' => $rawEmail]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pegawai,email',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Generate random password (8-12 characters)
        $password = $this->generatePassword();

        $adminId = Auth::user() ? (int) str_replace('admin_', '', Auth::user()->getAuthIdentifier()) : null;

        // Create pegawai account
        $pegawai = Pegawai::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'is_approved' => true, // Auto-approved when created by Admin
            'approved_by' => $adminId,
            'approved_at' => now(),
            'is_blocked' => false,
        ]);

        return back()->with([
            'success' => 'Akun pegawai berhasil dibuat!',
            'new_password' => $password,
            'new_user_name' => $pegawai->name,
            'new_user_email' => $pegawai->email,
        ]);
    }

    /**
     * Update the specified pegawai
     */
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $rawEmail = trim((string) $request->input('email', ''));
        if ($rawEmail !== '' && !str_contains($rawEmail, '@')) {
            $rawEmail .= '@telkom.com';
            $request->merge(['email' => $rawEmail]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pegawai,email,' . $id,
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan oleh akun lain',
        ]);

        $pegawai->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', "Data pegawai {$pegawai->name} berhasil diupdate!");
    }

    /**
     * Remove the specified pegawai
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $pegawaiName = $pegawai->name;
        $pegawai->delete();

        return back()->with('success', "Akun pegawai {$pegawaiName} berhasil dihapus!");
    }

    /**
     * Reset password for specific pegawai
     */
    public function resetPassword($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Generate new random password
        $newPassword = $this->generatePassword();

        // Update password
        $pegawai->update([
            'password' => Hash::make($newPassword),
        ]);

        return back()->with([
            'success' => 'Password berhasil direset!',
            'new_password' => $newPassword,
            'new_user_name' => $pegawai->name,
            'new_user_email' => $pegawai->email,
        ]);
    }

    /**
     * Toggle block status for specific pegawai
     */
    public function toggleBlock($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $adminId = Auth::user() ? (int) str_replace('admin_', '', Auth::user()->getAuthIdentifier()) : null;
        $newStatus = !$pegawai->is_blocked;

        $pegawai->update([
            'is_blocked' => $newStatus,
            'blocked_by' => $newStatus ? $adminId : null,
            'blocked_at' => $newStatus ? now() : null,
            'blocked_reason' => $newStatus ? 'Diblokir oleh Administrator' : null,
        ]);

        $message = $newStatus 
            ? "Akun pegawai {$pegawai->name} berhasil diblokir." 
            : "Akun pegawai {$pegawai->name} berhasil diaktifkan kembali.";

        return back()->with('success', $message);
    }


    /**
     * Generate random secure password
     */
    private function generatePassword($length = 10)
    {
        // Generate password with mix of uppercase, lowercase, numbers, and symbols
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%';

        $password = '';
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
        $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
        $password .= $numbers[rand(0, strlen($numbers) - 1)];
        $password .= $symbols[rand(0, strlen($symbols) - 1)];

        $allCharacters = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }

        return str_shuffle($password);
    }
}
