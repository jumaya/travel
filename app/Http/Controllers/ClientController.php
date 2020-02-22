<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\StoreClient;
use App\Client;
use DataTables;

/**
* @file Controller that contains the Client functions 
* @name ClientController.php
* @author Juan Sebastiana Maya <jumaya19@gmail.com>
**/

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register');
    }

    /**
     * List client information in datatable.     
     * @param  $request - input data;
     * @return yajra\Datatables\Datatables
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" title="Edit" data-toggle="tooltip" data-id="' . $row->client_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editClient"> <i class="fa fa fa-edit"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('register', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  App\Http\Requests\StoreClient - validate the input data
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $base64 = '';
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->getRealPath();
            $photo = file_get_contents($path);
            $base64 = base64_encode($photo);
        }
        Client::updateOrCreate(
            ['client_id' => $request->client_id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'photo' => $base64,
            ]
        );

        return redirect()->route('new_client')
            ->with('alert', 'Registration Was Succesful!');
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone', 'photo')->find($id);
        $client->photo = json_encode($client->photo);

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {         
        $p = Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone')
            ->find($request->client_id);
        $p->first_name = $request->first_name;
        $p->last_name = $request->last_name;
        $p->phone = $request->phone;
        $p->address = $request->address;
        $p->email = $request->email;
        
        if (is_file($request->photo)) {
            $photo = file_get_contents($request->photo);
            $base64 = base64_encode($photo);
            $p->photo = $base64;
        } 

        $p->save();
    }   
}
