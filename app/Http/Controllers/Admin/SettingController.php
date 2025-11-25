<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', ['setting' => Setting::first()]);
    }

    public function update(Request $request)
    {
        $request->validate(['exchange_rate' => 'required|numeric']);

        $setting = Setting::first();
        $setting->update(['exchange_rate' => $request->exchange_rate]);

        return redirect()->back()->with('success', 'Exchange rate updated.');
    }
}
