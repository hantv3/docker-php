<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviveController extends Controller
{
    //
    function getAll()
    {
        $devices = Device::all();
        return $devices;
    }

    function getById($id)
    {
        $device = Device::where('id', $id)
            ->get();
        return $device;
    }

    function addNewDevice(Request $req)
    {
        $device = new Device();
        $device->name = $req->name;
        $device->member_id = $req->member_id;
        $result = $device->save();

        if ($result) {
            return ['Result' => 'Data has been saved'];
        } else {
            return ['Result' => 'Operation failed'];
        }
    }

    function updateDevice(Request $req)
    {
        $device = Device::where('id', $req->id)->first();
        $device->name = $req->name;
        $device->member_id = $req->member_id;
        $result = $device->save();
        if ($result) {
            return ['Result' => 'Data is update'];
        } else {
            return ['Result' => 'Operation failed'];
        }
    }

    function searchDevice(Request $req)
    {
        $device = Device::where('name', 'like', $req->keyword . '%')->orWhere('id', '=', $req->keyword)->get();
        return $device;
    }

    function delete(Request $req)
    {
        $device = Device::where('id', '=', $req->id);
        $result = $device->delete();
        if ($result) {
            return ['Result' => 'Successful delete'];
        } else {
            return ['Result' => 'Operation failed'];
        }
    }
}