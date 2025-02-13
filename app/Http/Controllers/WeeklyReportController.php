<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class WeeklyReportController extends Controller
{
    private $title = 'Weekly Report';
    private $icon = 'bx bxs-report';
    private $path = 'backend.report.';

    public function weeklyReport(Request $request)
    {
        $now = Carbon::now();
        $selectedMonth = $request->month ?? $now->month;
        $selectedYear = $request->year ?? $now->year;
        $selectedWeek = $request->week ?? $now->setMonth($selectedMonth)->weekOfMonth;

        // Get start and end date of the selected week
        $date = Carbon::create($selectedYear, $selectedMonth, 1);
        $startDate = $date->copy()->addWeeks($selectedWeek - 1)->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();

        // Ensure we only get data for the selected month
        if ($startDate->month != $selectedMonth) {
            $startDate = Carbon::create($selectedYear, $selectedMonth)->startOfMonth();
        }
        if ($endDate->month != $selectedMonth) {
            $endDate = Carbon::create($selectedYear, $selectedMonth)->endOfMonth();
        }

        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $transactions = $query->get();

        $serviceQuery = Service::with('motor')
            ->whereBetween('service_date', [$startDate, $endDate]);

        $serviceExpenses = $serviceQuery->get();

        // Group transactions and services by day
        $dailySummary = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->created_at)->format('Y-m-d');
        });

        $dailyServiceExpenses = $serviceExpenses->groupBy(function ($service) {
            return Carbon::parse($service->service_date)->format('Y-m-d');
        });

        // Prepare chart data for each day in the week
        $chartData = collect();
        for ($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateKey = $date->format('Y-m-d');
            $dayTransactions = $dailySummary->get($dateKey, collect());
            $dayServices = $dailyServiceExpenses->get($dateKey, collect());

            $chartData->push([
                'day' => $date->format('d'),
                'date' => $date->format('D, M d'),
                'total_transactions' => $dayTransactions->count(),
                'total_amount' => $dayTransactions->sum('total_amount'),
                'total_services' => $dayServices->count(),
                'total_service_cost' => $dayServices->sum('cost')
            ]);
        }

        $weeks = [];
        $firstDay = Carbon::create($selectedYear, $selectedMonth, 1);
        $lastDay = Carbon::create($selectedYear, $selectedMonth)->endOfMonth();

        $weekNum = 1;
        while ($firstDay <= $lastDay) {
            $weekStart = $firstDay->copy()->startOfWeek();
            $weekEnd = $firstDay->copy()->endOfWeek();

            if ($weekStart->month != $selectedMonth) {
                $weekStart = $firstDay->copy()->startOfMonth();
            }
            if ($weekEnd->month != $selectedMonth) {
                $weekEnd = $firstDay->copy()->endOfMonth();
            }

            $weeks[] = [
                'week' => $weekNum,
                'start' => $weekStart->format('M d'),
                'end' => $weekEnd->format('M d')
            ];

            $firstDay = $weekEnd->copy()->addDay();
            $weekNum++;

            // Hindari infinite loop
            if ($weekNum > 5) break;
        }

        // Get years for dropdown (similar to monthly report)
        $years = range(Carbon::now()->year - 5, Carbon::now()->year);

        // Get paginated results for tables
        $transactions = $query->paginate(5);
        $serviceExpenses = $serviceQuery->paginate(5);

        return view($this->path . 'weekly-report.weekly-report', [
            'title' => $this->title,
            'icon' => $this->icon,
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'dailySummary' => $dailySummary,
            'dailyServiceExpenses' => $dailyServiceExpenses,
            'chartData' => $chartData,
            'weeks' => $weeks,
            'years' => $years,
            'selectedWeek' => $selectedWeek,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalIncome' => $transactions->sum('total_amount'),
            'totalExpenses' => $serviceExpenses->sum('cost')
        ]);
    }



    public function getWeeks(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $weeks = [];
        $firstDay = Carbon::create($year, $month, 1);
        $lastDay = Carbon::create($year, $month)->endOfMonth();

        while ($firstDay <= $lastDay) {
            $weekNum = $firstDay->weekOfMonth;
            $weekStart = clone $firstDay->startOfWeek();
            $weekEnd = clone $firstDay->endOfWeek();

            if ($weekStart->month != $month) {
                $weekStart = $weekStart->startOfMonth();
            }
            if ($weekEnd->month != $month) {
                $weekEnd = $weekEnd->endOfMonth();
            }

            $weeks[] = [
                'week' => $weekNum,
                'start' => $weekStart->format('M d'),
                'end' => $weekEnd->format('M d')
            ];

            $firstDay->addWeek();
            if ($firstDay->weekOfMonth == 1) {
                break;
            }
        }

        return response()->json(['weeks' => $weeks]);
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

    public function exportWeeklyPDF(Request $request)
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

        $transactions = $query->get();

        $serviceQuery = Service::with('motor')
            ->whereBetween('service_date', [$startDate, $endDate]);

        $serviceExpenses = $serviceQuery->get();

        $pdf = PDF::loadView('backend.report.weekly-report.partials.pdf', [
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'startDate' => $startDate->format('d M Y'),
            'endDate' => $endDate->format('d M Y'),
            'selectedWeek' => $request->week,
            'selectedMonth' => $request->month,
            'selectedYear' => $request->year,
            'totalIncome' => $transactions->sum('total_amount'),
            'totalExpenses' => $serviceExpenses->sum('cost')
        ]);

        return $pdf->download("weekly_report_{$request->year}_month_{$request->month}_week_{$request->week}.pdf");
    }
}
