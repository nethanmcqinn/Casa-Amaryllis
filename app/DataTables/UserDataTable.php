<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

        ->addColumn('Status', function ($row) {
            return "<div class='form-check form-switch'>
            <form action='".route('user.status', $row->id)."' method='GET' class='form-control'>
            <select name='status' class='form-select' onchange='this.form.submit()'>
                <option value='1' ".($row->Is_Active ? 'selected' : '').">Active</option>
                <option value='0' ".(!$row->Is_Active ? 'selected' : '').">Inactive</option>
            </select>
            </form>
            </div>" ;
        })
        ->addColumn('role', function ($row) {
            return "<div class='form-check form-switch'>
            <form action='".route('user.role', $row->id)."' method='GET' class='form-control'>
            <select name='role' class='form-select' onchange='this.form.submit()'>
                <option value='admin' ".($row->Role == 'admin' ? 'selected' : '').">Admin</option>
                <option value='customer' ".($row->Role == 'customer' ? 'selected' : '').">Customer</option>
            </select>
            </form>
            </div>" ;
        })
        ->addColumn('action', function ($row) {
            return "<div class='action-group'>
                        <a href='" . route('admin.users.edit', $row->id) . "' class='btn btn-primary'>
                            <i class='fa fa-edit'></i>
                        </a>
                        
                        <form action='" . route('admin.users.destroy', $row->id) . "' method='POST' class='d-inline'>
                            " . csrf_field() . "
                            " . method_field('DELETE') . "
                            <button class='btn btn-danger' type='submit'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </form>
                    </div>";
        })
        
        ->rawColumns(['action', 'Status', 'role'])
        ->setRowId('id');
        }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
        
            ->select(['users.id as id','users.email as Email', 'users.name as Name','users.role as Role', 'users.is_active as Is_Active']);
    }
           

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('Name'),
            Column::make('Email'),
            Column::computed('role'),
            Column::computed('Status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
