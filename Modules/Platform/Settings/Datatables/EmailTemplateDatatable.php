<?php

namespace Modules\Platform\Settings\Datatables;

use Modules\Platform\Core\Datatable\PlatformDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Settings\Entities\BapTags;
use Modules\Platform\Settings\Entities\EmailTemplate;
use Spatie\Tags\Tag;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class EmailTemplateDatatable
 * @package Modules\Platform\Settings\Datatables
 */
class EmailTemplateDatatable extends PlatformDataTable
{
    const SHOW_URL_ROUTE = 'settings.email_templates.show';

    protected $editRoute = 'settings.email_templates.edit';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);


        $this->applyLinks($dataTable, self::SHOW_URL_ROUTE);

        $dataTable->filterColumn('created_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('created_at', array($dates[0], $dates[1]));
            }
        });
        $dataTable->filterColumn('updated_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('updated_at', array($dates[0], $dates[1]));
            }
        });

        return $dataTable;
    }

    /**
     *
     * @param Tag $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmailTemplate $model)
    {
        return $model->newQuery()->select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())

            ->setTableAttribute('class', 'table table-hover')
            ->addTableClass($this->additionalTableClass)
            ->parameters([
                'dom' => 'lBfrtip',
                'responsive' => false,
                'stateSave' => true,
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

        if(!$this->relationMode){
            $columns = $this->btnQuick_edit;
        }else{
            $columns = [];
        }
            $rest = [
                'name' => [
                    'data' => 'name',
                    'title' => trans('settings::email_templates.table.name'),
                    'data_type' => 'text',
                    'filter_type' => 'text'
                ],
                'subject' => [
                    'data' => 'subject',
                    'title' => trans('settings::email_templates.table.subject'),
                    'data_type' => 'text',
                    'filter_type' => 'text'
                ],
                'created_at' => [
                    'data' => 'created_at',
                    'title' => trans('settings::email_templates.table.created_at'),
                    'data_type' => 'datetime',
                    'filter_type' => 'bap_date_range_picker',
                ],
                'updated_at' => [
                    'data' => 'updated_at',
                    'title' => trans('settings::email_templates.table.updated_at'),
                    'data_type' => 'datetime',
                    'filter_type' => 'bap_date_range_picker',
                ]
            ];

        return $columns + $rest;
    }
}
