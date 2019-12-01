<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\UseCases\Auth\RegisterServis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;

class UsersController extends Controller
{
    private $service;
//    private $roles = [
//        User::ROLE_USER,
//        User::ROLE_ADMIN,
//        User::ROLE_MODER,
//    ];
    private $statuses = [
        User::STATUS_WAIT,
        User::STATUS_ACTIVE,
    ];
    public function __construct(RegisterServis $service)
    {
        $this->middleware('can:manage-users');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = User::rolesList();
        $query = User::orderBy('id','desc');
        $statuses = $this->statuses;
        if(!empty($value = $request->get('id'))){
            $query->where('id', $value);
        }
        if(!empty($value = $request->get('name'))){
            $query->where('name', 'like' ,'%'.$value.'%');
        }
        if(!empty($value = $request->get('email'))){
            $query->where('email', 'like' ,'%'.$value.'%');
        }
        if($request->get('status')!== null && in_array($request->get('status'), $this->statuses)){
            $query->where('status', $request->get('status'));
        }
        if($value = $request->get('role')!==null){
            $query->where('role', $request->get('role'));
        }
        $users = $query->paginate(10)->appends($request->all());

        return view('admin.users.index', compact('users',['roles', 'statuses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = User::rolesList();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try{
            $user = User::new($request['name'], $request['email'], $this->roles[$request['role']]);
            return redirect()->route('admin.users.show', compact('user'));
        }catch (\Exception $e){
            abort(501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = User::rolesLest();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update([
            'name'=> $request['name'],
            'email'=> $request['email'],
        ]);
        return redirect()->route('admin.users.show', compact('user'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status','You delete User - '.$user['name']);
    }
     public function verify(User $user)
     {
         $this->service->verify($user->id);
         return redirect()->route('admin.users.show', $user);
     }
     public function drop(Request $request)
     {
         return redirect()->route('admin.users.index');
     }
}
