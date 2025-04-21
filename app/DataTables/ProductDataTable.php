<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use function Laravel\Prompts\select;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($row) {
            if ($row->Deleted !== null) {
                // Record is soft-deleted, so show the restore button
                return "<form action='" . route('products.restore', $row->id) . "' method='GET' class='d-inline'>
                    <button class='btn btn-warning' type='submit'>
                        <i class='fa fa-undo'></i> Restore
                    </button>
                </form>";
            } else {
                // Record is not soft-deleted, show the edit and delete buttons
                return "<div class='action-group'>
                    <a href='" . route('admin.products.edit', $row->id) . "' class='btn btn-primary'>
                        <i class='fa fa-edit'></i>
                    </a>
                    
                    <form action='" . route('products_delete', $row->id) . "' method='GET' class='d-inline'>
                        <button class='btn btn-danger' type='submit'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                </div>";
            }
        })
        ->rawColumns(['action'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()
        ->withTrashed()
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select(['products.id as id','products.name as Name', 'products.description as Description', 'products.price as Price', 'products.stock as Stock','categories.name as Category','products.deleted_at as Deleted']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
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
            Column::make('Description'),
            Column::make('Price'),
            Column::make('Stock'),
            Column::make('Category'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
