<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with(['perfil', 'enderecos']);

        // Filtros
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('cpf')) {
            $query->where('cpf', $request->cpf);
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('created_at', [$request->data_inicio, $request->data_fim]);
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'email'     => 'required|email|unique:usuarios',
            'cpf'       => 'required|string|max:14|unique:usuarios',
            'perfil_id' => 'required|exists:perfis,id',
            'enderecos' => 'array'
        ]);

        $usuario = Usuario::create($request->only(['nome', 'email', 'cpf', 'perfil_id']));

        if ($request->filled('enderecos')) {
            $usuario->enderecos()->sync($request->enderecos);
        }

        return $usuario->load(['perfil', 'enderecos']);
    }

    public function show(Usuario $usuario)
    {
        return $usuario->load(['perfil', 'enderecos']);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'email'     => 'required|email|unique:usuarios,email,' . $usuario->id,
            'cpf'       => 'required|string|max:14|unique:usuarios,cpf,' . $usuario->id,
            'perfil_id' => 'required|exists:perfis,id',
            'enderecos' => 'array'
        ]);

        $usuario->update($request->only(['nome', 'email', 'cpf', 'perfil_id']));

        if ($request->filled('enderecos')) {
            $usuario->enderecos()->sync($request->enderecos);
        }

        return $usuario->load(['perfil', 'enderecos']);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->noContent();
    }
}
