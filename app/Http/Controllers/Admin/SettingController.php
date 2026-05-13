<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageOptimizationService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private SettingService $settingService,
        private ImageOptimizationService $imageService,
    ) {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    public function index(): View
    {
        $settings = $this->settingService->getAllGrouped();
        $groups = $this->settingService->getGroups();

        return view('admin.settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request): RedirectResponse
    {
        $knownKeys = $this->settingService->getAllGrouped();
        $flatKeys = collect($knownKeys)->flatMap(function ($group) {
            return array_keys($group);
        })->toArray();

        $data = $request->validate([
            '_token' => ['nullable'],
            '_method' => ['nullable'],
        ]);

        $settingsData = $this->settingService->getAllGrouped();
        $flatTypes = collect($settingsData)->flatMap(function ($group) {
            return collect($group)->map(function ($item) {
                return $item['type'] ?? 'text';
            });
        })->toArray();

        foreach ($flatKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $result = $this->imageService->process($file, 'settings', $key);
                $this->settingService->set($key, $result['original']);
            } elseif (($flatTypes[$key] ?? 'text') === 'image') {
                continue;
            } elseif ($request->has($key)) {
                $this->settingService->set($key, $request->input($key));
            }
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
