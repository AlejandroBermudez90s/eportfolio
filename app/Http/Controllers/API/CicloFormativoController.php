<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CicloFormativoResource;
use App\Models\CicloFormativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CicloFormativoController extends Controller
{
    public function index(Request $request, $familiaId)
    {
        $query = CicloFormativo::where('id', $familiaId);

        if ($query) {
            $query->orWhere('nombre', 'like', '%' .$request->search . '%');
        }

        return CicloFormativoResource::collection(
            $query->orderBy(
                $request->sort ?? 'id',
                $request->order ?? 'asc'
            )->paginate($request->per_page)
        );
    }

    public function store(Request $request, $familiaId)
    {
        //$data = json_decode($request->getContent(), true);

        abort_if ($request->user()->cannot('create', CicloFormativo::class), 403);

        $data = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:ciclos_formativos,codigo',
            'grado' => 'required|in:basico,medio,superior',
            'descripcion' => 'required'
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
        abort_if ($request->user()->cannot('update', $cicloFormativo), 403);

        if ($cicloFormativo->familia_profesional_id != $familiaId) {
            abort(404);
        }

        $data = json_decode($request->getContent(), true);
        $data['familia_profesional_id'] = $familiaId;

        $cicloFormativo->update($data);

        return new CicloFormativoResource($cicloFormativo);
    }

    public function destroy(Request $request, $familiaId, CicloFormativo $cicloFormativo)
    {
        abort_if ($request->user()->cannot('delete', $cicloFormativo), 403);

        if ($cicloFormativo->familia_profesional_id != $familiaId) {
            abort(404);
        }

        try {
            $cicloFormativo->delete();
            return response()
                 ->json([
                     'message' => 'CicloFormativo eliminado correctamente'
                 ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
