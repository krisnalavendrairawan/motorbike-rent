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

        $transactions = Transaction::with(['rental.motor', 'rental.customer'])
            ->where('status', 'paid')
            ->whereYear('created_at', $selectedYear)
            ->get();

        $serviceExpenses = Service::with('motor')
            ->whereRaw('YEAR(service_date) = ?', [$selectedYear])
            ->get();

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
