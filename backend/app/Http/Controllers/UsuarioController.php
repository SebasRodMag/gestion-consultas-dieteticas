<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    // Listar todos los usuarios (activos y eliminados)
    public function index()
    {
        $usuarios = Usuario::withTrashed()->paginate(10);
        return response()->json($usuarios);
    }

    // Listar usuarios eliminados (solo soft-deleted)
    public function indexEliminados()
    {
        $usuarios = Usuario::onlyTrashed()->paginate(10);
        return response()->json($usuarios);
    }

    // Listar usuarios activos
    public function indexActivos()
    {
        $usuarios = Usuario::paginate(10); // No incluye eliminados
        return response()->json($usuarios);
    }

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

        Log::create([
            'usuario_id' => Auth::id(),
            'accion' => 'Creación de usuario',
            'descripcion' => "Usuario {$usuario->email} creado con rol {$validated['rol']}"
        ]);

        return response()->json(['message' => 'Usuario creado'], 201);
    }

    // Mostrar un usuario por ID
    public function show($id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $this->authorize('view', $usuario);
        return response()->json($usuario);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $this->authorize('update', $usuario);

        $request->validate([
            'nombre' => 'sometimes|required|string',
            'apellidos' => 'sometimes|required|string',
            'dni_usuario' => 'sometimes|required|string|unique:usuarios,dni_usuario,' . $id,
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'fecha_nacimiento' => 'sometimes|required|date',
            'telefono' => 'sometimes|required|string',
            'rol' => 'sometimes|required|in:paciente,especialista',
        ]);

        $usuario->update($request->only([
            'nombre', 'apellidos', 'dni_usuario', 'email', 'fecha_nacimiento', 'telefono'
        ]));

        if ($request->filled('rol')) {
            $usuario->syncRoles($request->rol);
        }

        Log::create([
            'usuario_id' => Auth::id(),
            'accion' => 'Actualización de usuario',
            'descripcion' => "Usuario con ID {$id} actualizado"
        ]);

        return response()->json(['message' => 'Usuario actualizado']);
    }

    // Eliminar (soft delete)
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $this->authorize('delete', $usuario);
        $usuario->delete();

        Log::create([
            'usuario_id' => Auth::id(),
            'accion' => 'Eliminación de usuario',
            'descripcion' => "Usuario con ID {$id} eliminado (soft delete)"
        ]);

        return response()->json(['message' => 'Usuario: ' . $$usuario->nombre . ' ' . $usuario->apellidos . ' eliminado.']);
    }

    // Restaurar usuario eliminado
    public function restore($id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $this->authorize('restore', $usuario);
        if (!$usuario->trashed()) {
            return response()->json(['message' => 'El usuario no está eliminado'], 400);
        }

        $usuario->restore();

        Log::create([
            'usuario_id' => Auth::id(),
            'accion' => 'Restauración de usuario',
            'descripcion' => "Usuario con ID {$id} restaurado"
        ]);

        return response()->json(['message' => 'Usuario: ' . $$usuario->nombre . ' ' . $usuario->apellidos . ' restaurado.']);
    }

    // Perfil del usuario autenticado
    public function miPerfil()
    {
        return response()->json(Auth::user());
    }

    // Actualizar perfil autenticado
    public function actualizarPerfil(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'nombre' => 'sometimes|required|string',
            'apellidos' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'sometimes|required|string',
            'fecha_nacimiento' => 'sometimes|required|date',
        ]);

        $usuario->update($request->only([
            'nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento'
        ]));

        Log::create([
            'usuario_id' => $usuario->id,
            'accion' => 'Actualización de perfil',
            'descripcion' => "Perfil del usuario actualizado"
        ]);

        return response()->json(['message' => 'Perfil actualizado', 'usuario' => $usuario]);
    }
}
