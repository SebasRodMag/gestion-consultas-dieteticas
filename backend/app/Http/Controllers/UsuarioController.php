<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioController extends Controller
{
    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'dni_usuario' => 'required|string|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string',
            'rol' => 'required|in:paciente,especialista',
            'password' => 'required|string|min:6',
        ]);

        $usuario = Usuario::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'dni_usuario' => $validated['dni_usuario'],
            'email' => $validated['email'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'telefono' => $validated['telefono'],
            'password' => bcrypt($validated['password']),
        ]);
        
        $usuario->assignRole($validated['rol']);

        return response()->json(['message' => 'Usuario creado'], 201);
    }

    // Obtener todos los usuarios(Incluso los eliminados)
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Obtener todos los usuarios eliminados
    public function indexEliminados()
    {
        $usuarios = Usuario::onlyTrashed()->get();
        return response()->json($usuarios);
    }

    // Obtener todos los usuarios activos
    public function indexActivos()
    {
        $usuarios = Usuario::withTrashed()->get();
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
            $usuario->syncRoles($request->rol);
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

    public function restore($id)
    {
        $modelo = Modelo::withTrashed()->findOrFail($id);
        $modelo->restore();
        return response()->json(['message' => 'Registro restaurado']);
    }
}
