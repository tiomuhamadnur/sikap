<?php

namespace App\DataTables;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProjectDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('project.update', $item->uuid);
                $deleteRoute = route('project.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-url='{$editRoute}'
                                        data-party_id='{$item->party_id}'
                                        data-periode_id='{$item->periode_id}'
                                        data-profile_id='{$item->profile_id}'
                                        data-election_type_id='{$item->election_type_id}'
                                        data-start_date='{$item->start_date}'
                                        data-end_date='{$item->end_date}'
                                        data-expired_date='{$item->expired_date}'
                                        data-about='{$item->about}'>
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

    public function query(Project $model): QueryBuilder
    {
        $query = $model->with([
            'party',
            'periode',
            'profile',
            'election_type',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('project-table')
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
            Column::make('profile.name')->title('Profil')->sortable(false),
            Column::make('party.name')->title('Partai')->sortable(false),
            Column::make('periode.name')->title('Periode')->sortable(false),
            Column::make('election_type.name')->title('Tipe Pemilihan')->sortable(false),
            Column::make('start_date')->title('Tanggal Mulai'),
            Column::make('end_date')->title('Tanggal Selesai'),
            Column::make('expired_date')->title('Tanggal Expired'),
        ];
    }

    protected function filename(): string
    {
        return 'Project_' . date('YmdHis');
    }
}
