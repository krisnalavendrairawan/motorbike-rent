<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
    private $title = 'Brand';
    private $icon = 'bx bxs-captions';
    private $path = 'backend.brand.';


    public function index()
    {
        $brands = Brand::all();
        $brandCount = count($brands);
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brands' => $brands,
            'brandCount' => $brandCount,


        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $brands = Brand::where(function ($query) {})->select('id', 'name', 'logo', 'description');
        $brands_count = $brands->count();

        $brands_filter = $brands->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('logo', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });

        $brands_count_filter = $brands_filter->count();
        $brands_data = $brands_filter->limit($limit)
            ->offset($start)
            ->orderBy('created_at', 'desc')
            ->get();


        $brands_arr = [];
        foreach ($brands_data as $u) {
            $push = $u->toArray();
            $push['encrypted_id'] = $u->encrypted_id;
            $push['image_url'] = asset('storage/' . $u->logo);
            array_push($brands_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $brands_count,
            'recordsFiltered' => $brands_count_filter,
            'data' => $brands_arr
        ];

        return response()->json($response);
    }

    public function create()
    {

        return view($this->path . 'create', [
            'title' => $this->title,
            'icon' => $this->icon,
        ]);
    }

    public function store(BrandRequest $request)
    {
        $data = $request->all();
        $data['logo'] = $request->file('logo')->store('logo', 'public');
        Brand::create($data);
        $message = __('message.create_success');
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return Redirect::route('brand.index')->with('success', __('message.create_success', ['label' => __($this->title)]));
    }

    public function edit(Request $request, Brand $brand)
    {
        return view($this->path . 'edit', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => $brand,
        ]);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Hapus file lama jika ada
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }
            // Upload file baru
            $data['logo'] = $request->file('logo')->store('logo', 'public');
        } else {
            unset($data['logo']);
        }

        $brand->update($data);

        return redirect()->route('brand.index')
            ->with('success', __('message.update_success', ['label' => __($this->title)]));
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ], 200); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
