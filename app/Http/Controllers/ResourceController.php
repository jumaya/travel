<?php

namespace App\Http\Controllers;

use App\Client;
use App\Travel;
use Illuminate\Http\Request;
use Exception;

/**
* @file Controller that contains the Client and Travel Functions using Postman 
* @name ResourceController.php
* @author Juan Sebastiana Maya <jumaya19@gmail.com>
**/

class ResourceController extends Controller
{
    /**
     * Display list of clients and filtering the info
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFilterClient(Request $request)
    {
        $client = Client::filtroClient($request->get('data'));
        return response()->json($client);
    }

    /**
     * Display the clients list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClient()
    {
        $data = Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone')->get();
        return response()->json($data);
    }

    /**
     * Save a client with his information and return response json.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeClient(Request $request)
    {
        try {
            $p = new Client();
            $p->first_name = $request->input('first_name');
            $p->last_name = $request->input('last_name');
            $p->phone = $request->input('phone');
            $p->address = $request->input('address');
            $p->email = $request->input('email');
            $photo = $request->input('photo');;
            $base64 = base64_encode($photo);
            $p->photo = $base64;
            $p->save();
            return response()->json("Saved succefully", 202);
        } catch (Exception $e) {
            return response()->json("Error", $e);
        }
    }

    /**
     * Display a client data sending client_id;
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findClientById(Request $request)
    {
        $data = Client::select('client_id', 'first_name', 'last_name', 'email', 'address', 'phone')->find($request->get('data'));
        $data->photo = json_encode($data->photo);
        $data->photo = json_decode($data->photo, true);
        return response()->json($data);
    }

     /**
     * Display a client data sending his phone;
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findClientByPhone(Request $request)
    {
        $data = Client::getClientByPhone($request->get('data'));
        return response()->json($data);
    }

    /**
     * Delete a client with his travel sendin the client_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteClient(Request $request)
    {
        try {
            $data =  Client::find($request->input('id'))->delete();
            return response()->json("Deleted succesfully", 202);
        } catch (Exception $e) {
            return response()->json("Error", $e);
        }
    }

    /**
     * Load a xml file and save the travel's information of a determinate client.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function xmlTravel(Request $request)
    {
        $path = $request->file('xml_travel')->getRealPath();
        
        $photo = file_get_contents($path);
        $xml = simplexml_load_string($photo);
        $json = json_encode($xml);
        $decode = json_decode($json, true);
        collect($decode);
                
        try {
            foreach ($decode as $de) {
                foreach ($de as $d) {
                    $p = new Travel();
                    $p->travel_date = $d['fecha_de_viaje'];
                    $p->country = $d['pais'];
                    $p->city = $d['ciudad'];
                    $p->email = $d['email'];
                    $p->save();
                }
            }
            return response()->json("Data saved succesfully", 202);
        } catch (Exception $e) {
            return response()->json("Error", $e);
        }        
    }

    /**
     * Load a xml file and save the travel's information of a determinate client.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTravelList()
    {
        $data = Travel::all();
        return response()->json($data);
    }

   /**
     * Usin method Eloquen to gen clients and his travels.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTravelByClientId(Request $request)
    {
        $data = Client::getClientAndTravel($request->get('data'));
        return response()->json($data);
    }

     /**
     * Display a client data sending his phone;
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function prueba(Request $request)
    {
        $data = Client::getClientByPhone($request->get('data'));
        return response()->json($data);
    }
}