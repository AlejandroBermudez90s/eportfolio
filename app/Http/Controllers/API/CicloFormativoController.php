<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CicloFormativoResource;
use App\Models\CicloFormativo;
use Illuminate\Http\Request;

class CicloFormativoController extends Controller
{
    public function index(Request $request, $familiaId)
    {
        $query = CicloFormativo::where('id', $request->id);

        if ($query) {
            $query->orWhere('nombre', 'like', '%' .$request->search . '%');
        }

        return CicloFormativoResource::collection(
            $query->where('familia_profesional_id', $familiaId)
                ->orderBy($request->sort ?? 'id', $request->order ?? 'asc')
                ->paginate($request->per_page)
        );
    }

    public function store(Request $request, $familiaId)
    {
        //$data = json_decode($request->getContent(), true);

        $data = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:familias_profesionales,codigo',
            'descripcion' => 'required',
        ]);

        $data['familia_profesional_id'] = $familiaId;

        $ciclo = CicloFormativo::create($data);

        return new CicloFormativoResource($ciclo);
    }

    public function show($familiaId, CicloFormativo $cicloFormativo)
    {
        if ($cicloFormativo->familia_profesional_id != $familiaId) {
            abort(404);
        }

        return new CicloFormativoResource($cicloFormativo);
    }

    public function update(Request $request, $familiaId, CicloFormativo $cicloFormativo)
    {
        if ($cicloFormativo->familia_profesional_id != $familiaId) {
            abort(404);
        }

        $data = json_decode($request->getContent(), true);
        $data['familia_profesional_id'] = $familiaId;

        $cicloFormativo->update($data);

        return new CicloFormativoResource($cicloFormativo);
    }

    public function destroy($familiaId, CicloFormativo $cicloFormativo)
    {
        if ($cicloFormativo->familia_profesional_id != $familiaId) {
            abort(404);
        }

        try {
            $cicloFormativo->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
