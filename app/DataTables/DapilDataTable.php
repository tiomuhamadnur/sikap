<?php

namespace App\DataTables;

use App\Models\Dapil;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DapilDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('#', function ($item) {
            $editRoute = route('dapil.update', $item->uuid);
            $deleteRoute = route('dapil.destroy', $item->uuid);
            $actionButton = "<div class='dropdown'>
                                <button class='btn' data-bs-toggle='dropdown'>
                                    <i class='fa fa-pencil'></i>
                                    Edit
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' title='Tambah Kabupaten/Kota' data-bs-target='#addKabupatenModal' data-id='{$item->id}'>
                                        <i class='fa fa-plus fw-bolder'></i>
                                        Add New
                                    </a>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                    data-url='{$editRoute}'
                                    data-name='{$item->name}'
                                    data-project_id='{$item->project_id}'>
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
        ->addColumn('kabupaten', function ($item) {
            if (!$item->relasi_dapil) {
                return '-';
            }

            $list = $item->relasi_dapil->map(function ($relasi) {
                $kabupaten = $relasi->kabupaten;

                if (!$kabupaten) {
                    return null;
                }

                $label = "• {$kabupaten->type} {$kabupaten->name}";

                $deleteUrl = route('relasi-dapil.destroy', $relasi->uuid);
                $deleteLink = "<a href='#' class='text-danger' title='Hapus Kabupaten/Kota'
                                data-bs-toggle='modal' data-bs-target='#deleteModal'
                                data-url='{$deleteUrl}'>
                                <i class='fa fa-trash-can'></i>
                            </a>";

                return $label . ' ' . $deleteLink;
            });

            return $list->filter()->implode('<br>') ?: '-';
        })
        ->rawColumns(['#', 'kabupaten']);
    }

    public function query(Dapil $model): QueryBuilder
    {
        $query = $model->with([
            'project',
            'project.profile',
            'project.periode',
            'relasi_dapil',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dapil-table')
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
            Column::make('project.profile.name')->title('Project')->sortable(false),
            Column::make('project.periode.name')->title('Periode')->sortable(false),
            Column::computed('kabupaten')->title('Kabupaten/Kota')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Dapil_' . date('YmdHis');
    }
}
