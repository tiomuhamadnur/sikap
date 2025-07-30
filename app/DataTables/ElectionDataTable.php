<?php

namespace App\DataTables;

use App\Models\Election;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ElectionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('election.update', $item->uuid);
                $deleteRoute = route('election.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-tps_id='{$item->tps_id}' data-vote='{$item->vote}' data-vote_party='{$item->vote_party}'>
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

    public function query(Election $model): QueryBuilder
    {
        $query = $model->with([
            'tps',
            'tps.desa',
            'tps.desa.kecamatan',
            'tps.desa.kecamatan.kabupaten',
            'tps.dapil',
            'tps.dapil.project.profile',
            'tps.dapil.project.periode',
            'tps.dapil.project.party',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('election-table')
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
            Column::make('tps.dapil.project.profile.name')->title('Profil Kandidat')->sortable(false),
            Column::make('tps.name')->title('TPS')->sortable(false),
            Column::make('tps.desa.name')->title('Desa')->sortable(false),
            Column::make('tps.desa.kecamatan.name')->title('Kecamatan')->sortable(false),
            Column::make('tps.desa.kecamatan.kabupaten.name')->title('Kabupaten')->sortable(false),
            Column::make('tps.dapil.name')->title('Dapil')->sortable(false),
            Column::make('vote')->title('Suara')->sortable(false),
            Column::make('vote_party')->title('Suara Partai')->sortable(false),
            Column::make('tps.dapil.project.periode.name')->title('Periode')->sortable(false),
            Column::make('tps.dapil.project.party.code')->title('Partai')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Election_' . date('YmdHis');
    }
}
