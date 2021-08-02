# Core-Coding-Assinaturas-Digitais

## Resumo
Um Web App(api + UI) que permite coletar assinaturas digitalmente. O usuário é capaz de fazer upload de um PDF (modelo único), entrar com os dados dos assinantes e ser redirecionado para assinar através da tela do dispositivo. O sistema possibilita o acompanhamento da situação das assinaturas e baixar o documento assinado.

## Recursos
1. Cadastro, edição, remoção e listagem de documentos
2. Assinatura do documento por meio de um '*signature pad*'
3. Download do documento como PDF com os dados preenchidos e assinado

## Tecnologias
* Laravel 6 (PHP)
* Vue.js 2 (JavaScript)
* Bootstrap 4.3
* Docker (Virtualização por meio de containers)
* MySQL (Banco de Dados)

## Instruções
* Utilizar os dados do arquivo .env.example para configuração
> Caso problema de conexão com o db ao rodar as migrations, trocar o campo DB_HOST para 0.0.0.0

* Containers Docker:
```
docker-compose up -d
```

* Vue:
```
npm run watch
```

* Migrations
```
php artisan migrate
```

* Testes (PHPUnit)
```
composer test
```
# Documentação

## Diagrama DB
* [Diagrama do Banco de Dados](database/diagramas/Diagrama_mysql.mwb)

## Métodos

| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |
| `PATCH` | Atualiza dados de um registro ou altera sua situação. |
| `DELETE` | Utilizado para remover um registro. |

## Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso (success).|
| `400` | Erros de validação ou os campos informados não existem no sistema.|
| `401` | Dados de acesso inválidos.|
| `404` | Registro pesquisado não encontrado (Not found).|
| `405` | Método não implementado.|
| `410` | Registro pesquisado foi apagado do sistema e não esta mais disponível.|
| `422` | Dados informados estão fora do escopo definido para o campo.|
| `429` | Número máximo de requisições atingido. (*aguarde alguns segundos e tente novamente*)|

# Documentos [/api/documento]

### Listar (Index) [GET]

+ Response 200 (application/json)

        [
            {
                "id": 1,
                "nome": "Documento 1",
                "assinante": "João da Silva",
                "cpf": "878.008.800-36",
                "num_inscricao": 1000,
                "assinatura": 1.png,
                "documento": 1627943031.pdf,
                "status": Assinado,
                "created_at": "2021-08-02T16:54:44.000000Z",
                "updated_at": "2021-08-02T16:54:44.000000Z"
            },
            {
                "id": 2,
                "nome": "Documento 2",
                "assinante": "Maria da Silva",
                "cpf": "873.018.820-66",
                "num_inscricao": 2000,
                "assinatura": NULL,
                "documento": 1627943031.pdf,
                "status": Criado,
                "created_at": "2021-08-02T17:13:23.000000Z",
                "updated_at": "2021-08-02T17:13:23.000000Z"
            }
        ]

### Novo (Create) [POST]

+ Attributes (object)

    + nome: nome do documento (string, required)
    + assinante: nome do assinante (string, required)
    + cpf (string, required, unique)
    + num_inscricao (integer, required)
    + documento (string)

+ Request (application/json)

    + Body

            {
                "nome": "Documento Teste",
                "assinante": "João da Silva",
                "cpf": "878.008.800-00",
                "num_inscricao": 1000,
                "documento": 1627943031.pdf,
            }

+ Response 200 (application/json)

    + Body

            {
                "success": "Documento criado com sucesso!!"
            }

### Editar (Update) [PATCH]

+ Request (application/json)

    + Body

            {
                "nome": "Documento 1",
                "cpf": "878.008.800-36",
            }

+ Response 200 (application/json)

    + Body

            {
                "success": "Documento atualizado com sucesso!!"
            }

### Excluir (Delete) [DELETE]

+ Response 200 (application/json)

    + Body

            {
                "success": "Documento excluído com sucesso!!"
            }

+ Response 401 (application/json)

    + Body

            {
                "success": "Ocorreu um erro ao excluir o documento"
            }

## Documentações e Referências
* [Laravel](https://laravel.com/docs/6.x)
* [Vue.js](https://vuejs.org/v2/guide/)
* [Bootstrap](https://getbootstrap.com/docs/4.3/getting-started/introduction/)
* [Docker](https://docs.docker.com/get-started/)
* [MySQL](https://dev.mysql.com/doc/refman/5.7/en/)
* [szimek/signature_pad](https://github.com/szimek/signature_pad) 

## Possíveis Melhorias
1. Utilização de um documento dinâmico 
2. Inserir a assinatura em um lugar personalizado pelo usuário
3. Autenticação de usuários
4. Cadastro de um banco de assinantes com os dados separados do documento