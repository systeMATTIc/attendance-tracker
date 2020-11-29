<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\TravelTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TravelTypeRepository $travelTypeRepository)
    {
        $this->authorize("viewAny", User::class);

        return view('users.index', [
            'users' => User::latest()->paginate(10),
            'travelTypes' => $travelTypeRepository->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TravelTypeRepository $travelTypeRepository)
    {
        $this->authorize("create", User::class);

        return view('users.create', [
            'travelTypes' => $travelTypeRepository->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize("create", User::class);

        User::query()->create(array_merge($request->all(), [
            'password' => Hash::make($request->password),
        ]));

        $request->session()->flash("status", "User creation was successfull !!!");

        return redirect()->action([self::class, 'index']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize("update", $user);

        return view('users.edit', ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize("update", $user);

        $user->update($request->all());

        $request->session()->flash("status", "User update was successfull !!!");

        return redirect()->action([self::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize("delete", $user);

        $user->delete();

        $request->session()->flash("status", "User deleted successfully !!!");

        return redirect()->action([self::class, 'index']);
    }
}
