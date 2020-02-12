<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth')->only('updateProfile', 'getFavourites');
    }
    /**
     * Display a listing of the resource.
     * @codeCoverageIgnore
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
        $this->validate(
            $request,
            [
                'user.firstName' => ['required', 'min:2'], //Todo: find out if you can generate all errors
                'user.lastName' => ['required', 'min:2'],
                'user.email' => ['required', 'unique:users,email', 'max:50'],
                'user.password' => ['required', 'min:4'],
            ]
        );

        $input = $request->input();// note input includes query params
        if (!preg_match("/^(.*\w)(@).*\w$/", $input['user']['email'])) {
            return response()->json(['msg' => 'Your provide a valid email'], 400);
        }
        if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{4,10}$/", $input['user']['password'])) {
            return response()->json(['msg' => 'Your password must contain lowercase, uppercase letters and number character and must be 4 to 8 characters long'], 400);
        }
        $input['user']['password'] = Hash::make($request->user['password']);
        $user = User::create($input['user']);
       return response()->json(['msg' => 'Registration successful', 'data' => $user ], 201);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
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
        $user = auth()->user();
        $favourites = $user->favouriteTracks;
        return response()->json(['data' => [
            'favourite' => $favourites
        ]]);
    }

    /**
     * Display the specified resource.
     * @codeCoverageIgnore
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
