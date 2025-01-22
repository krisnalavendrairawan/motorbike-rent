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

    public function show($id)
    {
        $motor = Motor::findOrFail($id);
        $type = Common::option('bike_type');
        $brand = Brand::all();
        return view($this->path . 'show', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => $brand,
            'type' => $type,
            'motor' => $motor,
        ]);
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
}
