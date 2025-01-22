<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Common;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $title = 'User';
    private $icon = '';
    private $path = 'backend.user.';
    public function index()
    {
        $users = User::all();
        $userCount = count($users);
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'users' => $users,
            'userCount' => $userCount,
        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $users = User::where(function ($query) {
            $query->role('admin')
                ->orWhereDoesntHave('roles');
        })->select('id', 'name', 'email', 'phone');
        $users_count = $users->count();

        $users_filter = $users->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
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

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return Redirect::route('user.index')->with('success', __('message.create_success', ['label' => __($this->title)]));
    }

    public function edit(Request $request, User $user)
    {
        $genders = Common::option('gender');
        return view($this->path . 'edit', [
            'title' => $this->title,
            'icon' => $this->icon,
            'user' => $user,
            'genders' => $genders,

        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']); // Hapus key password jika kosong
        }


        $user->update($data);

        return Redirect::route('user.index')->with('success', __('message.update_success', ['label' => __($this->title)]));
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
}
