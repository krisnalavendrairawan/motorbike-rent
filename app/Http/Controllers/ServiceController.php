<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private $title = 'Service';
    private $icon = 'bx bxs-cog';
    private $path = 'backend.service.';

    public function index()
    {
        $service = Service::all();
        $serviceCounts = count($service);
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'service' => $service,
            'serviceCounts' => $serviceCounts,
        ]);
    }

    // ServiceController.php
    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $service = Service::with('motor')
            ->select('service.*'); // Ubah ini untuk memastikan memilih dari tabel service

        $service_count = $service->count();

        $service_filter = $service->where(function ($query) use ($search) {
            $query->whereHas('motor', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('image', 'like', '%' . $search . '%');
            })
                ->orWhere('service.service_date', 'like', '%' . $search . '%')
                ->orWhere('service.service_type', 'like', '%' . $search . '%')
                ->orWhere('service.cost', 'like', '%' . $search . '%')
                ->orWhere('service.description', 'like', '%' . $search . '%');
        });

        $service_count_filter = $service_filter->count();
        $service_data = $service_filter->limit($limit)
            ->offset($start)
            ->orderBy('service.created_at', 'desc')
            ->get();

        $service_arr = [];
        foreach ($service_data as $s) {
            $push = [
                'id' => $s->id,
                'motor_id' => $s->motor_id,
                'motor_name' => $s->motor ? $s->motor->name : 'N/A',
                'motor_image' => $s->motor ? $s->motor->image : 'N/A',
                'formatted_service_date' => \Carbon\Carbon::parse($s->service_date)->isoFormat('D MMMM Y'),
                'service_type' => $s->service_type,
                'formatted_cost' => 'Rp ' . number_format($s->cost, 0, ',', '.'),
                'description' => $s->description,
                'status' => $s->status
            ];
            array_push($service_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $service_count,
            'recordsFiltered' => $service_count_filter,
            'data' => $service_arr
        ];

        return response()->json($response);
    }

    public function create()
    {
        $motor = Motor::where('status', 'ready')->get();

        $serviceTypes = [
            'regular' => 'Regular Service',
            'repair' => 'Repair/Fix',
            'spare_part' => 'Spare Part Replacement',
            'emergency' => 'Emergency Service'
        ];

        return view($this->path . 'create', [
            'title' => $this->title,
            'icon' => $this->icon,
            'motor' => $motor,
            'serviceTypes' => $serviceTypes,
        ]);
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'motor_id' => 'required|exists:motor,id',
                'service_date' => 'required|date',
                'service_type' => 'required|in:regular,repair,spare_part,emergency',
                'cost' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
            ]);

            $serviceDate = Carbon::parse($request->service_date);

            if ($serviceDate->isPast()) {
                throw new \Exception('Service date cannot be in the past');
            }

            $motor = Motor::findOrFail($request->motor_id);

            $service = Service::create([
                'motor_id' => $request->motor_id,
                'service_date' => $serviceDate,
                'service_type' => $request->service_type,
                'cost' => $request->cost,
                'description' => $request->description,
                'status' => 'scheduled',
                'created_by' => auth()->id(),
            ]);

            $motor->update(['status' => 'not_ready']);

            DB::commit();

            return redirect()->route('service.index')
                ->with('success', 'Service record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function complete($id)
    {
        try {
            DB::beginTransaction();

            $service = Service::with('motor')->findOrFail($id);

            $service->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            $service->motor->update([
                'status' => 'ready'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service completed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $motor = Motor::where('status', 'ready')->orWhere('id', $service->motor_id)->get();

        $serviceTypes = [
            'regular' => 'Regular Service',
            'repair' => 'Repair/Fix',
            'spare_part' => 'Spare Part Replacement',
            'emergency' => 'Emergency Service'
        ];

        return view($this->path . 'edit', [
            'title' => 'Edit Service',
            'icon' => $this->icon,
            'service' => $service,
            'motor' => $motor,
            'serviceTypes' => $serviceTypes,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $service = Service::findOrFail($id);

            $request->validate([
                'motor_id' => 'required|exists:motor,id',
                'service_date' => 'required|date',
                'service_type' => 'required|in:regular,repair,spare_part,emergency',
                'cost' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'status' => 'required|in:scheduled,completed',
            ]);

            $serviceDate = Carbon::parse($request->service_date);

            $oldMotorId = $service->motor_id;
            $newMotorId = $request->motor_id;

            $service->update([
                'motor_id' => $newMotorId,
                'service_date' => $serviceDate,
                'service_type' => $request->service_type,
                'cost' => $request->cost,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // Handle motor status changes
            if ($oldMotorId !== $newMotorId) {
                // Mark old motor as ready
                Motor::where('id', $oldMotorId)->update(['status' => 'ready']);

                // Mark new motor as not ready if not already completed
                if ($request->status !== 'completed') {
                    Motor::where('id', $newMotorId)->update(['status' => 'not_ready']);
                }
            }

            DB::commit();

            return redirect()->route('service.index')
                ->with('success', 'Service record updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
