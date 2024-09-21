<?php

namespace Database\Seeders;

use App\Enums\BatchRuleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name' => 'HMO A', 'code' => 'HMO-A', 'email' => 'email_hmo_a@mailinator.com', 'batch_rule' => BatchRuleEnum::ENCOUNTER_DATE->value],
        ['name' => 'HMO B', 'code' => 'HMO-B', 'email' => 'email_hmo_b@mailinator.com', 'batch_rule' => BatchRuleEnum::SUBMISSION_DATE->value],
        ['name' => 'HMO C', 'code' => 'HMO-C', 'email' => 'email_hmo_c@mailinator.com', 'batch_rule' => BatchRuleEnum::SUBMISSION_DATE->value],
        ['name' => 'HMO D', 'code' => 'HMO-D', 'email' => 'email_hmo_d@mailinator.com', 'batch_rule' => BatchRuleEnum::SUBMISSION_DATE->value],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hmos')->insert($this->hmos);
    }
}
