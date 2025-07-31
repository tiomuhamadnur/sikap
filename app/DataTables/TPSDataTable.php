<?php

namespace App\DataTables;

use App\Models\TP;
use App\Models\TPS;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TPSDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('tps.update', $item->uuid);
                $deleteRoute = route('tps.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-name='{$item->name}' data-address='{$item->address}' data-dapil_id='{$item->dapil_id}' data-desa_id='{$item->desa_id}'>
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
            ->rawColumns(['#']);
    }

    public function query(TPS $model): QueryBuilder
    {
        $query = $model->with([
            'dapil',
            'dapil.project.profile',
            'dapil.project.periode',
            'desa',
            'desa.kecamatan',
            'desa.kecamatan.kabupaten',
            'desa.kecamatan.kabupaten.provinsi',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tps-table')
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
            Column::make('name')->title('Nama')->sortable(false),
            Column::make('address')->title('Alamat')->sortable(false),
            Column::make('dapil.project.profile.name')->title('Profil')->sortable(false),
            Column::make('dapil.project.periode.name')->title('Periode')->sortable(false),
            Column::make('dapil.name')->title('Dapil')->sortable(false),
            Column::make('desa.name')->title('Desa')->sortable(false),
            Column::make('desa.kecamatan.name')->title('Kecamatan')->sortable(false),
            Column::make('desa.kecamatan.kabupaten.name')->title('Kabupaten/Kota')->sortable(false),
            Column::make('desa.kecamatan.kabupaten.provinsi.name')->title('Provinsi')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'TPS_' . date('YmdHis');
    }
}
