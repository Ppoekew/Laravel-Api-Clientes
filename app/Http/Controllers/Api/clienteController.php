<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class clienteController extends Controller
{
    // Retornamos la lista de Clientes
    public function index()
    {
        // Obtenemos todos los Clientes
        $clientes = Cliente::all();

        // if ($clientes->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron Clientes',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 404);
        // }

        // Retornamos la lista de Clientes
        $data = [
            'clientes' => $clientes,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Creamos un nuevo Cliente
    public function store(Request $request)
    {
        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:cliente',
            'phone' => 'required|digits:10',
            'direction' => 'required|max:255'
        ]);

        // Si la validación falla, retornamos un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Creamos el Cliente
        $cliente = Cliente::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'direction' => $request->direction
        ]);

        // Si no se pudo crear el Cliente, retornamos un mensaje de error
        if (!$cliente) {
            $data = [
                'message' => 'Error al crear el Cliente',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Retornamos el Cliente creado
        $data = [
            'cliente' => $cliente,
            'status' => 201
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 201);

    }

    // Mostramos un Cliente por su ID
    public function show($id)
    {
        // Buscamos el Cliente por su ID
        $cliente = Cliente::find($id);

        // Si no se encontró el Cliente, retornamos un mensaje de error
        if (!$cliente) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Retornamos el Cliente encontrado
        $data = [
            'cliente' => $cliente,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Eliminamos un Cliente por su ID
    public function destroy($id)
    {
        // Buscamos el Cliente por su ID
        $cliente = Cliente::find($id);

        // Si no se encontró el Cliente, retornamos un mensaje de error
        if (!$cliente) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        // Eliminamos el Cliente
        $cliente->delete();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Cliente eliminado',
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Actualizamos un Cliente por su ID
    public function update(Request $request, $id)
    {
        // Buscamos el Cliente por su ID
        $cliente = Cliente::find($id);

        // Si no se encontró el Cliente, retornamos un mensaje de error
        if (!$cliente) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:cliente',
            'phone' => 'required|digits:10',
            'direction' => 'required|max:255'
        ]);

        // Si la validación falla, retornamos un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Actualizamos el Cliente
        $cliente->name = $request->name;
        $cliente->email = $request->email;
        $cliente->phone = $request->phone;
        $cliente->direction = $request->direction;

        // Guardamos los cambios
        $cliente->save();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Cliente actualizado',
            'cliente' => $cliente,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);

    }

    // Actualizamos un campo de un Cliente por su ID
    public function updatePartial(Request $request, $id)
    {   
        // Buscamos el Cliente por su ID
        $cliente = Cliente::find($id);

        // Si no se encontró el Cliente, retornamos un mensaje de error
        if (!$cliente) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:cliente',
            'phone' => 'digits:10',
            'direction' => 'required|max:255'
        ]);

        // Si la validación falla, retornamos un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Actualizamos los campos del Cliente
        if ($request->has('name')) {
            $cliente->name = $request->name;
        }

        if ($request->has('email')) {
            $cliente->email = $request->email;
        }

        if ($request->has('phone')) {
            $cliente->phone = $request->phone;
        }

        if ($request->has('direction')) {
            $cliente->direction = $request->direction;
        }

        // Guardamos los cambios
        $cliente->save();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Cliente actualizado',
            'cliente' => $cliente,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

}