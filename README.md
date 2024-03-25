
## Projeto prático back-end

Este projeto foi desenvolvido com o intuito habilidades básicas com php/laravel + Eloquent, banco de dados.

desenvolvido nele um pipeline em forma de linha de tempo com o controle de cards.

## executando o projeto

instalar as dependencias do ambiente de execução.
- **[postgresql](https://www.postgresql.org/download/)**
- **[composer](https://getcomposer.org/download/)**
- **[php](https://www.php.net/downloads.php)**


após a clonagem do git rodar o projeto utilizando os comandos 
- composer install - para que o composer instale as dependencias
- php artisan migrate - para que o artisan migre as informações da base postgresql
- php artisan serve = para que o serviço seja iniciado.

para um "ease of use" deixei um arquivo .bat "start.bat" junto ao projeto que vai executar os 3 comandos.
ajustar o .env de acordo com a instalação de sua database postgresql por padrao esta:

DB_DATABASE=teste-backend


DB_USERNAME=postgres


DB_PASSWORD=Encore123



## funcionamento do login/register usando o auth2 "google api"

utilizando o cadastro/ login via google depende da hash secret da google api e como o git esta publico e o hash seria um dado sensivel e esta censurada no .env. seria necessario a geração de uma nova hash pelo [painel de controle](https://console.cloud.google.com) dos apis da google e informado no .env do projeto, mas caso necessario só pedir que fornecerei o que utilizei no projeto.

## acesso e utilização 
acesse
http://localhost:8000/login ao acessar faça login ou selecione a opção de registro.

![alt text](image-1.png)
## acesse a view Pipeline
![alt text](image-5.png)
## aqui fica o controle dos pipelines e views
![alt text](image-6.png)


