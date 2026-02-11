<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Settings/Index', [
            'yandexUrl' => $request->user()->yandex_url ?? '',
            'status' => session('status'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'yandex_url' => ['nullable', 'string', 'url', 'max:500'],
        ]);
        $request->user()->update([
            'yandex_url' => $validated['yandex_url'] ?? null,
        ]);
        return redirect()->route('settings')->with('status', 'saved');
    }
}
