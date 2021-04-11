<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SEO;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::get()->first();
        if (!empty($setting)) {
            $setting_id =  $setting->id;
        } else {
            $setting_id =  '';
        }

        return view('admin.settings.setting', [
            'setting' => $setting,
            'setting_id' => $setting_id,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSeo()
    {

        $seo_setting = SEO::get()->first();
        if (!empty($seo_setting)) {
            $seo_id =  $seo_setting->id;
        } else {
            $seo_id =  '';
        }

        return view('admin.settings.seoSetting', [
            'seo_setting' => $seo_setting,
            'seo_id' => $seo_id,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSocilaMedia()
    {

        $site_setting = Setting::get()->first();
        if (!empty($site_setting)) {
            $site_setting_id  =  $site_setting->id;
        } else {
            $site_setting_id  =  '';
        }

        return view('admin.settings.siteSetting', [
            'site_setting' => $site_setting,
            'site_setting_id' => $site_setting_id,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSetting(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'company_name' => 'required|min:3|max:255',
            'moblie_number' => 'required|min:3|max:255',
            'email' => 'required|email',
            'address' => 'required|min:3|max:255',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $setting = Setting::get()->first();
        if (empty($setting)) {
            $setting = new Setting();
        } else {
            $setting =  Setting::findOrFail($request->setting_id);
        }
        $setting->company_name = $request->company_name;
        $setting->email = $request->email;
        $setting->mobile_phone = $request->moblie_number;
        $setting->hand_phone_number = $request->hand_phone_number;
        $setting->address = $request->address;
        $setting->save();

        return ['success' => 'Setting has been successfull updated'];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSeo(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'meta_keywords' => 'required|min:10|max:255',
            'meta_author' => 'required|min:3|max:255',
            'meta_description' => 'required|min:3|max:255',
            'google_analytics' => 'required|min:3|max:255',
            'facebook_analytics' => 'required|min:3|max:255',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $seo = SEO::get()->first();
        if (empty($seo)) {
            $seo = new SEO();
        } else {
            $seo =  SEO::findOrFail($request->seo_id);
        }
        $seo->meta_keywords = $request->meta_keywords;
        $seo->meta_author = $request->meta_author;
        $seo->meta_description = $request->meta_description;
        $seo->google_analytics = $request->google_analytics;
        $seo->facebook_analytics = $request->facebook_analytics;
        $seo->yahoo_analytics = $request->yahoo_analytics;
        $seo->bing_analytics = $request->bing_analytics;
        $seo->save();

        return ['success' => 'Seo Setting has been successfull updated'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSocialMedia(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'facebook' => 'required|min:3|max:255',
            'youtube' => 'required|min:3|max:255',
            'instagram' => 'required|min:3|max:255',
            'twitter' => 'required|min:3|max:255',
            'facebook_url' => 'required_with:facebook|url|max:255',
            'youtube_url' => 'required_with:youtube|url|max:255',
            'instagram_url' => 'required_with:instagram|url|max:255',
            'twitter_url' => 'required_with:twitter|url|max:255',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $setting = Setting::get()->first();
        if (empty($setting)) {
            $setting = new Setting();
        } else {
            $setting =  Setting::findOrFail($request->setting_id);
        }
        $setting->facebook = $request->facebook;
        $setting->youtube = $request->youtube;
        $setting->instagram = $request->instagram;
        $setting->twitter = $request->twitter;
        $setting->facebook_url = $request->facebook_url;
        $setting->youtube_url = $request->youtube_url;
        $setting->instagram_url = $request->instagram_url;
        $setting->twitter_url = $request->twitter_url;
        $setting->save();

        return ['success' => 'Social media Setting has been successfull updated'];
    }
}
