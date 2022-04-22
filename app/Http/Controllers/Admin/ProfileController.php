<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateGeneralData(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id
        ]);

        $user->update($request->only('name', 'email'));
        toast('Profile updated','success');
        return back();
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:5|confirmed'
        ]);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        toast('Password updated','success');
        return back();
    }

    public function updateAvatar(Request $request, User $user)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $path = storage_path('app/public/profile_images');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $avatar = $request->avatar;
        $filename = $avatar->getClientOriginalName();
        $extension = explode(".", $filename);
        $newFileName = uniqid() . "." . $extension[1];

        $avatarResize = Image::make($avatar->getRealPath());
        $avatarResize->resize(256, 256);
        $avatarResize->save(storage_path('app/public/profile_images/' . $newFileName));

        if (Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update([
            'avatar' => 'profile_images/' . $newFileName
        ]);
        toast('Avatar updated','success');
        return back();
    }
}
