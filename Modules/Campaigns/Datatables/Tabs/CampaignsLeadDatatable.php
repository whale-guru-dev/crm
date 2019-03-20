<?php

namespace Modules\Campaigns\Datatables\Tabs;

use Modules\Leads\Datatables\LeadsDatatable;
use Modules\Leads\Entities\Lead;
use Modules\Platform\Core\Datatable\RelationDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Core\QueryBuilderParser\QueryBuilderParser;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class CampaignsLeadDatatable
 * @package Modules\Campaigns\Datatables\Tabs
 */
class CampaignsLeadDatatable extends RelationDataTable
{
    const SHOW_URL_ROUTE = 'leads.leads.show';

    protected $unlinkRoute = 'campaigns.leads.unlink';

    protected $editRoute = 'leads.leads.edit';

    protected function setFilterDefinition()
    {
        $this->filterDefinition = LeadsDatatable::availableQueryFilters();
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

        $this->applyLinks($dataTable, self::SHOW_URL_ROUTE,'leads_');

        $dataTable->filterColumn('owner', function ($query, $keyword) {
            DataTableHelper::queryOwner($query, $keyword, 'leads');
        });


        $dataTable->editColumn('email', function ($record) {

            return $record->leadEmails->pluck('email')->transform(function ($item, $key)  use ($record){
                $text = "<span class='badge bg-grey'><i class='fa fa-envelope-o'></i> $item </span>";
                return DataTableHelper::applyLink($text,route(self::SHOW_URL_ROUTE,$record->id));
            })->implode(" ");

        });
        $dataTable->filterColumn('email', function($query,$keyword){

            $query->whereHas('leadEmails', function ($query) use ($keyword) {
                $query->where('email', 'LIKE', "%$keyword%");
            })->get();

        });

        $dataTable->filterColumn('created_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('leads.created_at', array($dates[0], $dates[1]));
            }
        });
        $dataTable->filterColumn('updated_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('leads.updated_at', array($dates[0], $dates[1]));
            }
        });

        $dataTable->filterColumn('capture_date', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('leads.capture_date', array($dates[0], $dates[1]));
            }
        });

        $dataTable->filterColumn('birth_date', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('leads.birth_date', array($dates[0], $dates[1]));
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
    public function query(Lead $model)
    {
        $query = $model->newQuery()
            ->with('owner')
            ->with('leadEmails')
            ->leftJoin('leads_dict_industry', 'leads.lead_industry_id', '=', 'leads_dict_industry.id')
            ->leftJoin('leads_dict_rating', 'leads.lead_rating_id', '=', 'leads_dict_rating.id')
            ->leftJoin('leads_dict_status', 'leads.lead_status_id', '=', 'leads_dict_status.id')
            ->leftJoin('leads_dict_source', 'leads.lead_source_id', '=', 'leads_dict_source.id')
            ->leftJoin('bap_country', 'leads.addr_country_id', '=', 'bap_country.id')
            ->leftJoin('customer_dict_language', 'leads.language_id', '=', 'customer_dict_language.id')
            ->select(
                'leads.*',
                'bap_country.name as addr_country',
                'leads_dict_industry.name as industry',
                'leads_dict_rating.name as rating',
                'leads_dict_status.name as status',
                'leads_dict_source.name as source',
                'customer_dict_language.name as language'
            );

        if (!empty($this->filterRules)) {

            $filterRules = json_decode($this->filterRules);

            foreach ($filterRules->rules as &$rule){
                if($rule->id == 'lead_email.email'){ // filter in multi email
                    $query->leftJoin('lead_email', 'lead_email.lead_id', '=', 'leads.id');
                }
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
            ->setTableId('CampaignLeadDatatable' . $this->tableSuffix)
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

        $columns = LeadsDatatable::availableColumns();

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
