<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class YearlyReportController extends Controller
{
    private $title = 'Yearly Transaction Report';
    private $icon = 'bx bxs-report';
    private $path = 'backend.report.';

    public function yearlyReport(Request $request)
    {
        $selectedYear = $request->year ?? Carbon::now()->year;
        $years = range(Carbon::now()->year - 5, Carbon::now()->year);

        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereYear('created_at', $selectedYear);

        $serviceQuery = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$selectedYear]);

        $transactions = $query->paginate(10);
        $serviceExpenses = $serviceQuery->paginate(10);

        $monthlyTransactions = $transactions->groupBy(function ($transaction) {
            return Carbon::parse($transaction->created_at)->month;
        });

        $monthlyServiceExpenses = $serviceExpenses->groupBy(function ($service) {
            return Carbon::parse($service->service_date)->month;
        });

        $chartData = collect(range(1, 12))->map(function ($month) use ($monthlyTransactions, $monthlyServiceExpenses) {
            $monthTransactions = $monthlyTransactions->get($month, collect());
            $monthServices = $monthlyServiceExpenses->get($month, collect());

            return [
                'month' => date('F', mktime(0, 0, 0, $month)),
                'total_transactions' => $monthTransactions->count(),
                'total_amount' => $monthTransactions->sum('total_amount'),
                'total_services' => $monthServices->count(),
                'total_service_cost' => $monthServices->sum('cost')
            ];
        });

        return view($this->path . 'yearly-report.yearly-report', [
            'title' => $this->title,
            'icon' => $this->icon,
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'chartData' => $chartData,
            'years' => $years,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function transactionPagination(Request $request)
    {
        $query = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereYear('created_at', $request->year);

        $transactions = $query->paginate(10);

        return response()->json([
            'html' => view('backend.report.monthly-report.partials.transaction-table', compact('transactions'))->render(),
            'last_page' => $transactions->lastPage()
        ]);
    }

    public function servicePagination(Request $request)
    {
        $query = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$request->year]);

        $serviceExpenses = $query->paginate(10);

        return response()->json([
            'html' => view('backend.report.monthly-report.partials.service-table', compact('serviceExpenses'))->render(),
            'last_page' => $serviceExpenses->lastPage()
        ]);
    }

    public function exportPDF(Request $request)
    {
        $selectedYear = $request->year ?? Carbon::now()->year;

        $transactions = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereYear('created_at', $selectedYear)
            ->get();

        $serviceExpenses = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$selectedYear])
            ->get();

        $pdf = PDF::loadView('backend.report.yearly-report.partials.pdf', [
            'transactions' => $transactions,
            'serviceExpenses' => $serviceExpenses,
            'selectedYear' => $selectedYear,
            'totalIncome' => $transactions->sum('total_amount'),
            'totalExpenses' => $serviceExpenses->sum('cost')
        ]);

        return $pdf->download("yearly_report_{$selectedYear}.pdf");
    }
}
