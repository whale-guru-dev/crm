<?php

namespace Modules\ServiceContracts\Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Platform\Core\Helper\SeederHelper;
use Modules\ServiceContracts\Entities\ServiceContract;
use Modules\ServiceContracts\Entities\ServiceContractPriority;
use Modules\ServiceContracts\Entities\ServiceContractStatus;

class ServiceContractDemoSeederTableSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        ServiceContract::truncate();

        \Auth::attempt(['email' => config('bap.demo_company_1'), 'password' => config('bap.demo_company_pass_1')]);

        for ($i = 1; $i <= 50; $i++) {
            $faker = Factory::create();

            $serviceContract = new ServiceContract();
            $serviceContract->id = $i;
            $serviceContract->changeOwnerTo(\Auth::user());

            $serviceContract->name = 'SC for ' . $faker->company;

            $serviceContract->start_date = $faker->dateTimeBetween(Carbon::now()->subMonth(4), Carbon::now()->addMonth(2))->format('Y-m-d H:i:s');
            $serviceContract->due_date = $faker->dateTimeBetween(Carbon::now()->subMonth(3), Carbon::now()->addMonth(2))->format('Y-m-d H:i:s');

            $serviceContract->service_contract_priority_id = ServiceContractPriority::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;;
            $serviceContract->service_contract_status_id = ServiceContractStatus::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;;

            $serviceContract->notes = $faker->sentence();

            $serviceContract->account_id = rand(1, 20);

            $serviceContract->company_id = $this->firstCompany();

            $serviceContract->save();
        }

        \Auth::attempt(['email' => config('bap.demo_company_2'), 'password' => config('bap.demo_company_pass_2')]);

        for ($i = 51; $i <= 100; $i++) {
            $faker = Factory::create();

            $serviceContract = new ServiceContract();
            $serviceContract->id = $i;
            $serviceContract->changeOwnerTo(\Auth::user());

            $serviceContract->name = 'SC for ' . $faker->company;

            $serviceContract->start_date = $faker->dateTimeBetween(Carbon::now()->subMonth(4), Carbon::now()->addMonth(2))->format('Y-m-d H:i:s');
            $serviceContract->due_date = $faker->dateTimeBetween(Carbon::now()->subMonth(3), Carbon::now()->addMonth(2))->format('Y-m-d H:i:s');

            $serviceContract->service_contract_priority_id = ServiceContractPriority::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;;
            $serviceContract->service_contract_status_id = ServiceContractStatus::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;;

            $serviceContract->notes = $faker->sentence();

            $serviceContract->account_id = rand(21, 40);

            $serviceContract->company_id = $this->secondCompany();

            $serviceContract->save();
        }
    }
}
