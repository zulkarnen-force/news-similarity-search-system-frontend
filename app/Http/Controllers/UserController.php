<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query();
        if(request('search')){
            $users->where('name','LIKE','%'.request('search').'%')->orwhere('roles','LIKE','%'.request('search').'%');   
        }
        return view('contents.user.index', [
            'users' => $users->orderBy('id', 'DESC')->paginate(5)->onEachSide(1)->withQueryString(),
        ]);
    }
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('contents.user.edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user,$id)
    {
        $request->validate([
            'name' => 'required',
            'roles' => 'required'
        ]);
        $user = User::find($id);

        $user = User::where('id',$user->id)->update([
            'name' => $request->name,
            'roles' => $request->roles
        ]);

        return redirect()->route('user-index')->with('success','Data Berhasil Diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('deleted','User Berhasil Dihapus');
    }

    public function profile($id)
    {
        $users = User::find($id);
        return view('contents.user.profile',compact('users'));
    }
}
