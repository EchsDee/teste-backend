<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(Request $request)
    {
        // Valida as informações da view
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // acha o primeiro pipeline da database
        $firstPipeline = Pipeline::first();
    
        // Cria o novo card com associação a nova pipeline
        $card = new Card();
        $card->name = $validatedData['name'];
        $card->description = $validatedData['description'];
        $card->pipeline_id = $firstPipeline->id; 
        $card->save();
    
        // retorna a view
        return redirect()->route('pipeline.view')->with('success', 'card criado');
    }
    

    public function show($id)
    {
        // Find the card by ID
        $card = Card::findOrFail($id);

        // Return the card
        return response()->json(['card' => $card]);
    }

    public function update(Request $request, $id)
    {
        // Valida as informações da view
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // Encontra o card pelo ID
        $card = Card::findOrFail($id);
    
        // Atualiza o nome e a descrição do card
        $card->name = $validatedData['name'];
        $card->description = $validatedData['description'];
        $card->save();
    
        // Retorna uma resposta de sucesso
        return redirect()->route('pipeline.view')->with('success', 'card atualizado com sucesso');
    }
    

    public function destroy($id)
    {
        // acha o card pelo id
        $card = Card::findOrFail($id);
        $card->delete();

        // atualiza view
        return redirect()->route('pipeline.view')->with('success', 'card excluido com sucesso');
    }

    public function moveToNextPipeline($id)
{
    // Encontrar a carta pelo ID
    $card = Card::findOrFail($id);

    // Obter o ID da próxima pipeline
    $nextPipelineId = $card->pipeline->next_pipeline_id;

    // Verificar se há uma próxima pipeline
    if ($nextPipelineId) {
        // Atualizar a pipeline da carta para a próxima pipeline
        $card->pipeline_id = $nextPipelineId;
        $card->save();

        // Redirecionar de volta para a página anterior
        return redirect()->back()->with('success', 'Card movido para a próxima pipeline com sucesso.');
    } else {
        // Não há próxima pipeline, mostrar mensagem de erro
        return redirect()->back()->with('error', 'Não há próxima pipeline disponível para mover o card.');
    }
}
}