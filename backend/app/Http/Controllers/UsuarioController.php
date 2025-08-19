<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Endereco;
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
            $query->whereBetween('created_at', [
                $request->data_inicio . " 00:00:00",
                $request->data_fim . " 23:59:59"
            ]);
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
            'enderecos' => 'required|array'
        ]);

        $usuario = Usuario::create($request->only(['nome', 'email', 'cpf', 'perfil_id']));

        if ($request->filled('enderecos')) {
            $ids = [];
            foreach ($request->enderecos as $enderecoData) {
                $endereco = Endereco::create($enderecoData);
                $ids[] = $endereco->id;
            }
            $usuario->enderecos()->sync($ids);
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

        // Atualizar / criar endereços
        if ($request->filled('enderecos')) {
            $ids = [];
            foreach ($request->enderecos as $enderecoData) {
                if (isset($enderecoData['id'])) {
                    // Atualiza endereço existente
                    $endereco = Endereco::find($enderecoData['id']);
                    if ($endereco) {
                        $endereco->update($enderecoData);
                        $ids[] = $endereco->id;
                    }
                } else {
                    // Cria novo endereço
                    $endereco = Endereco::create($enderecoData);
                    $ids[] = $endereco->id;
                }
            }
            $usuario->enderecos()->sync($ids);
        }

        return $usuario->load(['perfil', 'enderecos']);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->noContent();
    }
}
