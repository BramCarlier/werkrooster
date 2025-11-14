<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use App\Services\SlackNotifier;
use App\Services\SmsNotifier;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = NotificationSetting::first();
        if (!$settings) {
            $settings = NotificationSetting::create([
                'slack_webhook_url'     => null,
                'sms_to'                => null,
                'enable_daily_summary'  => false,
                'daily_time'            => '07:00',
            ]);
        }

        return view('settings.index', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slack_webhook_url'    => 'nullable|string',
            'sms_to'               => 'nullable|string',
            'enable_daily_summary' => 'boolean',
            'daily_time'           => 'required|string',
        ]);

        $settings = NotificationSetting::first() ?? new NotificationSetting();
        $settings->fill($data);
        $settings->save();

        return response()->json(['status' => 'ok']);
    }

    public function testSlack(SlackNotifier $slack)
    {
        $settings = NotificationSetting::first();
        if (!$settings || !$settings->slack_webhook_url) {
            return response()->json(['error' => 'Geen Slack-webhook ingesteld'], 422);
        }

        $slack->send('Testbericht vanuit Werkrooster-app');

        return response()->json(['status' => 'ok']);
    }

    public function testSms(SmsNotifier $sms)
    {
        $settings = NotificationSetting::first();
        if (!$settings || !$settings->sms_to) {
            return response()->json(['error' => 'Geen SMS-ontvanger ingesteld'], 422);
        }

        $sms->send($settings->sms_to, 'Test SMS vanuit Werkrooster-app');

        return response()->json(['status' => 'ok']);
    }
}
