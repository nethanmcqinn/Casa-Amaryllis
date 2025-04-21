<?php

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewsDataTable extends DataTable
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
            // build the HTML string with POST + CSRF + method spoofing
            return "
                <div class='action-group'>
                    <form 
                        action='" . route('admin.reviews.destroy', $row->id) . "' 
                        method='POST' 
                        class='d-inline' 
                        onsubmit='return confirm(\"Are you sure you want to delete this review?\")'
                    >
                        " . csrf_field() . "
                        <input type='hidden' name='_method' value='DELETE'>
                        <button class='btn btn-danger' type='submit'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>
                </div>
            ";
        })
        ->rawColumns(['action'])
        ->setRowId('id');
}

    /**
     * Get the query source of dataTable.
     */
    public function query(Review $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['product_reviews.id as id', 'product_reviews.user_id as User ID', 'product_reviews.product_id as Product ID', 'product_reviews.comment as Comment', 'product_reviews.rating as Rating']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('reviews-table')
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
            Column::make('User ID'),
            Column::make('Product ID'),
            Column::make('Comment'),
            Column::make('Rating'),
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
        return 'Reviews_' . date('YmdHis');
    }
}
