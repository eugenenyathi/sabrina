<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\VotesSeeder;
use Database\Seeders\SrcPostSeeder;
use Database\Seeders\PortalStatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(FacultySeeder::class);
        // $this->call(ProgramSeeder::class);

        $this->call(StudentSeeder::class);
        $this->call(ProfileSeeder::class);

        $this->call(UsersSeeder::class);

        $this->call(PortalStatusSeeder::class);
        $this->call(SrcPostSeeder::class);

        $this->call(ApplicantSeeder::class);

        $this->call(CandidateSeeder::class);
        $this->call(CandidateProfileSeeder::class);

        // $this->call(VotesSeeder::class);
    }
}
