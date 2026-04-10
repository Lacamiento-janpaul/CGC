<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $profile = Auth::user()->profile ?? [];
        $history = $profile['status_history'] ?? [];
        $editing = null;

        if ($request->has('edit')) {
            $index = (int) $request->query('edit');
            if (isset($history[$index])) {
                $editing = $history[$index];
                $editing['edit_index'] = $index;
            }
        }

        $reports = $profile['emergency_reports'] ?? [];
        if (!is_array($reports)) {
            $reports = [];
        }

        $handledResponses = collect($reports)->filter(function ($report) {
            return isset($report['handled']) && $report['handled'] && !empty($report['response']);
        })->values();

        $profileComplete = $this->isProfileComplete(Auth::user());

        return view('user.dashboard', compact('editing', 'handledResponses', 'profileComplete'));
    }

    protected function isProfileComplete($user)
    {
        $requiredProfileFields = [
            'age',
            'sex',
            'date_of_birth',
            'nationality',
            'residential_address',
            'business_address',
            'contact_number',
            'emergency_contact_number',
            'vessel_name',
            'security_number',
            'former_name_registry',
            'home_port',
            'certificate_issuance_date',
            'certificate_expiration',
            'material_hull',
            'length_meters',
            'breadth_meters',
            'depth_meters',
            'gross_tonnage',
            'net_tonnage',
            'dead_weight',
            'engine_make',
            'serial_number',
            'horse_power',
            'speed',
        ];

        if (empty(trim((string) $user->name)) || empty(trim((string) $user->email))) {
            return false;
        }

        $profile = $user->profile ?? [];
        foreach ($requiredProfileFields as $field) {
            if (empty(trim((string) ($profile[$field] ?? '')))) {
                return false;
            }
        }

        return true;
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateStatus(Request $request)
    {
        if (!$this->isProfileComplete(Auth::user())) {
            return redirect()->route('user.dashboard')->with('error', 'Please complete your profile before submitting your current status.');
        }

        $validated = $request->validate([
            'security_number' => ['required', 'string', 'max:50'],
            'date' => ['nullable', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'current_location' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'edit_index' => ['nullable', 'integer', 'min:0'],
        ]);

        $profile = Auth::user()->profile ?? [];
        $history = $profile['status_history'] ?? [];

        $entry = [
            'security_number' => $validated['security_number'],
            'date' => $validated['date'] ?? null,
            'time' => $validated['time'] ?? null,
            'current_location' => $validated['current_location'] ?? null,
            'destination' => $validated['destination'] ?? null,
            'status' => $validated['status'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ];

        if (isset($validated['edit_index']) && array_key_exists($validated['edit_index'], $history)) {
            $history[$validated['edit_index']] = $entry;
        } else {
            $history[] = $entry;
        }

        $profile['status_history'] = array_values($history);
        Auth::user()->profile = $profile;
        Auth::user()->save();

        return redirect()->route('user.dashboard')->with('status', 'Status history saved successfully.');
    }

    public function submitReport(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
            'emergency_type' => ['required', 'string', 'in:Minor,Extreme'],
            'report_date' => ['nullable', 'date'],
            'report_time' => ['nullable', 'date_format:H:i'],
        ]);

        $profile = Auth::user()->profile ?? [];
        $reports = $profile['emergency_reports'] ?? [];

        $reports[] = [
            'name' => $validated['name'] ?? Auth::user()->name,
            'contact' => $validated['contact'] ?? null,
            'location' => $validated['location'] ?? null,
            'message' => $validated['message'] ?? null,
            'emergency_type' => $validated['emergency_type'],
            'report_date' => $validated['report_date'] ?? now()->format('Y-m-d'),
            'report_time' => $validated['report_time'] ?? now()->format('H:i'),
            'submitted_at' => now()->format('Y-m-d H:i:s'),
            'user_id' => Auth::id(),
        ];

        $profile['emergency_reports'] = array_values($reports);
        Auth::user()->profile = $profile;
        Auth::user()->save();

        return redirect()->route('user.dashboard')->with('status', 'Emergency report submitted successfully.');
    }

    public function deleteStatus(int $index)
    {
        $profile = Auth::user()->profile ?? [];
        $history = $profile['status_history'] ?? [];

        if (isset($history[$index])) {
            unset($history[$index]);
            $profile['status_history'] = array_values($history);
            Auth::user()->profile = $profile;
            Auth::user()->save();
        }

        return redirect()->route('user.dashboard')->with('status', 'Status history entry deleted.');
    }

    public function updateProfile(Request $request)
    {
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

        $profile = Auth::user()->profile ?? [];
        $profile = array_merge($profile, [
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
        ]);
        Auth::user()->profile = $profile;

        Auth::user()->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    public function settings()
    {
        return view('user.settings');
    }

    public function showChangeUsername()
    {
        return view('user.change-username');
    }

    public function changeUsername(Request $request)
    {
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
        return view('user.change-password');
    }

    public function changePassword(Request $request)
    {
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
        return view('user.delete-account');
    }

    public function deleteAccount(Request $request)
    {
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
