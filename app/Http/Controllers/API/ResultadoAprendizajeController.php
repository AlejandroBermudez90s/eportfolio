<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResultadoAprendizajeResource;
use App\Models\ModuloFormativo;
use App\Models\ResultadoAprendizaje;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class ResultadoAprendizajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ModuloFormativo $moduloFormativo)
    {
        $query = ResultadoAprendizaje::query();

        if($query) {
            $query->orWhere('nombre', 'like', '%' .$request->search . '%');
        }

        return ResultadoAprendizajeResource::collection(
            $query
                ->where('modulo_formativo_id', $moduloFormativo->id)
                ->orderBy($request->sort ?? 'id', $request->order ?? 'asc')
                ->paginate($request->per_page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ModuloFormativo $moduloFormativo)
    {
        //$resultado = json_decode($request->getContent(), true);
        $resultadoAprendizaje = $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'peso_porcentaje' => 'required',
            'orden' => 'required'
        ]);

        $resultadoAprendizaje['modulo_formativo_id'] = $moduloFormativo->id;
        $resultadoAprendizaje = ResultadoAprendizaje::create($resultadoAprendizaje);

        return new ResultadoAprendizajeResource($resultadoAprendizaje);
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultadoAprendizaje $resultadoAprendizaje, ModuloFormativo $moduloFormativo)
    {
        abort_if($resultadoAprendizaje->modulo_formativo_id !== $moduloFormativo->id, 404);

        return new ResultadoAprendizajeResource($resultadoAprendizaje);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResultadoAprendizaje $resultadoAprendizaje, ModuloFormativo $moduloFormativo)
    {
        abort_if($resultadoAprendizaje->modulo_formativo_id !== $moduloFormativo->id, 404);

        $resultadoAprendizajeData = json_decode($request->getContent(), true);

        $resultadoAprendizaje->update($resultadoAprendizajeData);

        return new ResultadoAprendizajeResource($resultadoAprendizaje);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultadoAprendizaje $resultadoAprendizaje, ModuloFormativo $moduloFormativo)
    {
        abort_if($resultadoAprendizaje->modulo_formativo_id !== $moduloFormativo->id, 404);

        try {
            $resultadoAprendizaje->delete();
            return response()
                    ->json([
                        'message' => 'Resultado de Aprendizaje eliminado correctamente'
                    ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
