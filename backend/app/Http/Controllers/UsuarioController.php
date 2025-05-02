<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'dni_usuario' => 'required|string|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string',
            'rol' => 'required|in:paciente,especialista',
        ]);

        $usuario = Usuario::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $usuario->assignRole('paciente');

        return response()->json(['message' => 'Usuario creado'], 201);
    }

    // Obtener todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Obtener un usuario específico
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string',
            'apellidos' => 'sometimes|required|string',
            'dni_usuario' => 'sometimes|required|string|unique:usuarios,dni_usuario,' . $id,
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'fecha_nacimiento' => 'sometimes|required|date',
            'telefono' => 'sometimes|required|string',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'apellidos' => $request->apellidos,
            'dni_usuario' => $request->dni_usuario,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
        ]);

        if ($request->has('rol')) {
            $user->syncRoles($request->rol); // Cambia su rol si se especifica
        }

        return response()->json(['message' => 'Usuario actualizado'], 200);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado']);
    }
}
