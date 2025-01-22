<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Brand;
use App\Models\Rental;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $title = 'Dashboard';
    private $icon = '';
    private $path = 'pages.dashboard';
    public function index()
    {
        $motorCount = Motor::count();
        $brandCount = Brand::count();
        $user = User::all();
        $user = auth()->user();

        $currentMonth = now();
        $currentMonthRentals = Rental::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlyIncome = Rental::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('total_price');

        $topMotors = Rental::select(
            'motor.name as motor_name',
            'brand.name as brand_name',
            DB::raw('COUNT(rental.id) as rental_count'),
            DB::raw('SUM(rental.total_price) as total_revenue')
        )
            ->join('motor', 'rental.motor_id', '=', 'motor.id')
            ->join('brand', 'motor.brand_id', '=', 'brand.id')
            ->groupBy('motor.id', 'motor.name', 'brand.name')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        $weeklyServiceExpenses = Service::whereBetween('service_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->sum('cost');

        $motorsInService = Service::with(['motor'])
            ->where('status', 'scheduled')
            ->latest()
            ->take(5)
            ->get();
        $totalServiceExpenses = Service::sum('cost');
        $staffCount = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'customer');
        })->count();

        $latestRentals = Rental::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Rental::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_revenue')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => \Carbon\Carbon::create()->month($item->month)->format('M'),
                    'revenue' => $item->total_revenue
                ];
            });

        $yearlyRevenue = Rental::whereYear('created_at', now()->year)
            ->sum('total_price');

        $previousMonthRevenue = Rental::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_price');

        $currentMonthRevenue = Rental::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $monthlyGrowth = $previousMonthRevenue != 0
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100
            : 0;

        return view($this->path, [
            'title' => $this->title,
            'icon' => $this->icon,
            'motorCount' => $motorCount,
            'brandCount' => $brandCount,
            'user' => $user,
            'currentMonthRentals' => $currentMonthRentals,
            'staffCount' => $staffCount,
            'latestRentals' => $latestRentals,
            'monthlyIncome' => $monthlyIncome,
            'topMotors' => $topMotors,
            'weeklyServiceExpenses' => $weeklyServiceExpenses,
            'totalServiceExpenses' => $totalServiceExpenses,
            'motorsInService' => $motorsInService,
            'monthlyRevenue' => $monthlyRevenue,
            'yearlyRevenue' => $yearlyRevenue,
            'monthlyGrowth' => $monthlyGrowth,
            'currentMonthRevenue' => $currentMonthRevenue
        ]);
    }
}
