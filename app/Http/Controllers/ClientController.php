<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientLog;

class ClientController extends Controller
{
    // 1. Lista de clientes regustrados
    public function index()
    {

        $clients = Client::select('id', 'sharedkey', 'businessid', 'email', 'phone', 'created_at', 'start_at', 'end_at')
                        ->get();      

        return response()->json([ 'clients' => $clients ]);

    }

    // 2. Buscar cliente
    public function search(Request $request, $id)
    {
       
        $search= Client::select('sharedkey', 'businessid', 'email', 'phone', 'created_at', 'start_at', 'end_at')
                    ->orWhere('sharedkey', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->get();

        return response()->json([ 'search' => $search ]);

    }

    // 3. Registrar cliente
    public function store(ClientRequest $request)
    {

        // Datos obtenidos desde la interfaz para registrar el cliente
        $data = [

            'sharedkey' => $request->sharedkey, 
            'businessid' => $request->businessid,
            'email' => $request->email,
            'phone' => $request->phone, 
            'start_at' => $request->start_at, 
            'end_at' => $request->end_at,

        ];

        // Registrar cliente
        $created = Client::create($data);

        // Comprobar que el cliente ha sido registrado
        if($created){

            // cliente registrado
            return response()->json(['success' => 'Cliente registrado exitosamente'], 200);
        }
        else{

            return response()->json(['error' => 'El registro no ha podido ser llevado a cabo'], 500);

        }
       

    }

    // 4. Actualizar tarea
    public function update(ClientRequest $request, $id)
    {

        // Obtener el cliente a actualizar
        $client = Client::findOrFail($id);

        // Datos obtenidos desde la interfaz para registrar el cliente
        $data = [

            'sharedkey' => $request->sharedkey, 
            'businessid' => $request->businessid,
            'email' => $request->email,
            'phone' => $request->phone, 
            'start_at' => $request->start_at, 
            'end_at' => $request->end_at,

        ];

        // confirmar si los datos del cliente han sido actualizados
      
        // Actualziar cliente
        $update = $client->update($data);

        // Comprobar que el cliente ha sido actualziado
        if($update){

            // cliente actualiado
            return response()->json(['success' => 'Cliente actualizado exitosamente'], 200);
        }
        else{

            return response()->json(['error' => 'La actualización del cliente no ha podido ser llevada a cabo'], 500);

        }

    }

    //5. Obtener logs client
    function logsClient()
    {

        $logsClient = ClientLog::select('clientName', 'action', 'client_id', 'created_at', 'updated_at')
                                ->get();

        return response()->json(['logsClient' => $logsClient]);

    }
}
