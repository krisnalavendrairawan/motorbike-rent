<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Common;
use App\Http\Requests\CustomerProfileRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    private $title = 'Customer';
    private $icon = '';
    private $path = 'backend.customer.';

    public function index()
    {
        $cutomer = User::all();
        $customerCount = count($cutomer);
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'cutomer' => $cutomer,
            'customerCount' => $customerCount,


        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $users = User::role('customer')
            ->select('id', 'nik', 'name', 'email', 'phone', 'driverLicense');

        $users_count = $users->count();

        $users_filter = $users->where(function ($query) use ($search) {
            $query->where('nik', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('driverLicense', 'like', '%' . $search . '%');
        });

        $users_count_filter = $users_filter->count();
        $users_data = $users_filter->limit($limit)
            ->offset($start)
            ->orderBy('created_at', 'desc')
            ->get();

        $users_arr = [];
        foreach ($users_data as $u) {
            $push = $u->toArray();
            $push['encrypted_id'] = $u->encrypted_id;
            array_push($users_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $users_count,
            'recordsFiltered' => $users_count_filter,
            'data' => $users_arr
        ];

        return response()->json($response);
    }

    public function show(User $customer)
    {
        $rentalHistory = Rental::where('customer_id', $customer->id)
            ->with('motor')
            ->latest()
            ->get();

        $totalSpent = Rental::where('customer_id', $customer->id)
            // ->where('status', 'rent')
            ->sum('total_price');

        return view($this->path . 'show', [
            'title' => $this->title,
            'icon' => $this->icon,
            'customer' => $customer,
            'rentalHistory' => $rentalHistory,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function create()
    {
        $genders = Common::option('gender');
        $roles = Role::all();
        return view($this->path . 'create', [
            'title' => $this->title,
            'icon' => $this->icon,
            'roles' => $roles,
            'genders' => $genders,
        ]);
    }

    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole('customer');
        return Redirect::route('customer.index')->with('success', __('message.create_success', ['label' => __($this->title)]));
    }

    public function edit(Request $request, User $customer)
    {
        $genders = Common::option('gender');
        return view($this->path . 'edit', [
            'title' => $this->title,
            'icon' => $this->icon,
            'customer' => $customer,
            'genders' => $genders,
        ]);
    }

    public function update(CustomerRequest $request, User $customer)
    {
        $data = $request->all();

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return Redirect::route('customer.index')
            ->with('success', __('message.update_success', ['label' => __($this->title)]));
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
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

    public function editProfile()
    {
        $genders = Common::option('gender');
        return view('frontend.auth.customer.profile', [
            'title' => __('label.profile') . '  ' .  __($this->title),
            'icon' => $this->icon,
            'customer' => Auth::user(),
            'genders' => $genders,
        ]);
    }

    public function updateProfile(CustomerProfileRequest $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $data = $request->validated();

        if ($request->filled('old_password')) {
            $data['password'] = bcrypt($request->new_password);
        }

        unset($data['old_password']);
        unset($data['new_password']);
        unset($data['new_password_confirmation']);

        if ($request->hasFile('picture')) {
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }
            $data['picture'] = $request->file('picture')->store('picture', 'public');
        }

        $user->update($data);

        return redirect()->route('landing.index')
            ->with('success', __('message.update_success', ['label' => __($this->title)]));
    }
}
