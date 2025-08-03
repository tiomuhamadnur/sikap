<?php

namespace App\DataTables;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IssueDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('issue.update', $item->uuid);
                $deleteRoute = route('issue.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-url='{$editRoute}'
                                        data-name='{$item->name}'
                                        data-remark='{$item->remark}'
                                        data-visit_id='{$item->visit_id}'
                                        data-category_id='{$item->category_id}'
                                        data-status_id='{$item->status_id}'>
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

    public function query(Issue $model): QueryBuilder
    {
        $query = $model->with([
            'visit.visit_type',
            'visit.project.profile',
            'visit.project.periode',
            'visit.desa.kecamatan.kabupaten',
            'category',
            'status',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('issue-table')
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
            Column::make('visit.project.profile.name')->title('Profil')->sortable(false),
            Column::make('visit.visit_type.name')->title('Tipe Kunjungan')->sortable(false),
            Column::make('visit.date')->title('Tanggal')->sortable(true),
            Column::make('visit.name')->title('Agenda')->sortable(false),
            Column::make('visit.desa.name')->title('Desa')->sortable(false),
            Column::make('name')->title('Isu')->sortable(false)->addClass('text-wrap'),
            Column::make('category.name')->title('Kategori')->sortable(false),
            Column::make('status.name')->title('Status')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Issue_' . date('YmdHis');
    }
}
