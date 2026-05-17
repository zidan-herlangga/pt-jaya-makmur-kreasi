<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiModelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    public function index(): View
    {
        $aiModels = AiModel::ordered()->get();
        $providers = AiModel::providers();

        return view('admin.ai-models.index', compact('aiModels', 'providers'));
    }

    public function create(): View
    {
        $providers = AiModel::providers();
        return view('admin.ai-models.form', compact('providers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'provider' => ['required', 'string', 'max:50'],
            'label' => ['required', 'string', 'max:200'],
            'model' => ['required', 'string', 'max:200'],
            'api_key' => ['nullable', 'string'],
            'base_url' => ['nullable', 'string', 'max:500'],
            'max_tokens' => ['nullable', 'integer', 'min:1', 'max:999999'],
            'temperature' => ['nullable', 'numeric', 'min:0', 'max:2'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        AiModel::create($validated);

        return redirect()
            ->route('admin.ai-models.index')
            ->with('success', 'Model AI berhasil ditambahkan.');
    }

    public function edit(AiModel $aiModel): View
    {
        $providers = AiModel::providers();
        return view('admin.ai-models.form', compact('aiModel', 'providers'));
    }

    public function update(Request $request, AiModel $aiModel): RedirectResponse
    {
        $validated = $request->validate([
            'provider' => ['required', 'string', 'max:50'],
            'label' => ['required', 'string', 'max:200'],
            'model' => ['required', 'string', 'max:200'],
            'api_key' => ['nullable', 'string'],
            'base_url' => ['nullable', 'string', 'max:500'],
            'max_tokens' => ['nullable', 'integer', 'min:1', 'max:999999'],
            'temperature' => ['nullable', 'numeric', 'min:0', 'max:2'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if (empty($validated['api_key'])) {
            unset($validated['api_key']);
        }

        $aiModel->update($validated);

        return redirect()
            ->route('admin.ai-models.index')
            ->with('success', 'Model AI berhasil diperbarui.');
    }

    public function destroy(AiModel $aiModel): RedirectResponse
    {
        $aiModel->delete();

        return redirect()
            ->route('admin.ai-models.index')
            ->with('success', 'Model AI berhasil dihapus.');
    }

    public function toggleActive(AiModel $aiModel): RedirectResponse
    {
        $aiModel->update(['is_active' => !$aiModel->is_active]);

        $status = $aiModel->fresh()->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.ai-models.index')
            ->with('success', "Model AI \"{$aiModel->label}\" berhasil {$status}.");
    }
}
