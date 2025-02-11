<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\studentController;

class studentController extends Controller
{
    // Retornamos la lista de estudiantes
    public function index()
    {
        // Obtenemos todos los estudiantes
        $students = Student::all();

        // if ($students->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron estudiantes',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 404);
        // }

        // Retornamos la lista de estudiantes
        $data = [
            'students' => $students,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Creamos un nuevo estudiante
    public function store(Request $request)
    {
        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
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

        // Creamos el estudiante
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);

        // Si no se pudo crear el estudiante, retornamos un mensaje de error
        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Retornamos el estudiante creado
        $data = [
            'student' => $student,
            'status' => 201
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 201);

    }

    // Mostramos un estudiante por su ID
    public function show($id)
    {
        // Buscamos el estudiante por su ID
        $student = Student::find($id);

        // Si no se encontró el estudiante, retornamos un mensaje de error
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Retornamos el estudiante encontrado
        $data = [
            'student' => $student,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Eliminamos un estudiante por su ID
    public function destroy($id)
    {
        // Buscamos el estudiante por su ID
        $student = Student::find($id);

        // Si no se encontró el estudiante, retornamos un mensaje de error
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        // Eliminamos el estudiante
        $student->delete();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);
    }

    // Actualizamos un estudiante por su ID
    public function update(Request $request, $id)
    {
        // Buscamos el estudiante por su ID
        $student = Student::find($id);

        // Si no se encontró el estudiante, retornamos un mensaje de error
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
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

        // Actualizamos el estudiante
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        // Guardamos los cambios
        $student->save();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        // Retornamos un mensaje de éxito
        return response()->json($data, 200);

    }

    // Actualizamos un campo de un estudiante por su ID
    public function updatePartial(Request $request, $id)
    {   
        // Buscamos el estudiante por su ID
        $student = Student::find($id);

        // Si no se encontró el estudiante, retornamos un mensaje de error
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French'
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

        // Actualizamos los campos del estudiante
        if ($request->has('name')) {
            $student->name = $request->name;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }

        if ($request->has('language')) {
            $student->language = $request->language;
        }

        // Guardamos los cambios
        $student->save();

        // Retornamos un mensaje de éxito
        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

}