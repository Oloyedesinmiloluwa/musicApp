<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->user['firstName'];
        $this->validate(
            $request,
            [
                'user.firstName' => ['required', 'min:2'], //Todo: find out if you can generate all errors
                'user.lastName' => ['required', 'min:2'],
                'user.email' => ['required', 'email', 'unique:users,email', 'max:50'],
                'user.password' => ['required', 'min:4'], // update later with regex
            ]
        );

        $input = $request->input();// note input includes query params
        $input['user']['password'] = Hash::make($request->user['firstName']);
        $user = User::create($input['user']);
       return response()->json(['msg' => 'Registration successful', 'data' => $user ], 201);
    }

    public function updateProfile(Request $request, User $user)
    {
        $this->validate($request, [
            'user.email' => 'email|max:50',
            'user.bio' => 'max:250',
            'user.photo' => 'max:250',
            'user.firstName' => 'max:50',
            'user.lastName' => 'max:50'
        ]);
        $user->fill(collect($request->user)->except('password')->toArray());
        return response()->json([
            'msg' => 'Profile successfully updated',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function getFavourites()
    {
        // get user;
        $user = User::find(1);
        $favourites = $user->favouriteTracks;
        return response()->json(['data' => [
            'favourite' => $favourites
        ]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
