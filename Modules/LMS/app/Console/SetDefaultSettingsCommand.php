<?php

namespace Modules\LMS\Console;

use Illuminate\Console\Command;
use Modules\LMS\Models\General\ThemeSetting;

class SetDefaultSettingsCommand extends Command
{
    protected $signature = 'lms:set-settings 
                            {--app_name= : Application name} 
                            {--contact_email= : Contact email}
                            {--max_devices=2 : Max devices per user (1 or 2)}
                            {--currency=USD-$ : Currency code}
                            {--time_zone=UTC : Time zone}
                            {--date_format=Y-m-d : Date format}
                            {--platform_fee=0 : Platform fee}';

    protected $description = 'Set backend general settings (app name, contact email, etc.) without logging in.';

    public function handle(): int
    {
        $appName = $this->option('app_name') ?: config('app.name', 'LMS');
        $contactEmail = $this->option('contact_email') ?: 'admin@gmail.com';
        $maxDevices = (int) ($this->option('max_devices') ?: 2);
        $maxDevices = in_array($maxDevices, [1, 2], true) ? $maxDevices : 2;
        $currency = $this->option('currency') ?: 'USD-$';
        $timeZone = $this->option('time_zone') ?: 'UTC';
        $dateFormat = $this->option('date_format') ?: 'Y-m-d';
        $platformFee = (float) ($this->option('platform_fee') ?: 0);

        $existing = ThemeSetting::where('key', 'backend_general')->first();
        $content = $existing && is_array($existing->content) ? $existing->content : [];

        $content['app_name'] = $appName;
        $content['contact_email'] = $contactEmail;
        $content['max_devices_per_user'] = $maxDevices;
        $content['currency'] = $currency;
        $content['time_zone'] = $timeZone;
        $content['date_format'] = $dateFormat;
        $content['platform_fee'] = $platformFee;

        ThemeSetting::updateOrCreate(
            ['key' => 'backend_general'],
            ['content' => $content]
        );

        if (function_exists('refresh_options')) {
            refresh_options();
        }

        $this->info('Backend settings updated successfully.');
        $this->table(
            ['Setting', 'Value'],
            [
                ['Application Name', $appName],
                ['Contact Email', $contactEmail],
                ['Max devices per user', (string) $maxDevices],
                ['Currency', $currency],
                ['Time Zone', $timeZone],
                ['Date Format', $dateFormat],
                ['Platform Fee', (string) $platformFee],
            ]
        );

        return self::SUCCESS;
    }
}
