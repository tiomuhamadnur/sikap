<?php

namespace App\DataTables;

use App\Models\Kabupaten;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KabupatenDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('#', function ($item) {
            $editRoute = route('kabupaten.update', $item->uuid);
            $deleteRoute = route('kabupaten.destroy', $item->uuid);
            $actionButton = "<div class='dropdown'>
                                <button class='btn' data-bs-toggle='dropdown'>
                                    <i class='fa fa-pencil'></i>
                                    Edit
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-name='{$item->name}' data-code='{$item->code}' data-type='{$item->type}' data-provinsi_id='{$item->provinsi_id}'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </a>
                                    <a class='dropdown-item text-danger' href='#' data-bs-toggle='modal' data-bs-target='#deleteModal' data-url='{$deleteRoute}'>
                                        <i class='fa fa-trash-can'></i>
                                        Delete
                                    </a>
                                </div>
                            </div>";

            return $actionButton;
        })
        ->addColumn('full_code', function($item) {
            return $item->provinsi->code . $item->code;
        })
        ->rawColumns(['#', 'full_code']);
    }

    public function query(Kabupaten $model): QueryBuilder
    {
        $query = $model->with([
            'provinsi',
            ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kabupaten-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    //->dom('Bfrtip')
                    ->orderBy([0, 'asc'])
                    ->selectStyleSingle()
                    ->buttons([
                        [
                            'extend' => 'excel',
                            'text' => 'Export to Excel',
                            'attr' => [
                                'id' => 'datatable-excel',
                                'style' => 'display: none;',
                            ],
                        ],
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('#')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::make('type')->title('Type'),
            Column::make('name')->title('Name'),
            Column::make('code')->title('Code'),
            Column::make('full_code')->title('Full Code'),
            Column::make('provinsi.name')->title('Provinsi'),
        ];
    }

    protected function filename(): string
    {
        return 'Kabupaten&Kota_' . date('YmdHis');
    }
}
