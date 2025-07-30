<?php

namespace App\DataTables;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KecamatanDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('#', function ($item) {
            $editRoute = route('kecamatan.update', $item->uuid);
            $deleteRoute = route('kecamatan.destroy', $item->uuid);
            $actionButton = "<div class='dropdown'>
                                <button class='btn' data-bs-toggle='dropdown'>
                                    <i class='fa fa-pencil'></i>
                                    Edit
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-name='{$item->name}' data-code='{$item->code}' data-kabupaten_id='{$item->kabupaten_id}'>
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
            return $item->kabupaten->provinsi->code . $item->kabupaten->code . $item->code;
        })
        ->rawColumns(['full_code', '#']);
    }

    public function query(Kecamatan $model): QueryBuilder
    {
        $query = $model->with([
            'kabupaten',
            'kabupaten.provinsi',
            ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kecamatan-table')
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
                    ->sortable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::make('name')->title('Name'),
            Column::make('code')->title('Code'),
            Column::make('full_code')->title('Full Code')
                    ->sortable(false)
                    ->searchable(true),
            Column::make('kabupaten.name')->title('Kabupaten/Kota')->sortable(false),
            Column::make('kabupaten.provinsi.name')->title('Provinsi')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Kecamatan_' . date('YmdHis');
    }
}
