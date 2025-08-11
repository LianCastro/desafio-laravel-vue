<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index()
    {
        return Endereco::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'logradouro' => 'required|string|max:255',
            'cep'        => 'required|string|max:9'
        ]);

        return Endereco::create($request->all());
    }

    public function show(Endereco $endereco)
    {
        return $endereco->load('usuarios');
    }

    public function update(Request $request, Endereco $endereco)
    {
        $request->validate([
            'logradouro' => 'required|string|max:255',
            'cep'        => 'required|string|max:9'
        ]);

        $endereco->update($request->all());
        return $endereco;
    }

    public function destroy(Endereco $endereco)
    {
        $endereco->delete();
        return response()->noContent();
    }
}
