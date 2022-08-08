<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\Repositories\SettingRepository;
use Xetaravel\Models\Setting;

class SettingController extends Controller
{
    /**
     *  Get a setting by his name.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $setting = Setting::where('name', $name)->first();

        return new Json($setting);
    }

    /**
     * Create the new ticket and save it.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function update(Request $request)
    {
        $setting = Setting::where('name', $request->input('name'))->first();

        SettingRepository::update([
            'name' => $setting->name,
            'type' => 'value_int',
            'value' => $request->input('value'),
            'description' => $setting->description
        ], $setting);

        return new Json($setting);
    }
}
