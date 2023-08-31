<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        User::create([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'birthdate' => $request->birthdate,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city_id' => $request->city_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User  $user)
    {
        $request->validate([
            'document_type' => 'required',
            'document_number' => 'required',
            'name' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'city_id' => 'required',
        ]);


        $data = $request->all();

        // Verificar si se proporcionó una nueva contraseña
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Eliminar la clave "password" del array si no se proporcionó una nueva contraseña
            unset($data['password']);
        }
        $user->update($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User  $user)
    {
        $user->delete();
    }

    public function getCity($id)
    {
        $city = Ciudad::find($id);

        if (!$city) {
            return response()->json(['error' => 'City not found'], 404);
        }

        return response()->json($city);
    }
    public function getUsersByCity()
    {
        $usersByCity = User::select('city_id', \DB::raw('count(*) as user_count'))
            ->groupBy('city_id')
            ->get();

        return response()->json($usersByCity);
    }
    public function getCityNames(Request $request)
    {
        $cityIds = $request->input('cityIds');
        $cityNames = Ciudad::whereIn('id', $cityIds)->pluck('name');
        return response()->json($cityNames);
    }

}
