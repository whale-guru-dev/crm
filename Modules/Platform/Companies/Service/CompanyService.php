<?php

namespace Modules\Platform\Companies\Service;

use Illuminate\Support\Facades\Cache;
use Modules\Platform\Companies\Entities\Company;
use Modules\Platform\Companies\Repositories\CompanyRepository;

use Modules\Accounts\Database\Seeders\AccountsDatabaseSeeder;
use Modules\Assets\Database\Seeders\AssetsDatabaseSeeder;
use Modules\Calendar\Database\Seeders\CalendarDatabaseSeeder;
use Modules\Calls\Database\Seeders\CallsDatabaseSeeder;
use Modules\Campaigns\Database\Seeders\CampaignsDatabaseSeeder;
use Modules\ContactRequests\Database\Seeders\ContactRequestsDatabaseSeeder;
use Modules\Contacts\Database\Seeders\ContactsDatabaseSeeder;
use Modules\Deals\Database\Seeders\DealsDatabaseSeeder;
use Modules\Documents\Database\Seeders\DocumentsDatabaseSeeder;
use Modules\Invoices\Database\Seeders\InvoicesDatabaseSeeder;
use Modules\Leads\Database\Seeders\LeadsDatabaseSeeder;
use Modules\Orders\Database\Seeders\OrdersDatabaseSeeder;
use Modules\Payments\Database\Seeders\PaymentsDatatableSeeder;
use Modules\Platform\Settings\Database\Seeders\CountrySeeder;
use Modules\Platform\Settings\Database\Seeders\CurrencySeeder;
use Modules\Platform\Settings\Database\Seeders\PermissionsSeeder;
use Modules\Platform\Settings\Database\Seeders\TaxSeeder;
use Modules\Products\Database\Seeders\ProductsDatabaseSeeder;
use Modules\Quotes\Database\Seeders\QuotesDatabaseSeeder;
use Modules\ServiceContracts\Database\Seeders\ServiceContractsDatabaseSeeder;
use Modules\Tickets\Database\Seeders\TicketsDatabaseSeeder;

/**
 * Class CompanyService
 * @package Modules\Platform\Companies\Service
 */
class CompanyService
{

    private $companyRepo;

    const COMPANY_CONTEXT_SESSION = 'sessCompanyContext';

    public function __construct(CompanyRepository $repository)
    {
        $this->companyRepo = $repository;
    }

    /**
     * Seed company with default dictionary data
     * @param Company $company
     */
    public function seedCompany(Company $company){

        // Seed with default dictionary data

        //Roles & Permission
        $permissionSeeder = new PermissionsSeeder();
        $permissionSeeder->dictionary($company->id);

        //Country
        $countrySeeder = new CountrySeeder();
        $countrySeeder->dictionary($company->id);

        //Currency
        $currencySeeder = new CurrencySeeder();
        $currencySeeder->dictionary($company->id);

        //Tax
        $taxSeeder = new TaxSeeder();
        $taxSeeder->dictionary($company->id);

        //Accounts
        $accountSeeder = new AccountsDatabaseSeeder();
        $accountSeeder->dictionary($company->id);

        //Assets
        $assetSeeder = new AssetsDatabaseSeeder();
        $assetSeeder->dictionary($company->id);

        //Calendar
        $calendarSeeder = new CalendarDatabaseSeeder();
        $calendarSeeder->dictionary($company->id);

        //Calls

        //Campaings
        $campaignSeeder = new CampaignsDatabaseSeeder();
        $campaignSeeder->dictionary($company->id);

        //Contacts
        $contactsSeeder = new ContactsDatabaseSeeder();
        $contactsSeeder->dictionary($company->id);

        //Deals
        $dealsSeeder = new DealsDatabaseSeeder();
        $dealsSeeder->dictionary($company->id);

        //Documents
        $documentsSeeder = new DocumentsDatabaseSeeder();
        $documentsSeeder->dictionary($company->id);

        //Invoices
        $invoicesSeeder = new InvoicesDatabaseSeeder();
        $invoicesSeeder->dictionary($company->id);

        //Leads
        $leadsSeeder = new LeadsDatabaseSeeder();
        $leadsSeeder->dictionary($company->id);

        //Orders
        $ordersSeeder = new OrdersDatabaseSeeder();
        $ordersSeeder->dictionary($company->id);

        //Payments
        $paymentSeeder = new PaymentsDatatableSeeder();
        $paymentSeeder->dictionary($company->id);

        //Products
        $productsSeeder = new ProductsDatabaseSeeder();
        $productsSeeder->dictionary($company->id);

        //Quotes
        $quoteSeeder = new QuotesDatabaseSeeder();
        $quoteSeeder->dictionary($company->id);

        //Service Contracts
        $serviceContractSeeder = new ServiceContractsDatabaseSeeder();
        $serviceContractSeeder->dictionary($company->id);

        //Tickets
        $ticketsSeeder = new TicketsDatabaseSeeder();
        $ticketsSeeder->dictionary($company->id);

        //Contact Request
        $contactRequestSeeder = new ContactRequestsDatabaseSeeder();
        $contactRequestSeeder->dictionary($company->id);

        //Calls
        $callsSeeder = new CallsDatabaseSeeder();
        $callsSeeder->dictionary($company->id);

    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {

        $companies = Cache::remember('all_companies',2,function (){

            return Company::orderBy('name', 'asc')->where('is_enabled', true)->get();

        });

        return $companies;
    }

    /**
     * Add Company Id to session
     * @param $id
     * @return null
     */
    public function switchContext($id)
    {

        $company = $this->companyRepo->findWithoutFail($id);

        if (!empty($company)) {
            session()->put(self::COMPANY_CONTEXT_SESSION, $company);
            return $company;
        }
    }

    /**
     * Remove company from session
     */
    public function dropContext()
    {
        session()->remove(self::COMPANY_CONTEXT_SESSION);
    }

}
