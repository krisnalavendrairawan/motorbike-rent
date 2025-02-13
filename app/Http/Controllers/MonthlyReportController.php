<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class MonthlyReportController extends Controller
{
    private $title = 'Monthly Report';
    private $icon = 'bx bxs-report';
    private $path = 'backend.report.';

    public function transactionReport(Request $request)
    {
        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid');

        $selectedMonth = $request->month ?? Carbon::now()->month;
        $selectedYear = $request->year ?? Carbon::now()->year;

        $query->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth);

        $transactions = $query->get();

        $serviceQuery = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$selectedYear])
            ->whereRaw('MONTH(service_date) = ?', [$selectedMonth]);

        $serviceExpenses = $serviceQuery->get();

        $monthlySummary = $transactions->groupBy(function ($transaction) {
            return (string)Carbon::parse($transaction->created_at)->day;
        });

        $monthlyServiceExpenses = $serviceExpenses->groupBy(function ($service) {
            return (string)Carbon::parse($service->service_date)->day;
        });

        $daysInMonth = Carbon::create($selectedYear, $selectedMonth)->daysInMonth;

        $chartData = collect(range(1, $daysInMonth))->map(function ($day) use ($monthlySummary, $monthlyServiceExpenses) {
            $dayTransactions = $monthlySummary->get((string)$day, collect());
            $dayServices = $monthlyServiceExpenses->get((string)$day, collect());

            return [
                'day' => $day,
                'total_transactions' => $dayTransactions->count(),
                'total_amount' => $dayTransactions->sum('total_amount'),
                'total_services' => $dayServices->count(),
                'total_service_cost' => $dayServices->sum('cost')
            ];
        });

        $years = range(Carbon::now()->year - 5, Carbon::now()->year);

        $transactions = $query->paginate(5);
        $serviceExpenses = $serviceQuery->paginate(5);

        return view($this->path . 'monthly-report.monthly-report', [
            'title' => $this->title,
            'icon' => $this->icon,
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'monthlySummary' => $monthlySummary,
            'monthlyServiceExpenses' => $monthlyServiceExpenses,
            'chartData' => $chartData,
            'years' => $years,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function weeklyTransactionPagination(Request $request)
    {
        // Create a Carbon instance for the first day of the month
        $date = Carbon::create($request->year, $request->month, 1);
        // Calculate start date by adding weeks
        $startDate = $date->copy()->addWeeks($request->week - 1)->startOfWeek();
        // Calculate end date
        $endDate = $startDate->copy()->endOfWeek();

        // Ensure we only get data for the selected month
        if ($startDate->month != $request->month) {
            $startDate = Carbon::create($request->year, $request->month)->startOfMonth();
        }
        if ($endDate->month != $request->month) {
            $endDate = Carbon::create($request->year, $request->month)->endOfMonth();
        }

        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $transactions = $query->paginate(5);

        return response()->json([
            'html' => view('backend.report.weekly-report.partials.transaction-table', compact('transactions'))->render(),
            'last_page' => $transactions->lastPage()
        ]);
    }

    public function weeklyServicePagination(Request $request)
    {
        // Create a Carbon instance for the first day of the month
        $date = Carbon::create($request->year, $request->month, 1);
        // Calculate start date by adding weeks
        $startDate = $date->copy()->addWeeks($request->week - 1)->startOfWeek();
        // Calculate end date
        $endDate = $startDate->copy()->endOfWeek();

        // Ensure we only get data for the selected month
        if ($startDate->month != $request->month) {
            $startDate = Carbon::create($request->year, $request->month)->startOfMonth();
        }
        if ($endDate->month != $request->month) {
            $endDate = Carbon::create($request->year, $request->month)->endOfMonth();
        }

        $query = Service::with('motor')
            ->whereBetween('service_date', [$startDate, $endDate]);

        $serviceExpenses = $query->paginate(5);

        return response()->json([
            'html' => view('backend.report.weekly-report.partials.service-table', compact('serviceExpenses'))->render(),
            'last_page' => $serviceExpenses->lastPage()
        ]);
    }

    public function exportPDF(Request $request)
    {
        $selectedMonth = $request->month ?? Carbon::now()->month;
        $selectedYear = $request->year ?? Carbon::now()->year;

        // Add start and end date
        $startDate = Carbon::create($selectedYear, $selectedMonth)->startOfMonth();
        $endDate = Carbon::create($selectedYear, $selectedMonth)->endOfMonth();

        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth);

        $transactions = $query->get();

        $serviceQuery = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$selectedYear])
            ->whereRaw('MONTH(service_date) = ?', [$selectedMonth]);

        $serviceExpenses = $serviceQuery->get();

        $monthName = date('F', mktime(0, 0, 0, $selectedMonth));

        $pdf = PDF::loadView('backend.report.monthly-report.partials.pdf', [
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'selectedMonth' => $monthName,
            'selectedYear' => $selectedYear,
            'totalIncome' => $transactions->sum('total_amount'),
            'totalExpenses' => $serviceExpenses->sum('cost'),
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return $pdf->download("monthly_report_{$selectedYear}_{$selectedMonth}.pdf");
    }
}
