<?php

namespace App\DataTables;

use App\Models\Desa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DesaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('#', function ($item) {
            $editRoute = route('desa.update', $item->uuid);
            $deleteRoute = route('desa.destroy', $item->uuid);
            $actionButton = "<div class='dropdown'>
                                <button class='btn' data-bs-toggle='dropdown'>
                                    <i class='fa fa-pencil'></i>
                                    Edit
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-name='{$item->name}' data-code='{$item->code}' data-type='{$item->type}' data-kecamatan_id='{$item->kecamatan_id}'>
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
            return $item->kecamatan->kabupaten->provinsi->code . $item->kecamatan->kabupaten->code . $item->kecamatan->code . $item->code;
        })
        ->rawColumns(['full_code', '#']);
    }

    public function query(Desa $model): QueryBuilder
    {
        $query = $model->with([
            'kecamatan',
            'kecamatan.kabupaten',
            'kecamatan.kabupaten.provinsi',
            ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('desa-table')
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
            // Column::make('type')->title('Type'),
            Column::make('name')->title('Name'),
            Column::make('code')->title('Code'),
            Column::make('full_code')->title('Full Code'),
            Column::make('kecamatan.name')->title('Kecamatan'),
            Column::make('kecamatan.kabupaten.name')->title('Kabupaten/Kota'),
            Column::make('kecamatan.kabupaten.provinsi.name')->title('Provinsi'),
        ];
    }

    protected function filename(): string
    {
        return 'Desa&Kelurahan_' . date('YmdHis');
    }
}
