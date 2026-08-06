<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


    public function AdminProfile(){
        $userId = Auth::user()->id;
        $profileData = User::find($userId);
        return view('backend.profile.admin-profile', compact('profileData'));
    }

    Public function AdminProfileStore(Request $request){

        // Validation 

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
       

        $user = User::findOrFail(Auth::id());

        $oldPhoto = $user->photo;

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);


        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $fileName = Str::uuid() . '.' . $file->extension();

            $file->move(
                public_path('upload/user_images'),
                $fileName
            );

            $user->photo = $fileName;
        }

        $user->save();

        if (
            $request->hasFile('photo') &&
            $oldPhoto &&
            $oldPhoto !== $user->photo
        ) {
            $this->deleteOldImage($oldPhoto);
        }

        $notification = array(
                'message' => 'Profile updated successfully',
                'alert-type' => 'success'
        );

        // return redirect()->back()->with('success', 'Profile updated successfully!');
        return redirect()->back()->with($notification);

    }


    public function AdminPasswordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // if (!password_verify($request->old_password, $user->password)) {
        //     return redirect()->back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        // }

        // $user->password = bcrypt($request->new_password);
        // $user->save();

        // return redirect()->back()->with('success', 'Password updated successfully!');

        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' => 'The provided password does not match your current password.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    private function deleteOldImage(?string $imageName): void {
        if (!$imageName) {
            return;
        }

        $fullPath = public_path('upload/user_images/' . basename($imageName));

        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }

      
}


