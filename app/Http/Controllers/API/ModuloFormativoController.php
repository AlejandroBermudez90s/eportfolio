<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuloFormativoResource;
use App\Models\ModuloFormativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuloFormativoController extends Controller
{
    public function index(Request $request, $cicloId)
    {
        $query = ModuloFormativo::where('id', $cicloId);

        if ($query) {
            $query->orWhere('nombre', 'like', '%' .$request->search . '%');
        }

        return ModuloFormativoResource::collection(
            $query
                ->orderBy($request->sort ?? 'id', $request->order ?? 'asc')
                ->paginate($request->per_page)
        );
    }

    public function modulosImpartidos(Request $request, $cicloId, User $user)
    {
        $user = Auth::user();

        return ModuloFormativoResource::collection(
            ModuloFormativo::where('docente_id', $user->id)
                ->where('ciclo_formativo_id', $cicloId)
                ->orderBy($request->sort ?? 'id', $request->order ?? 'asc')
                ->paginate($request->per_page)
        );
    }

    public function store(Request $request, $cicloId, User $user)
    {
        //$data = json_decode($request->getContent(), true);

        $data = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'horas_totales' => 'required',
            'curso_escolar' => 'required',
            'centro' => 'required',
            'descripcion' => 'required'
        ]);

        $data['ciclo_formativo_id'] = $cicloId;
        $data['docente_id'] = $user->id;

        $modulo = ModuloFormativo::create($data);

        return new ModuloFormativoResource($modulo);
    }

    public function show($cicloId, ModuloFormativo $moduloFormativo)
    {
        if ($moduloFormativo->ciclo_formativo_id != $cicloId) {
            abort(404);
        }

        return new ModuloFormativoResource($moduloFormativo);
    }

    public function update(Request $request, $cicloId, ModuloFormativo $moduloFormativo)
    {
        if ($moduloFormativo->ciclo_formativo_id != $cicloId) {
            abort(404);
        }

       // $data = json_decode($request->getContent(), true);

        $data = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'horas_totales' => 'required',
            'curso_escolar' => 'required',
            'centro' => 'required',
            'descripcion' => 'required'
        ]);

        $data['ciclo_formativo_id'] = $cicloId;

        $moduloFormativo->update($data);

        return new ModuloFormativoResource($moduloFormativo);
    }

    public function destroy($cicloId, ModuloFormativo $moduloFormativo)
    {
        if ($moduloFormativo->ciclo_formativo_id != $cicloId) {
            abort(404);
        }

        try {
            $moduloFormativo->delete();
            return response()
                   ->json([
                    'message' => 'ModuloFormativo eliminado correctamente'
                 ]);;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
