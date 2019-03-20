<?php

namespace Modules\Vendors\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Platform\Core\Helper\SeederHelper;
use Modules\Platform\Settings\Entities\Country;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Entities\VendorCategory;

class VendorDemoSeederTableSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Vendor::truncate();

        \Auth::attempt(['email' => config('bap.demo_company_1'), 'password' => config('bap.demo_company_pass_1')]);


        for ($i = 1; $i <= 20; $i++) {
            $faker = Factory::create();

            $vendor = new Vendor();
            $vendor->id = $i;
            $vendor->changeOwnerTo(\Auth::user());

            $vendor->name = 'Shop '.$faker->company;
            $vendor->phone = $faker->phoneNumber;
            $vendor->mobile = $faker->phoneNumber;
            $vendor->email = $faker->safeEmail;
            $vendor->street = $faker->streetAddress;
            $vendor->country_id = Country::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $vendor->zip_code = $faker->postcode;
            $vendor->city = $faker->city;

            $vendor->vendor_category_id = VendorCategory::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;;
            $vendor->company_id = $this->firstCompany();

            $vendor->save();
        }

        \Auth::attempt(['email' => config('bap.demo_company_2'), 'password' => config('bap.demo_company_pass_2')]);


        for ($i = 21; $i <= 40; $i++) {
            $faker = Factory::create();

            $vendor = new Vendor();
            $vendor->id = $i;
            $vendor->changeOwnerTo(\Auth::user());

            $vendor->name = 'Shop '.$faker->company;
            $vendor->phone = $faker->phoneNumber;
            $vendor->mobile = $faker->phoneNumber;
            $vendor->email = $faker->safeEmail;
            $vendor->street = $faker->streetAddress;
            $vendor->country_id = Country::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $vendor->zip_code = $faker->postcode;
            $vendor->city = $faker->city;

            $vendor->vendor_category_id = VendorCategory::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;;
            $vendor->company_id = $this->secondCompany();

            $vendor->save();
        }
    }
}
