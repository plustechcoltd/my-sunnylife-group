<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index(): View
    {
        $settings = Setting::get();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
        $logoLoginPath = $this->handleFileUpdate('logo_login', $request);
        $logoPath = $this->handleFileUpdate('logo', $request);
        $lightLogoPath = $this->handleFileUpdate('light_logo', $request);
        $faviconPath = $this->handleFileUpdate('favicon', $request);

        $data = [
            ['name' => 'logo_login', 'value' => $logoLoginPath],
            ['name' => 'logo', 'value' => $logoPath],
            ['name' => 'light_logo', 'value' => $lightLogoPath],
            ['name' => 'favicon', 'value' => $faviconPath],
            ['name' => 'site_title', 'value' => $request->input('site_title')],
            ['name' => 'site_description', 'value' => $request->input('site_description')],
            ['name' => 'maintenance_message', 'value' => $request->input('maintenance_message')],
            ['name' => 'boxed_page', 'value' => $request->input('boxed_page')],
            ['name' => 'fixed_footer', 'value' => $request->input('fixed_footer')],
            ['name' => 'display_footer', 'value' => $request->input('display_footer')],
            ['name' => 'header_background_color', 'value' => $request->input('header_background_color')],
            ['name' => 'header_text_color', 'value' => $request->input('header_text_color')],
            ['name' => 'navbar_background_color', 'value' => $request->input('navbar_background_color')],
            ['name' => 'navbar_text_color', 'value' => $request->input('navbar_text_color')],
        ];
        Setting::set($data);

        $this->activityLogService->save(
            'settings',
            Setting::first()->id,
            'update'
        );

        return redirect()->route('admin.settings.index')->with('success', __('flash_message.success.update_no_id'));
    }

    private function handleFileUpdate($fieldName, Request $request)
    {
        $configPath = "filesystems.paths.settings.$fieldName";
        $disk = 'public';

        if ($request->hasFile($fieldName)) {
            return FileHelper::processFileUpload(
                $request->file($fieldName),
                $configPath,
                $disk
            );
        } elseif ($request->boolean("remove_$fieldName")) {
            $this->deleteExistingFile($fieldName, $configPath, $disk);
            return null;
        } else {
            return Setting::where('name', $fieldName)->first()?->value;
        }
    }

    private function deleteExistingFile($fieldName, $configPath, $disk)
    {
        $oldPath = Setting::where('name', $fieldName)->first()?->value;
        if ($oldPath) {
            $fullPath = config($configPath) . '/' . basename($oldPath);
            if (Storage::disk($disk)->exists($fullPath)) {
                Storage::disk($disk)->delete($fullPath);
            }
        }
    }
}
