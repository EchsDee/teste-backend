<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\View\View
     */
    public function showView()
    {
        //exibe a view dos pipelines em ordem de id
        $pipelines = Pipeline::orderBy('id')->get();
        return view('pipeline-view', compact('pipelines'));
    }
    


    public function showKanbanBoard()
    {
        // junta os pipelines do database
        $pipelines = Pipeline::all();

        // organiza eles como se fossem colunas do kanban
        $column1Pipelines = $pipelines->where('column', 1)->values();
        $column2Pipelines = $pipelines->where('column', 2)->values();
        $column3Pipelines = $pipelines->where('column', 3)->values();

        // Ppassa as infos pra view
        return view('kanban-board', compact('column1Pipelines', 'column2Pipelines', 'column3Pipelines'));
    }
    public function create(Request $request)
    {
        // Valida as informações da view
        $validatedData = $request->validate([
            'pipeline_name' => 'required|string|max:255',
            'previous_pipeline_id' => 'nullable|exists:pipelines,id',
        ]);
    
        // Cria a pipeline com as informações
        $pipeline = new Pipeline();
        $pipeline->nome = $validatedData['pipeline_name'];
    
        // saçva
        $pipeline->save();
    
        // se uma pipeline anterior existir seta o "next_pipeline_id" como o id desta nova criada.
        if ($validatedData['previous_pipeline_id']) {
            $previousPipeline = Pipeline::find($validatedData['previous_pipeline_id']);
            if ($previousPipeline) {
                $previousPipeline->next_pipeline_id = $pipeline->id;
                $previousPipeline->save();
                $pipeline->previous_pipeline_id = $previousPipeline->id;
            }
        }
    
        // salva a atualização
        $pipeline->save();
    
        // atualiza a pagina.
        return redirect()->route('pipeline.view')->with('success', 'pipeline criada com sucesso.');
    }
    
    public function delete($id)
    {
        // Encontrar o pipeline a ser excluído
        $pipeline = Pipeline::findOrFail($id);
    
        // Encontrar os pipelines anterior e posterior ao pipeline a ser excluído
        $previousPipeline = Pipeline::where('next_pipeline_id', $id)->first();
        $nextPipeline = Pipeline::find($pipeline->next_pipeline_id);
    
        // Atualiza os next_pipeline_id e previous_pipeline_id
        if ($previousPipeline) {
            $previousPipeline->next_pipeline_id = $pipeline->next_pipeline_id;
            $previousPipeline->save();
        }
    
        if ($nextPipeline) {
            $nextPipeline->previous_pipeline_id = $pipeline->previous_pipeline_id;
            $nextPipeline->save();
        }
    
        // Excluir o pipeline
        $pipeline->delete();
    
        // atualiza a pagina.
        return redirect()->route('pipeline.view')->with('success', 'pipeline deletada com sucesso.');
    }
    public function update(Request $request, $id)
    {
        // Valida os dados recebidos do formulário
        $validatedData = $request->validate([
            'new_pipeline_name' => 'required|string|max:255',
        ]);

        // Encontra a pipeline pelo ID
        $pipeline = Pipeline::findOrFail($id);

        // Atualiza o nome da pipeline
        $pipeline->nome = $validatedData['new_pipeline_name'];
        $pipeline->save();

        // atualiza a pagina. com retorno de sucesso.
        return redirect()->route('pipeline.view')->with('success', 'Nome da pipeline atualizado com sucesso.');
    }
    
    
}
    
    
    

