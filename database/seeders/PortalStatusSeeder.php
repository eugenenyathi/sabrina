<?php

namespace Database\Seeders;

use App\Constants\PortalStatusConstants;
use App\Models\PortalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PortalStatusConstants::PORTAL_STATE as $portalState) {
            PortalStatus::create([
                'status' => $portalState,
                'active' => $portalState == PortalStatusConstants::FEED ? PortalStatusConstants::ACTIVE : PortalStatusConstants::INACTIVE,
            ]);
        }
    }
}
