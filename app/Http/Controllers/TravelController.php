<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Travel;
use App\Http\Requests\StoreTravel;
use DataTables;
use Illuminate\Database\QueryException;

/**
 * @file Controller that contains The Travel Functions.
 * @name TravelController.php
 * @author Juan Sebastiana Maya <jumaya19@gmail.com>
 **/


class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        return view('travel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTravel(Request $request)
    {
        if ($request->ajax()) {
            $data =  Client::select(
                'client_id',
                'first_name',
                'last_name',
                'client.email',
                'phone',
                'travel_date',
                'country',
                'city'
            )
                ->join('travel', 'travel.email', '=', 'client.email')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" title="Delete Client"  
                    data-toggle="tooltip"  data-id="' . $row->client_id .
                        '" data-original-title="Delete" class="btn btn-danger btn-sm deleteClient"><i class="fa fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('travel', compact('data'));
    }


    /**
     * Save the data of travel xml form.
     * @param  App\Http\Requests\StoreTravel - validate the input data
     * @param  $request - input data;
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTravel $request)
    {
        $path = $request->file('xml_travel')->getRealPath();
        $photo = file_get_contents($path);
        $xml = simplexml_load_string($photo);
        $json = json_encode($xml);
        $decode = json_decode($json, true);
        collect($decode);

        foreach ($decode as $de) {
            foreach ($de as $d) {

                if (
                    isset($d['travel_date']) &&
                    isset($d['country']) &&
                    isset($d['city']) &&
                    isset($d['email'])
                ) {
                    try {                       
                        $p = new Travel();
                        $p->travel_date = $d['travel_date'];
                        $p->country = $d['country'];
                        $p->city = $d['city'];
                        $p->email = $d['email'];
                        $p->save();
                    } catch (QueryException $ex) {
                        return redirect()->route('travel')
                        ->withErrors(['errorT' => 'Error while insert data. 
                         Maybe email does not correlates to client information or 
                         uploading the same information. Please verify your file data']);                        
                    }
                } else {
                    return redirect()->route('travel')
                        ->withErrors(['errorT' => 'The structure file does not support. 
                    Please read the helper icon and modify your file data.']);
                }
            }
        }

        return redirect()->route('travel')
            ->with('alert', 'Data loaded Succesfully!');
    }

    /**
     * Delete a client with his travels.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Client::find($id)->delete();
        return response()->json("Deleted succesfully", 202);
    }
}
