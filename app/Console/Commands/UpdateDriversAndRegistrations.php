<?php

namespace App\Console\Commands;

use App\Actions\UpdateDriverLfmRegistration;
use App\Actions\UpdateDriverPitskillRegistration;
use App\Models\ClubMember;
use App\Models\Driver;
use App\Models\Metric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateDriversAndRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-drivers-and-registrations {--platform=all : The platform to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the driver data from the remote api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Updating drivers data from the remote api');

        // If the platform is not 'all' or is not 'pitskill', then skip the pitskill update
        if ($this->option('platform') === 'all' || $this->option('platform') === 'pitskill') {
            ClubMember::query()
                ->whereNotNull('pitskill_id')
                ->get()
                ->each(fn (ClubMember $member) => $this->processViaPitskill($member));
        }

        // If the platform is not 'all' or is not 'lfm', then skip the pitskill update
        if ($this->option('platform') === 'all' || $this->option('platform') === 'lfm') {
            ClubMember::query()
                ->whereNotNull('lfm_id')
                ->get()
                ->each(fn (ClubMember $member) => $this->processViaLfm($member));
        }
    }

    /**
     * Process the driver data via the PitSkill API.
     *
     * @param ClubMember $clubMember
     */
    protected function processViaPitskill(ClubMember $clubMember): void
    {
        $data = Http::get("https://api.pitskill.io/api/pitskill/getdriverinfo?id={$clubMember->pitskill_id}")->json();

        if (! $data || $data['status'] !== 1) {
            return;
        }

        $driver = Driver::updateOrCreate(
            ['club_member_id' => $clubMember->id],
            [
                'discord_uid' => $data['payload']['sigma_user_data']['discord_uid'],
                'short_name'  => $data['payload']['sigma_user_data']['profile_data']['shortname'],
                'first_name'  => $data['payload']['sigma_user_data']['profile_data']['first_name'],
                'last_name'   => $data['payload']['sigma_user_data']['profile_data']['last_name'],
                'nickname'    => $data['payload']['sigma_user_data']['profile_data']['nickname'],
                'avatar_url'  => $data['payload']['sigma_user_data']['profile_data']['avatar_url'],
                'pitrep'      => $data['payload']['tpc_driver_data']['currentPitRep'],
                'pitskill'    => $data['payload']['tpc_driver_data']['currentPitSkill'],
            ]
        );

        $this->updateMetric($driver, 'pitrep', $data['payload']['tpc_driver_data']['currentPitRep']);
        $this->updateMetric($driver, 'pitskill', $data['payload']['tpc_driver_data']['currentPitSkill']);

        // Get the data from the remote api for registrations
        $data = Http::get("https://api.pitskill.io/api/events/upcomingRegistrations?id={$clubMember->pitskill_id}")->json();

        if (! $data || $data['status'] !== 1) {
            return;
        }

        UpdateDriverPitskillRegistration::execute($driver, $data);
    }

    protected function processViaLfm(ClubMember $clubMember): void
    {
        $data = Http::get("https://api.lowfuelmotorsport.de/api/licenseWidgetUserData/{$clubMember->lfm_id}")->json();

        $driver = Driver::updateOrCreate(
            ['club_member_id' => $clubMember->id],
            [
                'elo'            => $data['user']['cc_rating'],
                'sr'             => $data['user']['safety_rating'],
                'lfm_license'    => $data['user']['license'],
                'lfm_sr_license' => $data['user']['sr_license'],
                'lfm_division'   => $data['user']['division'],
                // Other data exists in the response, but we're not using it here
            ]
        );

        $this->updateMetric($driver, 'elo', $data['user']['cc_rating']);
        $this->updateMetric($driver, 'sr', $data['user']['safety_rating']);

        if (count($data['race'])) {
            UpdateDriverLfmRegistration::execute($driver, $data['race']);
        }
    }

    /**
     * Update the metric for a driver if the value has changed.
     *
     * @param Driver $driver
     * @param string $type
     * @param float  $value
     */
    protected function updateMetric(Driver $driver, string $type, float $value): void
    {
        $lastMetric = $driver
            ->metrics()
            ->where('type', $type)
            ->orderBy('measured_at', 'desc')
            ->first();

        if (! $lastMetric || round($lastMetric->value, 2) !== round($value, 2)) {
            Log::info("Inserting new {$type} metric", ['driver' => $driver->id, 'value' => $value]);
            Metric::create([
                'driver_id'   => $driver->id,
                'type'        => $type,
                'value'       => $value,
                'measured_at' => now(),
            ]);
        }
    }
}
