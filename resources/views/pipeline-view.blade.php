<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pipeline</title>
    <style>

        .kanban-board {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .kanban-column {
            flex: 1;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-right: 10px; 
        }

        .kanban-column:last-child {
            margin-right: 0; 
        }

        .register-form-container {
            margin-top: 10px;
            text-align: center;
        }

        .register-form {
            display: inline-block;
            text-align: left;
        }

        .register-form input[type="text"] {
            width: calc(100% - 100px);
            padding: 5px;
            margin-bottom: 5px;
        }

        .register-form button {
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .pipeline {
            flex: 1; 
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="kanban-board">
        <!-- para cada pipeline -->
        @foreach ($pipelines as $pipeline)
            <div class="pipeline">
                <h3>{{ $pipeline->nome }}</h3>
                <!-- Formulário para editar o nome da pipeline -->
                <form action="{{ route('pipeline.update', $pipeline->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="new_pipeline_name" placeholder="Novo nome da pipeline" required>
                    <button type="submit">Alterar Nome</button>
                </form>
                <!-- Formulário de exclusão -->
                <form action="{{ route('pipeline.delete', $pipeline->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
                <!-- Verifica se há cards associados a este pipeline -->
                @if ($pipeline->cards)
                    <div class="cards">
                        <h4>Cards:</h4>
                        <!-- Itera os cards deste pipeline -->
                        @foreach ($pipeline->cards as $card)
                            <div class="card">
                                <p>Nome: {{ $card->name }}</p>
                                <p>Descrição: {{ $card->description }}</p>
                                <!-- atualiza a descricao :C -->
                                <form class="register-form" action="{{ route('cards.update', $card->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="new_name" placeholder="Novo nome" required>
                                    <br>
                                    <input name="new_description" placeholder="Nova descrição" required>
<hr>
                                    <button type="submit">Salvar Alterações</button>
                                </form>
                                <br>
                                <br>
                                <!-- deleta a card pobre yugi... :C -->
                                <form class="register-form"  action="{{ route('cards.destroy', $card->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Deletar Card</button>
                                    <br>
                                </form>
                                <br>
                                <br>
                                <!-- move a card para o proximo pipeline -->
                                <form class="register-form" action="{{ route('move-card', $card->id) }}" method="POST">
                                    @csrf
                                    <button type="submit">Mover para Próxima Pipeline</button>
                                    
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- registro dos pipelines -->
    <div class="register-form-container">
        <form class="register-form" action="{{ route('pipeline.create') }}" method="POST">
            @csrf
            <input type="hidden" name="previous_pipeline_id" value="{{ $pipelines->last()->id ?? null }}">
            <input type="text" name="pipeline_name" placeholder="Coloque o nome da Pipeline" required>
            <button type="submit">Criar Pipeline</button>
        </form>
        <!-- registro dos cards -->
        <form class="register-form" action="{{ route('cards.store') }}" method="POST">
            @csrf
            <input type="text" id="name" name="name" placeholder="Coloque o nome do Card" required>
            <input id="description" name="description" placeholder="Descrição do Card" required>
            <button type="submit" value="Create Card">Criar Card</button>
        </form>
    </div>
</body>
</html>
