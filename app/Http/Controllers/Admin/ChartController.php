<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $ordersChart = $this->getOrdersChart();
        $orderStatusChart = $this->getOrderStatusChart();
        $revenueChart = $this->getRevenueChart();
        
        return view('admin.charts.index', compact('ordersChart', 'orderStatusChart', 'revenueChart'));
    }

    private function getOrdersChart()
    {
        $chart = new LaravelChart([
            'chart_title' => 'Orders by Day',
            'report_type' => 'group_by_date',
            'model' => 'App\\Models\\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30, // Last 30 days
        ]);

        return $chart;
    }

    private function getOrderStatusChart()
    {
        $chart = new LaravelChart([
            'chart_title' => 'Orders by Status',
            'report_type' => 'group_by_string',
            'model' => 'App\\Models\\Order',
            'group_by_field' => 'status',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month', // Last month
        ]);

        return $chart;
    }

    private function getRevenueChart()
    {
        $chart = new LaravelChart([
            'chart_title' => 'Monthly Revenue',
            'report_type' => 'group_by_date',
            'model' => 'App\\Models\\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total_amount',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 365, // Last year
        ]);

        return $chart;
    }
}