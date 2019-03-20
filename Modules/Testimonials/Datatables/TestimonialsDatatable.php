<?php

namespace Modules\Testimonials\Datatables;

use Modules\Payments\Entities\Payment;
use Modules\Payments\Entities\PaymentCategory;
use Modules\Payments\Entities\PaymentPaymentMethod;
use Modules\Payments\Entities\PaymentStatus;
use Modules\Platform\Core\Datatable\PlatformDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Core\QueryBuilderParser\QueryBuilderParser;
use Modules\Platform\Settings\Entities\Currency;
use Modules\Products\Entities\Product;
use Modules\Testimonials\Entities\Testimonial;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class TestimonialsDatatable
 * @package Modules\Payments\Datatables
 */
class TestimonialsDatatable extends PlatformDataTable
{
    const SHOW_URL_ROUTE = 'testimonials.testimonials.show';

    protected $editRoute = 'testimonials.testimonials.edit';


    public static function availableColumns()
    {
        return [
            'contact_name' => [
                'data' => 'contact_name',
                'title' => trans('testimonials::testimonials.form.contact_id'),
                'data_type' => 'text',
                'filter_type' => 'text'
            ],
            'product_name' => [
                'data' => 'product_name',
                'title' => trans('testimonials::testimonials.form.product_id'),
                'data_type' => 'text',
                'filter_type' => 'text'
            ],
            'comment' => [
                'data' => 'comment',
                'title' => trans('testimonials::testimonials.form.comment'),
                'data_type' => 'text',
                'filter_type' => 'text'
            ],

            'created_at' => [
                'data' => 'created_at',
                'title' => trans('core::core.table.created_at'),
                'data_type' => 'datetime',
                'filter_type' => 'bap_date_range_picker',
            ],
            'updated_at' => [
                'data' => 'updated_at',
                'title' => trans('core::core.table.updated_at'),
                'data_type' => 'datetime',
                'filter_type' => 'bap_date_range_picker',
            ],

        ];
    }

    public static function availableQueryFilters()
    {
        return [
            [
                'id' => 'testimonials.comment',
                'label' => trans('testimonials::testimonials.form.comment'),
                'type' => 'string',
            ],
            [
                'id' => 'contacts.full_name',
                'label' => trans('testimonials::testimonials.form.contact_id'),
                'type' => 'string',
            ],
            [
                'id' => 'testimonials.product_id',

                'label' => trans('testimonials::testimonials.form.product_id'),
                'type' => 'integer',
                'input' => 'select',
                'multiple' => true,
                'plugin' => 'select2',
                'plugin_config' => [
                    'multiple' => 'multiple',
                    'width' => '300px',
                ],
                'values' => Product::pluck('name', 'id'),
                'operators' => [
                    'in',
                    'not_in',
                    'is_null',
                    'is_not_null'
                ],
            ],
            [
                'id' => 'testimonials.created_at',
                'label' => trans('core::core.table.created_at'),
                'type' => 'date',
                'input_event' => 'dp.change',
                'plugin' => 'datetimepicker',
                'plugin_config' => [
                    'locale' => app()->getLocale(),
                    'calendarWeeks' => true,
                    'showClear' => true,
                    'showTodayButton' => true,
                    'showClose' => true,
                    'format' => \Modules\Platform\Core\Helper\UserHelper::userJsDateFormat()
                ]
            ],
            [
                'id' => 'testimonials.updated_at',
                'label' => trans('core::core.table.updated_at'),
                'type' => 'date',
                'input_event' => 'dp.change',
                'plugin' => 'datetimepicker',
                'plugin_config' => [
                    'locale' => app()->getLocale(),
                    'calendarWeeks' => true,
                    'showClear' => true,
                    'showTodayButton' => true,
                    'showClose' => true,
                    'format' => \Modules\Platform\Core\Helper\UserHelper::userJsDateFormat()
                ]
            ]
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


        $this->applyLinks($dataTable, self::SHOW_URL_ROUTE);

        $dataTable->filterColumn('created_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('testimonials.created_at', array($dates[0], $dates[1]));
            }
        });
        $dataTable->filterColumn('updated_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('testimonials.updated_at', array($dates[0], $dates[1]));
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
    public function query(Testimonial $model)
    {
        $query = $model->newQuery()
            ->leftJoin('contacts', 'testimonials.contact_id', '=', 'contacts.id')
            ->leftJoin('products', 'testimonials.product_id', '=', 'products.id')
            ->select(
                'testimonials.*',
                'contacts.full_name as contact_name',
                'products.name as product_name'
            );

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
            ->columns($this->getColumns())
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
        if(!empty($this->advancedView)){
            return $this->advancedView;
        }

        $columns =  self::availableColumns();


        $result = [];

        if ($this->allowSelect) {
            $result =  $this->btnCheck_selection;
        }
        if ($this->allowUnlink) {
            $result =  $this->btnUnlink ;
        }
        if ($this->allowQuickEdit) {
            $result =  $result + $this->btnQuick_edit; ;
        }

        $result = $result + $columns;

        return $result;
    }
}
