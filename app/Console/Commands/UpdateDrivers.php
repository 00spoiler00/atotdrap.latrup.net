<?php

namespace App\Console\Commands;

use App\Models\ClubMember;
use App\Models\Driver;
use App\Models\Metric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class UpdateDrivers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-drivers';

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

        ClubMember::all()->each(function (ClubMember $member) {
            // Get the data from the remote api
            $data = Http::get("https://api.pitskill.io/api/pitskill/getdriverinfo?id={$member->piskill_id}")->json();

            if (! $data || $data['status'] !== 1) {
                return;
            }

            $pitrep   = $data['payload']['tpc_driver_data']['currentPitRep'];
            $pitskill = $data['payload']['tpc_driver_data']['currentPitSkill'];

            // UpdateOrCreate the driver
            $driver = Driver::updateOrCreate(
                ['club_member_id' => $member->id],
                [
                    'discord_uid' => $data['payload']['sigma_user_data']['discord_uid'],
                    'short_name'  => $data['payload']['sigma_user_data']['profile_data']['shortname'],
                    'first_name'  => $data['payload']['sigma_user_data']['profile_data']['first_name'],
                    'last_name'   => $data['payload']['sigma_user_data']['profile_data']['last_name'],
                    'nickname'    => $data['payload']['sigma_user_data']['profile_data']['nickname'],
                    'avatar_url'  => $data['payload']['sigma_user_data']['profile_data']['avatar_url'],
                    'pitrep'      => $pitrep,
                    'pitskill'    => $pitskill,
                ]
            );

            // Get last pitrep and pitskill values from metrics table and if they are different from the current values, insert a new record
            $lastPitrep = $driver
                ->metrics()
                ->where('type', 'pitrep')
                ->orderBy('measured_at', 'desc')
                ->first();

            if (!$lastPitrep || $lastPitrep->value !== $pitrep) {
                Metric::create([
                    'driver_id'   => $driver->id,
                    'type'        => 'pitrep',
                    'value'       => $pitrep,
                    'measured_at' => now(),
                ]);
            }

            $lastPiSkill = $driver
                ->metrics()
                ->where('type', 'pitskill')
                ->orderBy('measured_at', 'desc')
                ->first();

            if (!$lastPiSkill || $lastPiSkill->value !== $pitskill) {
                Metric::create([
                    'driver_id'   => $driver->id,
                    'type'        => 'pitskill',
                    'value'       => $pitskill,
                    'measured_at' => now(),
                ]);
            }
        });
    }
}
