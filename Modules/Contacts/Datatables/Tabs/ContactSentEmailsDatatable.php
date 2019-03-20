<?php

namespace Modules\Contacts\Datatables\Tabs;


use Modules\ContactEmails\Entities\ContactEmail;
use Modules\Platform\Core\Datatable\RelationDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;

use Modules\SentEmails\LaravelDatabaseEmails\Email;
use Yajra\DataTables\EloquentDataTable;

class ContactSentEmailsDatatable extends RelationDataTable
{

    const SHOW_URL_ROUTE = 'sentemails.sentemails.show';

    protected $unlinkRoute = 'contacts.sentemails.unlink';

    protected $deleteRoute = 'contacts.sentemails.delete';

    protected $editRoute = 'sentemails.sentemails.edit';

    protected $showRoute ='sentemails.sentemails.show';

    public static function availableColumns()
    {
        return [
            'recipient' => [
                'data' => 'recipient',
                'title' => trans('sentemails::sentemails.table.recipient'),
                'data_type' => 'text',
                'filter_type' => 'text'
            ],
            'subject' => [
                'data' => 'subject',
                'title' => trans('sentemails::sentemails.table.subject'),
                'data_type' => 'text',
                'filter_type' => 'text'
            ],
            'created_at' => [
                'data' => 'created_at',
                'title' => trans('core::core.table.created_at'),
                'data_type' => 'datetime',
                'filter_type' => 'bap_date_range_picker',
            ],
            'sent_at' => [
                'data' => 'sent_at',
                'title' => trans('sentemails::sentemails.table.sent_at'),
                'data_type' => 'datetime',
                'filter_type' => 'bap_date_range_picker',
            ],
        ];
    }

    public static function availableQueryFilters()
    {
        return [

        ];
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


        $this->applyLinks($dataTable, '', 'contact__sent_emails_');

        $dataTable->filterColumn('created_at', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('emails.created_at', array($dates[0], $dates[1]));
            }
        });


        $dataTable->filterColumn('sent_at', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('emails.sent_at', array($dates[0], $dates[1]));
            }
        });

        $dataTable->filterColumn('updated_at', function ($query, $keyword) {

            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('emails.updated_at', array($dates[0], $dates[1]));
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
    public function query(Email $model)
    {
        return $model->newQuery()->select();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('ContactSentEmailsDatatable' . $this->tableSuffix)
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

        $result =  $this->btnQuick_show  + self::availableColumns();

        return $result;

    }

}
