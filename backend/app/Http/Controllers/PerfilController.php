<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        $perfis = Perfil::all();

        return response()->json($perfis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:perfis'
        ]);

        return Perfil::create($request->all());
    }

    public function show(Perfil $perfil)
    {
        return $perfil->load('usuarios');
    }

    public function update(Request $request, Perfil $perfil)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:perfis,nome,' . $perfil->id
        ]);

        $perfil->update($request->all());
        return $perfil;
    }

    public function destroy(Perfil $perfil)
    {
        $perfil->delete();
        return response()->noContent();
    }
}
