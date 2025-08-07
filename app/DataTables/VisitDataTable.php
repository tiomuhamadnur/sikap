<?php

namespace App\DataTables;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VisitDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('visit.update', $item->uuid);
                $deleteRoute = route('visit.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-url='{$editRoute}'
                                        data-name='{$item->name}'
                                        data-date='{$item->date}'
                                        data-address='{$item->address}'
                                        data-remark='{$item->remark}'
                                        data-visit_type_id='{$item->visit_type_id}'
                                        data-project_id='{$item->project_id}'
                                        data-desa_id='{$item->desa_id}'>
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

    public function query(Visit $model): QueryBuilder
    {
        $query = $model->with([
            'visit_type',
            'project.profile',
            'project.periode',
            'desa.kecamatan.kabupaten',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('visit-table')
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
            Column::make('project.profile.name')->title('Profil')->sortable(false),
            Column::make('visit_type.name')->title('Tipe Kunjungan')->sortable(false),
            Column::make('date')->title('Tanggal')->sortable(true),
            Column::make('name')->title('Hasil Kunjungan')->sortable(false)->addClass('text-wrap'),
            Column::make('remark')->title('Catatan')->sortable(false)->addClass('text-wrap'),
            Column::make('address')->title('Alamat')->sortable(false),
            Column::make('desa.name')->title('Desa')->sortable(false),
            Column::make('desa.kecamatan.name')->title('Kecamatan')->sortable(false),
            Column::make('desa.kecamatan.kabupaten.name')->title('Kabupaten/Kota')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Visit_' . date('YmdHis');
    }
}
