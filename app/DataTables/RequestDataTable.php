<?php

namespace App\DataTables;

use App\Models\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequestDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('request.update', $item->uuid);
                $deleteRoute = route('request.destroy', $item->uuid);
                $photo = env('APP_FE_URL') . $item->photo;
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-url='{$editRoute}'
                                        data-ticket='{$item->ticket}'
                                        data-description='{$item->description}'
                                        data-date='{$item->date}'
                                        data-request_type='{$item->request_type->name}'
                                        data-status_id='{$item->status_id}'>
                                            <i class='fa fa-pencil'></i>
                                            Edit
                                        </a>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#photoModal'
                                        data-photo='{$photo}'>
                                            <i class='fa fa-file-image'></i>
                                            Photo
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

    public function query(Request $model): QueryBuilder
    {
        $query = $model->with([
            'user.project.profile',
            'user',
            'request_type',
            'status',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('request-table')
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
            Column::make('date')->title('Tanggal')->sortable(false),
            Column::make('ticket')->title('Tiket')->sortable(false),
            Column::make('request_type.name')->title('Tipe Request')->sortable(false),
            Column::make('user.project.profile.name')->title('Project')->sortable(false),
            Column::make('description')->title('Deskripsi')->addClass('text-wrap')->sortable(false),
            Column::make('user.name')->title('Request By')->sortable(false),
            Column::make('status.name')->title('Status')->sortable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Request_' . date('YmdHis');
    }
}
