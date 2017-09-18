<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Device;

class ApiController extends Controller
{
    /**
     * Creates a json response for all the devices.
     *
     * @return Response
     */    
    public function index()
    {
        $devices = Device::all();
        return response()->json($devices, 200);
    }

    /**
     * Creates a json response for a specifc device.
     *
     * @param  Device  $device
     * @return Response
     */    
    public function show(Device $device)
    {
        return response()->json($device, 200);
    }

    /**
     * Updates the status of a device.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'uuid'          => 'required|string|max:255|exists:devices,uuid',
            'token'         => 'required|string|max:60',
            'version'       => 'nullable|string|max:32',
            'hostname'      => 'nullable|string|alpha_num|max:255',
            'ip'            => 'nullable|ip',
            'mac_address'   => 'nullable|string|min:16|max:16',
            'time'          => 'nullable|date',
            'cover_status'  => 'nullable|string|max:32',
            'error_msg'     => 'nullable|string',
            'limitsw_open'   => 'nullable|boolean',
            'limitsw_closed' => 'nullable|boolean',
            'light_in'      => 'nullable|numeric',
            'light_out'     => 'nullable|numeric',
            'cpu_temp'      => 'nullable|numeric',
            'temperature'   => 'nullable|numeric',
            'humidity'      => 'nullable|numeric',
        ]);
        
        // If validation fails, send the validation error back with status 400
        if ($validator->fails()) {
            return response()->json(['data' => $validator->toArray()], 400);
        }
        
        // Get the device record
        $device = Device::where('uuid', $request->input('uuid'))->first();
        
        // If token doesnt match then send 401 unauthorized.
        if ($request->input('token') != $device->token) {
            return response()->json(['data' => 'Bad token.'], 401);
        }
        
        // Update the device
        $device->version = $request->input('version');
        $device->hostname = $request->input('hostname');
        $device->ip = $request->input('ip');
        $device->mac_address = $request->input('mac_address');
        $device->time = $request->input('time');
        $device->cover_status = $request->input('cover_status');
        $device->error_msg = $request->input('error_msg');
        $device->limitsw_open = $request->input('limitsw_open');
        $device->limitsw_closed = $request->input('limitsw_closed');
        $device->light_in = $request->input('light_in');
        $device->light_out = $request->input('light_out');
        $device->cpu_temp = $request->input('cpu_temp');
        $device->temperature = $request->input('temperature');
        $device->humidity = $request->input('humidity');
        
        $device->save();
        
        // Create an api token for the new device.
        $device->generateToken();
        
        // A 'Registered' event is created and will trigger any relevant
        // observers, such as sending a confirmation email or any 
        // code that needs to be run as soon as the device is created.
        //event(new Registered(true));
        
        // Return the new device info including the token.
        return response()->json(['data' => $device->toArray()], 201);
    }
    
    /**
     * Registers a new device.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string|max:255',
            'challenge' => 'required|string|min:6',
        ]);
        
        // If validation fails, send the validation error back with status 400
        if ($validator->fails()) {
            return response()->json(['data' => $validator->toArray()], 400);
        }
        
        // If challenge string doesnt match then send 401 unauthorized.
        if ($request->input('challenge') != 'temppass') {
            return response()->json(['data' => 'Bad challenge.'], 401);
        }
        
        // If the uuid already exists then just send them the record.
        if ($device = Device::where('uuid', $request->input('uuid'))->first()) {
            return response()->json([ 'data' => [ 
                'name' => $device->name,
                'uuid' => $device->uuid,
                'id' => $device->id,
                'token' => $device->token,
            ]], 200);
        }
        
        // Create the new device
        $device = new Device;
        $device->name = 'New Device';
        $device->uuid = $request->input('uuid');
        $device->save();
        
        // Create an api token for the new device.
        $device->generateToken();
        
        // A 'Registered' event is created and will trigger any relevant
        // observers, such as sending a confirmation email or any 
        // code that needs to be run as soon as the device is created.
        //event(new Registered(true));
        
        // Return the new device info including the token.
        return response()->json([ 'data' => [ 
            'name' => $device->name,
            'uuid' => $device->uuid,
            'id' => $device->id,
            'token' => $device->token,
        ]], 201);
    }
}

// HTTP STATUS CODES:
// 200: OK. The standard success code and default option.
// 201: Object created. Useful for the store actions.
// 204: No content. When an action was executed successfully, but there is no content to return.
// 206: Partial content. Useful when you have to return a paginated list of resources.
// 400: Bad request. The standard option for requests that fail to pass validation.
// 401: Unauthorized. The user needs to be authenticated.
// 403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
// 404: Not found. This will be returned automatically by Laravel when the resource is not found.
// 500: Internal server error. Ideally you're not going to be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
// 503: Service unavailable. Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.