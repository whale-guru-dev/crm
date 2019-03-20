<?php

namespace Modules\Accounts\Datatables\Tabs;

use Modules\Contacts\Datatables\ContactDatatable;
use Modules\Contacts\Entities\Contact;
use Modules\Contacts\Entities\ContactStatus;
use Modules\Platform\Core\Datatable\RelationDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\Platform\Core\QueryBuilderParser\QueryBuilderParser;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class CampaignsContactsDatatable
 * @package Modules\Campaigns\Datatables\Tabs
 */
class AccountsContactsDatatable extends RelationDataTable
{
    const SHOW_URL_ROUTE = 'contacts.contacts.show';

    protected $unlinkRoute = 'accounts.contacts.unlink';

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
            return DataTableHelper::applyLink($text, route(self::SHOW_URL_ROUTE, $record->id));
        });

        $dataTable->editColumn('phone', function ($record) {
            $text = "<span class='badge bg-grey'><i class='fa fa-mobile-phone'></i> $record->phone</span>";
            return DataTableHelper::applyLink($text, route(self::SHOW_URL_ROUTE, $record->id));
        });
        $dataTable->editColumn('email', function ($record) {
            $text = "<span class='badge bg-grey'><i class='fa fa-envelope-o'></i> $record->email</span>";
            return DataTableHelper::applyLink($text, route(self::SHOW_URL_ROUTE, $record->id));
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
            $queryBuilderParser = new  QueryBuilderParser();
            $queryBuilder = $queryBuilderParser->parse($this->filterRules, $query);

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
            ->setTableId('AccountsContactsDatatable' . $this->tableSuffix)
            ->columns($this->getColumns())
            ->minifiedAjax(route($this->route, ['entityId' => $this->entityId]))
            ->setTableAttribute('class', 'table table-hover')
            ->parameters([
                'dom' => 'lBfrtip',
                'responsive' => false,
                'stateSave' => true,
                'filterDefinitions' => $this->getFilterDefinition(),
                'filterRules' => $this->filterRules,
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
            $result = $this->btnCheck_selection;
        }
        if ($this->allowUnlink) {
            $result = $this->btnUnlink;
        }
        if ($this->allowUnlink) {
            $result = $result + $this->btnQuick_edit;;
        }

        $result = $result + $columns;

        return $result;
    }
}
