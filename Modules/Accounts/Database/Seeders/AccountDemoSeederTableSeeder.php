<?php

namespace Modules\Accounts\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;
use Modules\Accounts\Entities\AccountIndustry;
use Modules\Accounts\Entities\AccountRating;
use Modules\Accounts\Entities\AccountType;
use Modules\Platform\Core\Helper\SeederHelper;
use Modules\Platform\Settings\Entities\Country;
use Modules\Platform\User\Entities\User;

class AccountDemoSeederTableSeeder extends SeederHelper

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Account::truncate();

        \Auth::attempt(['email' => config('bap.demo_company_1'), 'password' => config('bap.demo_company_pass_1')]);

        for ($i = 1; $i <= 20; $i++) {
            $faker = Factory::create();

            $account = new Account();
            $account->id = $i;

            $account->name = $faker->company;
            $account->website = $faker->domainName;
            $account->annual_revenue = rand(100000, 2000000);
            $account->tax_number = rand(20000000, 90000000);
            $account->company_id = 1;

            $account->account_type_id  = AccountType::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $account->account_industry_id =  AccountIndustry::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $account->account_rating_id  = AccountRating::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;

            $account->phone = $faker->phoneNumber;
            $account->email = $faker->safeEmail;
            $account->street = $faker->streetAddress;
            $account->city = $faker->city;

            $account->country_id = Country::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $account->zip_code = $faker->postcode;
            $account->notes = $faker->sentence();

            $account->changeOwnerTo(\Auth::user());
            $account->company_id = $this->firstCompany();

            $account->save();
        }

        \Auth::attempt(['email' => config('bap.demo_company_2'), 'password' => config('bap.demo_company_pass_2')]);

        for ($i = 21; $i <= 40; $i++) {
            $faker = Factory::create();

            $account = new Account();
            $account->id = $i;

            $account->name = $faker->company;
            $account->website = $faker->domainName;
            $account->annual_revenue = rand(100000, 2000000);
            $account->tax_number = rand(20000000, 90000000);
            $account->company_id = 2;

            $account->account_type_id  = AccountType::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $account->account_industry_id =  AccountIndustry::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $account->account_rating_id  = AccountRating::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;

            $account->phone = $faker->phoneNumber;
            $account->email = $faker->safeEmail;
            $account->street = $faker->streetAddress;
            $account->city = $faker->city;

            $account->country_id = Country::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $account->zip_code = $faker->postcode;
            $account->notes = $faker->sentence();

            $account->changeOwnerTo(\Auth::user());
            $account->company_id = $this->secondCompany();

            $account->save();
        }
    }
}
