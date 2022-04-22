<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public $setting = null;

    public function __construct()
    {
        $this->setting = Setting::first();
    }

    public function index()
    {
        abort_if(Gate::denies('setting_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $settingData = Setting::first();
        return view('admin.setting.index', compact('settingData'));
    }

    public function updateGeneralData(Request $request)
    {
        abort_if(Gate::denies('setting_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'web_name' => 'required'
        ]);
        $this->setting = Setting::first();
        $this->setting->update([
            'web_name' => $request->web_name
        ]);
        return back();
    }

    public function updateLogo(Request $request)
    {
        abort_if(Gate::denies('setting_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $path = storage_path('app/public/logo');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $logo = $request->logo;
        $filename = $logo->getClientOriginalName();
        $extension = explode(".", $filename);
        $newFileName = uniqid() . "." . $extension[1];

        $logoResize = Image::make($logo->getRealPath());
        $logoResize->resize(256, 256);
        $logoResize->save(storage_path('app/public/logo/' . $newFileName));

        if (Storage::disk('public')->exists($this->setting->logo)) {
            Storage::disk('public')->delete($this->setting->logo);
        }

        $this->setting->update([
            'logo' => 'logo/' . $newFileName
        ]);
        return back();
    }
}
