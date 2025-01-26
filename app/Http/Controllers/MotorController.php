<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Common;
use App\Http\Requests\MotorRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class MotorController extends Controller
{
    private $title = 'Bike';
    private $icon = 'bx bxs-captions';
    private $path = 'backend.bike.';

    public function index(Request $request)
    {
        $query = Motor::query();
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('plate', 'like', "%{$request->search}%");
            });
        }

        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $motor = $query->paginate(9);
        $brands = Brand::all();
        $type = Common::option('bike_type');
        $motorCount = Motor::count();

        if ($request->ajax()) {
            return view($this->path . 'bike-grid', compact('motor'))->render();
        }

        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'motor' => $motor,
            'brands' => $brands,
            'motorCount' => $motorCount,
            'types' => $type,
        ]);
    }

    public function show($id, Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $motor = Motor::with([
            'rental' => function ($query) use ($year) {
                $query->where('status', 'finished')
                    ->whereYear('end_date', $year)
                    ->orderBy('end_date', 'desc')
                    ->with('customer');
            },
            'services' => function ($query) use ($year) {
                $query->whereYear('service_date', $year);
            }
        ])->findOrFail($id);

        $rentalHistory = $motor->rental()
            ->where('status', 'finished')
            ->whereYear('end_date', $year)
            ->orderBy('end_date', 'desc')
            ->paginate(5, ['*'], 'page');

        $serviceHistory = $motor->services()
            ->whereYear('service_date', $year)
            ->orderBy('service_date', 'desc')
            ->paginate(5, ['*'], 'service_page');

        // Calculate total rental income for the selected year
        $totalRentalIncome = $motor->rental()
            ->where('status', 'finished')
            ->whereYear('end_date', $year)
            ->sum('total_price');

        // Calculate total service costs for the selected year
        $totalServiceExpenses = $motor->services()
            ->whereYear('service_date', $year)
            ->sum('cost');

        // Generate an array of years with rental or service records
        $availableYears = $this->getAvailableYears($motor);

        // Handle AJAX requests
        if ($request->ajax()) {
            if ($request->has('rental_page')) {
                return view('backend.bike.partials.rental-history', [
                    'rentalHistory' => $rentalHistory,
                    'motor' => $motor
                ])->render();
            }
            if ($request->has('service_page')) {
                return view('backend.bike.partials.service-history', [
                    'serviceHistory' => $serviceHistory,
                    'motor' => $motor
                ])->render();
            }
        }

        return view($this->path . 'show', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => Brand::all(),
            'type' => Common::option('bike_type'),
            'motor' => $motor,
            'rentalHistory' => $rentalHistory,
            'serviceHistory' => $serviceHistory,
            'totalRentalIncome' => $totalRentalIncome,
            'totalServiceExpenses' => $totalServiceExpenses,
            'selectedYear' => $year,
            'availableYears' => $availableYears,
        ]);
    }

    private function getAvailableYears($motor)
    {
        $rentalYears = $motor->rental()
            ->where('status', 'finished')
            ->selectRaw('DISTINCT YEAR(end_date) as year')
            ->pluck('year')
            ->toArray();

        $serviceYears = $motor->services()
            ->selectRaw('DISTINCT YEAR(service_date) as year')
            ->pluck('year')
            ->toArray();

        return array_unique(array_merge($rentalYears, $serviceYears));
    }

    public function create()
    {
        $type = Common::option('bike_type');
        $brand = Brand::all();
        return view($this->path . 'create', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => $brand,
            'type' => $type,
        ]);
    }

    public function store(MotorRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }
        Motor::create($data);

        $message = __('message.create_success', ['label' => __($this->title)]);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return Redirect::route('bike.index')->with('success', $message);
    }

    public function edit($id)
    {
        $motor = Motor::findOrFail($id);
        $type = Common::option('bike_type');
        $brand = Brand::all();

        return view($this->path . 'edit', compact('motor', 'brand', 'type') + [
            'title' => $this->title,
            'icon' => $this->icon,
        ]);
    }

    public function update(MotorRequest $request, $id)
    {
        $motor = Motor::findOrFail($id);

        $motor->fill($request->validated());
        if ($request->hasFile('image')) {
            $motor->image = $request->file('image')->store('images', 'public');
        }

        $motor->save();

        return redirect()->route('bike.index')->with('success', 'Data motor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);
        $motor->forceDelete();

        return redirect()->route('bike.index')->with('success', 'Motor deleted successfully.');
    }

    public function exportPdf($id)
    {
        $motor = Motor::with([
            'rental' => function ($query) {
                $query->where('status', 'finished');
            },
            'services',
            'brand'
        ])->findOrFail($id);

        // Calculate total service costs
        $totalServiceCost = $motor->services()->sum('cost');

        // Calculate total rental income
        $totalRentalIncome = $motor->rental()
            ->where('status', 'finished')
            ->sum('total_price');

        // Generate PDF using Laravel's TCPDF or FPDF library
        $pdf = PDF::loadView('backend.bike.pdf.motor-details', [
            'motor' => $motor,
            'totalServiceCost' => $totalServiceCost,
            'totalRentalIncome' => $totalRentalIncome
        ]);

        return $pdf->download("{$motor->name}_details.pdf");
    }
}
