<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Rental;
use Carbon\Carbon;

class BikeReportController extends Controller
{
    private $title = 'Bike Report';
    private $icon = 'bx bx-chart';
    private $path = 'backend.report.bike-report.';

    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $topMotors = Motor::select('motor.id', 'motor.name', 'motor.plate', 'motor.type')
            ->leftJoin('rental', function ($join) use ($year) {
                $join->on('motor.id', '=', 'rental.motor_id')
                    ->whereYear('rental.start_date', $year)
                    ->where('rental.status', 'finished');
            })
            ->selectRaw('COUNT(rental.id) as total_rental')
            ->groupBy('motor.id', 'motor.name', 'motor.plate', 'motor.type')
            ->orderBy('total_rental', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($motor) {
                $tierScore = $motor->total_rental;

                if ($tierScore > 50) $motor->tier = 'S';
                elseif ($tierScore > 30) $motor->tier = 'A';
                elseif ($tierScore > 20) $motor->tier = 'B';
                elseif ($tierScore > 10) $motor->tier = 'C';
                else $motor->tier = 'D';

                return $motor;
            })
            ->sortBy('tier');

        $years = Rental::selectRaw('DISTINCT YEAR(start_date) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'topMotors' => $topMotors,
            'selectedYear' => $year,
            'years' => $years
        ]);
    }
}
