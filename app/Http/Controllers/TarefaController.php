<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Http\Requests\StoreTarefaRequest;
use App\Http\Requests\UpdateTarefaRequest;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tarefas = Tarefa::all();

        return response()->json(['data' => $tarefas]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTarefaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTarefaRequest $request)
    {
        $data = $request->all();

        $tarefa = Tarefa::create($data);

        return response()->json($tarefa,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarefa = Tarefa::find($id);

        if(!$tarefa){
            return response()->json(['message' =>"Tarefa não encontrado!"],404);
        }

        return response()->json($tarefa);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTarefaRequest  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTarefaRequest $request, $id)
    {
        // Procure o tipo pela id
        $tarefa = Tarefa::find($id);
         
        if (!$tarefa) {
            return response()->json(['message' => 'Tarefa não encontrada!'], 404);
        }

        // Faça o update do tipo
        $tarefa->update($request->all());

        // Retorne o tipo
        return response()->json($tarefa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Procure o tipo pela id
        $tarefa = Tarefa::find($id);
         
        if (!$tarefa) {
            return response()->json(['message' => 'Tarefa não encontrada!'], 404);
        }

        // Faça o update do tipo
        $tarefa->delete();

        // Retorne o tipo
        return response()->json(['message' => 'Tarefa deletada com sucesso!'], 200);
    }
}
