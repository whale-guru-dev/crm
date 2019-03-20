<?php

namespace Modules\Campaigns\Datatables\Tabs;

use Modules\Contacts\Datatables\ContactDatatable;
use Modules\Contacts\Entities\Contact;
use Modules\Contacts\Entities\ContactStatus;
use Modules\Leads\Entities\Lead;
use Modules\Platform\Core\Datatable\RelationDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\Platform\Core\QueryBuilderParser\QueryBuilderParser;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class CampaignsContactsDatatable
 * @package Modules\Campaigns\Datatables\Tabs
 */
class CampaignsContactsDatatable extends RelationDataTable
{
    const SHOW_URL_ROUTE = 'contacts.contacts.show';

    protected $unlinkRoute = 'campaigns.contacts.unlink';

    protected $editRoute = 'contacts.contacts.edit';

    public static function availableColumns()
    {
        return ContactDatatable::availableColumns();
    }

    public static function availableQueryFilters()
    {
        return ContactDatatable::availableQueryFilters();
    }

    protected function setFilterDefinition()
    {
        $this->filterDefinition = self::availableQueryFilters();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);


        $this->applyLinks($dataTable, self::SHOW_URL_ROUTE,'contacts_');

        $dataTable->editColumn('status', function ($record) {
            $text = "<span class='badge badge-default $record->status_color'>$record->status</span>";
            return DataTableHelper::applyLink($text,route(self::SHOW_URL_ROUTE,$record->id));
        });

        $dataTable->editColumn('phone', function ($record) {
            $text = "<span class='badge bg-grey'><i class='fa fa-mobile-phone'></i> $record->phone </span>";
            return DataTableHelper::applyLink($text,route(self::SHOW_URL_ROUTE,$record->id));
        });
        $dataTable->editColumn('email', function ($record) {

            return $record->contactEmails->pluck('email')->transform(function ($item, $key) use ($record) {
                $text = "<span class='badge bg-grey'><i class='fa fa-envelope-o'></i> $item </span>";
                return DataTableHelper::applyLink($text,route(self::SHOW_URL_ROUTE,$record->id));

            })->implode(" ");

        });

        $dataTable->filterColumn('email', function($query,$keyword){

            $query->whereHas('contactEmails', function ($query) use ($keyword) {
                $query->where('email', 'LIKE', "%$keyword%");
            })->get();

        });

        $dataTable->filterColumn('owner', function ($query, $keyword) {
            DataTableHelper::queryOwner($query, $keyword, 'contacts');
        });



        $dataTable->filterColumn('created_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('contacts.created_at', array($dates[0], $dates[1]));
            }
        });
        $dataTable->filterColumn('updated_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('contacts.updated_at', array($dates[0], $dates[1]));
            }
        });

        $dataTable->filterColumn('birth_date', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('contacts.birth_date', array($dates[0], $dates[1]));
            }
        });


        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contact $model)
    {
        $query = $model->newQuery()
            ->with('owner')
            ->with('contactEmails')
            ->leftJoin('contacts_dict_status', 'contacts.contact_status_id', '=', 'contacts_dict_status.id')
            ->leftJoin('contacts_dict_source', 'contacts.contact_source_id', '=', 'contacts_dict_source.id')
            ->leftJoin('customer_dict_language', 'contacts.language_id', '=', 'customer_dict_language.id')
            ->leftJoin('bap_country', 'contacts.country_id', '=', 'bap_country.id')
            ->leftJoin('accounts', 'contacts.account_id', '=', 'accounts.id')
            ->select([
                'contacts.*',
                'bap_country.name as country',
                'contacts_dict_status.id as status_id',
                'contacts_dict_status.name as status',
                'contacts_dict_status.color as status_color',
                'contacts_dict_source.id as source_id',
                'contacts_dict_source.name as source',
                'customer_dict_language.name as language',
                'accounts.name as account_name',
            ]);

        if (!empty($this->filterRules)) {

            // Custom implementation for People Who Bought X Product
            $filterRules = json_decode($this->filterRules);

            $productIds = null;
            $priceListIds = null;

            foreach ($filterRules->rules as &$rule){
                if($rule->id == 'people_who_bought'){
                    $productIds = $rule->value;
                }
                if($rule->id == 'people_who_bought_product_pricing'){
                    $priceListIds = $rule->value;
                }
                if($rule->id == 'contact_email.email'){ // filter in multi email
                    $query->leftJoin('contact_email', 'contact_email.contact_id', '=', 'contacts.id');
                }

            }

            if(!empty($productIds)) {
                $query->with('invoices.rows')->whereHas('invoices.rows', function ($q) use ($productIds){
                    $q->whereIn('product_id',$productIds);
                });
            }

            if(!empty($priceListIds)) {
                $query->with('invoices.rows')->whereHas('invoices.rows', function ($q) use ($priceListIds){
                    $q->whereIn('price_list_id',$priceListIds);
                });
            }

            $filterRules = json_encode($filterRules);

            $queryBuilderParser = new  QueryBuilderParser();

            $queryBuilder = $queryBuilderParser->parse($filterRules, $query);

            return $queryBuilder;
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('CampaignContactsDatatable' . $this->tableSuffix)
            ->columns($this->getColumns())
            ->minifiedAjax(route($this->route, ['entityId' => $this->entityId]))
            ->setTableAttribute('class', 'table table-hover')
            ->parameters([
                'dom' => 'lBfrtip',
                'responsive' => false,
                'stateSave' => true,
                'filterDefinitions' => $this->getFilterDefinition(),
                'headerFilters' => true,
                'buttons' => DataTableHelper::buttons(),
                'regexp' => true

            ]);
    }

    /**
     * @return array
     */
    protected function getColumns()
    {

        $columns = ContactDatatable::availableColumns();

        $result = [];

        if ($this->allowSelect) {
            $result =  $this->btnCheck_selection;
        }
        if ($this->allowUnlink) {
            $result =  $this->btnUnlink ;
        }
        if ($this->allowUnlink) {
            $result =  $result + $this->btnQuick_edit; ;
        }

        $result = $result + $columns;

        return $result;
    }
}
