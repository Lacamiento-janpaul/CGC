<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected function authorizeAdmin(): void
    {
        abort_if(Auth::user()->role !== 'admin', 403);
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $users = User::where('role', 'user')->get()->map(function (User $user) {
            $profile = $user->profile ?? [];
            $history = $profile['status_history'] ?? [];
            $latestStatus = null;

            if (is_array($history) && count($history) > 0) {
                $latest = array_values($history);
                $latestStatus = end($latest);
            }

            $historyText = collect(is_array($history) ? $history : [])->map(function ($entry) {
                return trim(sprintf(
                    '%s %s %s %s %s %s',
                    $entry['security_number'] ?? '',
                    $entry['date'] ?? '',
                    $entry['time'] ?? '',
                    $entry['current_location'] ?? '',
                    $entry['destination'] ?? '',
                    $entry['status'] ?? ''
                ));
            })->filter()->implode(' ');

            $user->latest_status = $latestStatus;
            $user->history_text = $historyText;
            $user->history_entries = is_array($history) ? $history : [];
            return $user;
        });

        $reports = User::whereNotNull('profile')->get()->flatMap(function (User $user) {
            $profile = $user->profile ?? [];
            $emergencies = $profile['emergency_reports'] ?? [];

            return collect($emergencies)->map(function ($report) use ($user) {
                return [
                    'user' => $user,
                    'report' => $report,
                ];
            });
        })->filter(function ($item) {
            return !isset($item['report']['handled']) || !$item['report']['handled'];
        });

        return view('admin.dashboard', compact('users', 'reports'));
    }

    public function showUserProfile(int $id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        return view('admin.user-profile', compact('user'));
    }

    public function showUserHistory(int $id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);
        $history = $user->profile['status_history'] ?? [];

        if (! is_array($history)) {
            $history = [];
        }

        return view('admin.user-history', compact('user', 'history'));
    }

    public function respondToEmergency(Request $request, int $userId, int $index)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'response' => ['required', 'string', 'max:1000'],
        ]);

        $user = User::findOrFail($userId);
        $profile = $user->profile ?? [];
        $emergencies = $profile['emergency_reports'] ?? [];

        if (isset($emergencies[$index])) {
            $emergencies[$index]['handled'] = true;
            $emergencies[$index]['response'] = $validated['response'];
            $emergencies[$index]['handled_at'] = now()->format('Y-m-d H:i:s');
            $emergencies[$index]['handled_by'] = Auth::id();

            $profile['emergency_reports'] = array_values($emergencies);
            $user->profile = $profile;
            $user->save();
        }

        return redirect()->route('admin.dashboard')->with('status', 'Emergency response submitted successfully.');
    }

    public function emergencyHistory()
    {
        $this->authorizeAdmin();

        $handledReports = User::whereNotNull('profile')->get()->flatMap(function (User $user) {
            $profile = $user->profile ?? [];
            $emergencies = $profile['emergency_reports'] ?? [];

            return collect($emergencies)->filter(function ($report) {
                return isset($report['handled']) && $report['handled'];
            })->map(function ($report) use ($user) {
                return [
                    'user' => $user,
                    'report' => $report,
                ];
            });
        });

        return view('admin.emergency-history', compact('handledReports'));
    }

    public function profile()
    {
        $this->authorizeAdmin();

        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'age' => ['nullable', 'string', 'max:50'],
            'sex' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'residential_address' => ['nullable', 'string', 'max:255'],
            'business_address' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:100'],
            'emergency_contact_number' => ['nullable', 'string', 'max:100'],
            'vessel_name' => ['nullable', 'string', 'max:255'],
            'security_number' => ['nullable', 'string', 'max:255'],
            'former_name_registry' => ['nullable', 'string', 'max:255'],
            'home_port' => ['nullable', 'string', 'max:255'],
            'certificate_issuance_date' => ['nullable', 'string', 'max:255'],
            'certificate_expiration' => ['nullable', 'string', 'max:255'],
            'material_hull' => ['nullable', 'string', 'max:255'],
            'length_meters' => ['nullable', 'string', 'max:255'],
            'breadth_meters' => ['nullable', 'string', 'max:255'],
            'depth_meters' => ['nullable', 'string', 'max:255'],
            'gross_tonnage' => ['nullable', 'string', 'max:255'],
            'net_tonnage' => ['nullable', 'string', 'max:255'],
            'dead_weight' => ['nullable', 'string', 'max:255'],
            'engine_make' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'horse_power' => ['nullable', 'string', 'max:255'],
            'speed' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($validated['name'])) {
            Auth::user()->name = $validated['name'];
        }

        if (isset($validated['email'])) {
            Auth::user()->email = $validated['email'];
        }

        if ($request->hasFile('avatar')) {
            File::ensureDirectoryExists(public_path('avatars'));

            $avatarFile = $request->file('avatar');
            $avatarName = sprintf('avatar-%s-%s.%s', Auth::id(), time(), $avatarFile->extension());
            $avatarFile->move(public_path('avatars'), $avatarName);

            if (Auth::user()->avatar && File::exists(public_path(Auth::user()->avatar))) {
                File::delete(public_path(Auth::user()->avatar));
            }

            Auth::user()->avatar = 'avatars/' . $avatarName;
        }

        Auth::user()->profile = [
            'age' => $validated['age'] ?? null,
            'sex' => $validated['sex'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'residential_address' => $validated['residential_address'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
            'vessel_name' => $validated['vessel_name'] ?? null,
            'security_number' => $validated['security_number'] ?? null,
            'former_name_registry' => $validated['former_name_registry'] ?? null,
            'home_port' => $validated['home_port'] ?? null,
            'certificate_issuance_date' => $validated['certificate_issuance_date'] ?? null,
            'certificate_expiration' => $validated['certificate_expiration'] ?? null,
            'material_hull' => $validated['material_hull'] ?? null,
            'length_meters' => $validated['length_meters'] ?? null,
            'breadth_meters' => $validated['breadth_meters'] ?? null,
            'depth_meters' => $validated['depth_meters'] ?? null,
            'gross_tonnage' => $validated['gross_tonnage'] ?? null,
            'net_tonnage' => $validated['net_tonnage'] ?? null,
            'dead_weight' => $validated['dead_weight'] ?? null,
            'engine_make' => $validated['engine_make'] ?? null,
            'serial_number' => $validated['serial_number'] ?? null,
            'horse_power' => $validated['horse_power'] ?? null,
            'speed' => $validated['speed'] ?? null,
        ];

        Auth::user()->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    public function settings()
    {
        $this->authorizeAdmin();

        return view('admin.settings');
    }

    public function showChangeUsername()
    {
        $this->authorizeAdmin();

        return view('admin.change-username');
    }

    public function changeUsername(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'current_username' => ['required', 'string', 'alpha_dash'],
            'new_username' => ['required', 'string', 'min:3', 'max:64', 'alpha_dash', 'unique:users,username'],
        ]);

        if ($validated['current_username'] !== Auth::user()->username) {
            return back()->with('error', 'Current username does not match your account.');
        }

        Auth::user()->forceFill(['username' => $validated['new_username']])->save();

        return back()->with('status', 'Username updated successfully.');
    }

    public function showChangePassword()
    {
        $this->authorizeAdmin();

        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        Auth::user()->forceFill(['password' => $validated['new_password']])->save();

        return back()->with('status', 'Password changed successfully.');
    }

    public function showDeleteAccount()
    {
        $this->authorizeAdmin();

        return view('admin.delete-account');
    }

    public function deleteAccount(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string'],
        ]);

        if ($validated['password'] !== $validated['password_confirmation']) {
            return back()->with('error', 'Passwords do not match.');
        }

        if (! Hash::check($validated['password'], Auth::user()->password)) {
            return back()->with('error', 'Password is incorrect.');
        }

        Auth::user()->delete();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Your account has been deleted.');
    }
}
