# Documentação de Uso da API de Despesas

Este documento detalha o uso dos endpoints expostos pela API Rest de despesas. A API gerencia despesas e realiza operações CRUD (Criar, Ler, Atualizar, Deletar), além de fornecer endpoints para autenticação de usuários.

## Stack utilizada
**Laravel**
Foi utilizado o **Mailtrap** para testes de envio de notificação por e-mail em fila.

## Instalação - Rodando Localmente

- Clone esse repositório
```bash
git clone https://github.com/henriquetbp/onfly.git
```
- Instale as dependências
```bash
composer install
```
- Crie um novo schema e configure a conexão no arquivo .env
- Crie as tabelas
```bash
php artisan migrate
```
- Inicie o servidor
```bash
php artisan serve
```
- Insira dados para testes nas tabelas **(opcional)**
```bash
php artisan migrate --seed
```

## Endpoints

### 1. **Listar Despesas**
   - **Método**: `GET`
   - **Endpoint**: `/api/expenses`
   - **Descrição**: Retorna uma lista de todas as despesas do usuário autenticado.
   - **Autenticação**: Requer token de autenticação do usuário.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": [
        {
    "description": "Compra no shopping",
    "value": 250.50,
    "date": "2023-09-30"
    "user_id": 2,
    "updated_at":  "2024-09-30T13:00:24.000000Z", 
    "created_at":  "2024-09-30T13:00:24.000000Z",
   "id": 16
        }
    ],
    "message": "Despesas recebidas com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
GET /api/expenses
Authorization: Bearer {token}
```

### 2. **Criar Despesa**
   - **Método**: `POST`
   - **Endpoint**: `/api/expenses`
   - **Descrição**: Cria uma nova despesa com os dados fornecidos no corpo da requisição.
   - **Autenticação**: Requer token de autenticação do usuário.
   - **Campos** (Requeridos):
     - `description` (varchar): Descrição da despesa.
     - `value` (decimal): Valor da despesa.
     - `date` (date): Data da despesa.
     - `user_id` (integer): Usuário proprietário da despesa.
    - **Regras de Envio**:
	     - `description`: Deve ter menos de 191 caracteres.
	     - `value`: Deve ser um valor positivo.
	     - `date`: Deve ser uma data presente ou passada.
	     - `user_id`: Deve ser um usuário existente e igual ao ID do usuário logado.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": {
       "description": "Compra no shopping",
       "value": 250.50,
       "date": "2023-09-30"
       "user_id": 2,
       "updated_at":  "2024-09-30T13:00:24.000000Z", 
       "created_at":  "2024-09-30T13:00:24.000000Z",
       "id": 16
    },
    "message": "Despesa criada com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
POST /api/expenses
Authorization: Bearer {token}
Content-Type: application/json

{
    "description": "Compra no shopping",
    "value": 250.50,
    "date": "2023-09-30",
    "user_id": 2
}
```

### 3. **Exibir Detalhes de uma Despesa**
   - **Método**: `GET`
   - **Endpoint**: `/api/expenses/{expense}`
   - **Descrição**: Retorna os detalhes de uma despesa específica pelo seu ID.
   - **Autenticação**: Requer token de autenticação do usuário.
   - **Parâmetro URL**:
     - `{expense}`: ID da despesa que se deseja consultar.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": {
       "description": "Compra no shopping",
       "value": 250.50,
       "date": "2023-09-30"
       "user_id": 2,
       "updated_at":  "2024-09-30T13:00:24.000000Z", 
       "created_at":  "2024-09-30T13:00:24.000000Z",
       "id": 16
    },
    "message": "Despesa encontrada com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
GET /api/expenses/16
Authorization: Bearer {token}
```

### 4. **Atualizar uma Despesa**
   - **Método**: `PUT`
   - **Endpoint**: `/api/expenses/{expense}`
   - **Descrição**: Atualiza uma despesa existente com base no ID da despesa e nos dados fornecidos no corpo da requisição.
   - **Autenticação**: Requer token de autenticação do usuário.
   - **Parâmetro URL**:
     - `{expense}`: ID da despesa a ser atualizada.
   - **Campos** (opcionais):
     - `description` (string): Descrição da despesa.
     - `value` (decimal): Valor da despesa.
     - `date` (date): Data da despesa.
    - **Regras de Envio**:
		 - `description`: Deve ter menos de 191 caracteres.
		 - `value`: Deve ser um valor positivo.
		 - `date`: Deve ser uma data presente ou passada.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": {
       "description": "Compra atualizada",
       "value": 300.00,
       "date": "2023-10-01"
       "user_id": 2,
       "updated_at":  "2024-10-01T13:00:24.000000Z", 
       "created_at":  "2024-09-30T13:00:24.000000Z",
       "id": 16
    },
    "message": "Despesa atualizada com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
PUT /api/expenses/16
Authorization: Bearer {token}
Content-Type: application/json

{
    "description": "Compra atualizada",
    "value": 300.00,
    "date": "2023-10-01"
}
```

### 5. **Deletar uma Despesa**
   - **Método**: `DELETE`
   - **Endpoint**: `/api/expenses/{expense}`
   - **Descrição**: Remove uma despesa específica pelo seu ID.
   - **Autenticação**: Requer token de autenticação do usuário.
   - **Parâmetro URL**:
     - `{expense}`: ID da despesa que se deseja deletar.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": [],
    "message": "Despesa excluída com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
DELETE /api/expenses/16
Authorization: Bearer {token}
```

### 6. **Login do Usuário**
   - **Método**: `POST`
   - **Endpoint**: `/api/user/login`
   - **Descrição**: Realiza o login do usuário e retorna um token de autenticação.
   - **Campos Requeridos**:
     - `email` (string): E-mail do usuário.
     - `password` (string): Senha do usuário.
   - **Resposta de Sucesso (200)**:
```json
{
    "success": true,
    "data": {
   "token": "eyJ0eXAiOiJKV1QiLCJh...dGVzdF9qd3QifQ",
   "name": "Usuário"
   "id": 2
    },
    "message": "Usuário logado com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
POST /api/user/login
Content-Type: application/json

{
    "email": "usuario@example.com",
    "password": "senha123"
}
```

### 7. **Registro de Novo Usuário**
   - **Método**: `POST`
   - **Endpoint**: `/api/user/register`
   - **Descrição**: Registra um novo usuário e retorna um token de autenticação.
   - **Campos Requeridos**:
     - `name` (string): Nome do usuário.
     - `email` (string): E-mail do usuário.
     - `password` (string): Senha do usuário.
   - **Resposta de Sucesso (201)**:
```json
{
    "success": true,
    "data": {
   "token": "eyJ0eXAiOiJKV1QiLCJh...dGVzdF9qd3QifQ",
   "name": "Usuário"
   "id": 2
    },
    "message": "Usuário registrado com sucesso."
}
```
   - **Exemplo de Requisição**:
```bash
POST /api/user/register
Content-Type: application/json

{
    "name": "Usuário",
    "email": "usuario@example.com",
    "password": "senha123",
}
```

## Autenticação
A API utiliza autenticação baseada em **Bearer**. Para acessar os endpoints protegidos, o usuário deve incluir um cabeçalho **Authorization** com o token recebido após o login ou registro.

- **Formato do cabeçalho de autenticação**:
```bash
Authorization: Bearer {token}
```
     
# Documentação de Testes Unitários para API de Despesas

Este documento descreve os testes unitários para validar a funcionalidade de login de usuário e o comportamento correto das funcionalidades da API de despesas. Cada teste tem como objetivo verificar se o endpoint de login responde de maneira apropriada ao receber credenciais válidas, além de verificar se as ações sobre as despesas (como listar, acessar, criar, atualizar e excluir) estão funcionando conforme o esperado para o usuário autenticado e se as permissões estão corretamente configuradas. Os testes estão configurados para serem executados em uma instância independente do banco de dados SQLite.

## Documentação de Testes Unitários para Login de Usuário

### Estrutura do Teste 
O teste está localizado no arquivo `LoginUserTest.php` e utiliza a classe **`TestCase`** para realizar as verificações. A trait **`RefreshDatabase`** é usada para garantir que o banco de dados seja restaurado para o estado original antes de cada teste.

### 1. **Testar Login de Usuário**
- **Método**: `test_user_can_login`
- **Objetivo**: Verificar se o usuário pode fazer login com credenciais válidas.
- **Cenário**: 
	- O banco de dados é alimentado com um usuário de teste.
	- Uma requisição `POST` é enviada para o endpoint `/api/user/login` com as credenciais do usuário.
- **Dados Enviados**: 
```json 
{ "email": "test@example.com", "password": "password" } 
```
- **Validações**: 
	- O status de resposta deve ser 200 (OK). 
	- A estrutura JSON da resposta deve conter as seguintes chaves: 
		- `success`
		- `data`
		- `message`
	- O teste também valida que a resposta é bem-sucedida usando o método `assertOk()`.
	- **Exemplo de Requisição**: 
```php 
$response = $this->postJson('/api/user/login', [ 'email' => 'test@example.com', 'password' => 'password' ]); 
``` 
### Considerações Finais 
Este teste cobre a funcionalidade de login do usuário, garantindo que a API retorna uma resposta válida quando o usuário faz login com credenciais corretas. Ele também assegura que a estrutura da resposta JSON contém os campos necessários. 

O teste pode ser executado usando o seguinte comando no terminal: 
```bash 
php artisan test --filter LoginUserTest
```
---

## Documentação de Testes Unitários para CRUD de Despesas
### Estrutura dos Testes

Os testes estão localizados no arquivo `ExpensesAccessTest.php` e utilizam a classe **`TestCase`** para realizar verificações de acesso aos endpoints da API de despesas. A trait **`RefreshDatabase`** é usada para garantir que o banco de dados seja restaurado para o estado original antes de cada teste.

### 1. **Testar Listagem de Todas as Despesas**
   - **Método**: `test_user_can_get_all_expenses`
   - **Objetivo**: Verificar se o usuário autenticado consegue listar todas as despesas associadas a ele.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele faz uma requisição `GET` para `/api/expenses`.
   - **Validações**:
     - Status de resposta deve ser 200 (OK).
     - O número de despesas retornadas deve ser 10.
   - **Exemplo de Requisição**:
     ```php
     $response = $this->getJson('/api/expenses');
     ```

### 2. **Testar Acesso a uma Despesa Específica**
   - **Método**: `test_user_can_access_expense`
   - **Objetivo**: Verificar se o usuário autenticado consegue acessar uma despesa específica.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele faz uma requisição `GET` para `/api/expenses/10`.
   - **Validações**:
     - Status de resposta deve ser 200 (OK).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->getJson('/api/expenses/10');
     ```

### 3. **Testar Bloqueio de Acesso a Despesa de Outro Usuário**
   - **Método**: `test_block_expense_from_another_user`
   - **Objetivo**: Verificar se o usuário é bloqueado ao tentar acessar uma despesa de outro usuário.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele tenta acessar uma despesa que pertence ao usuário com ID 2.
   - **Validações**:
     - Status de resposta deve ser 403 (Forbidden).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->getJson('/api/expenses/11');
     ```

### 4. **Testar Criação de Despesa**
   - **Método**: `test_user_can_create_expense`
   - **Objetivo**: Verificar se o usuário autenticado pode criar uma nova despesa.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele faz uma requisição `POST` para `/api/expenses` com os dados da nova despesa.
   - **Validações**:
     - Status de resposta deve ser 200 (OK).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->postJson('/api/expenses', [
         'description' => 'expense 1',
         'value' => 100,
         'date' => '2024-01-01',
         'user_id' => $user->id
     ]);
     ```

### 5. **Testar Bloqueio de Criação de Despesa para Outro Usuário**
   - **Método**: `test_block_create_expense_to_another_user`
   - **Objetivo**: Garantir que o usuário não consiga criar uma despesa para outro usuário.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele tenta criar uma despesa vinculada ao usuário com ID 2.
   - **Validações**:
     - Status de resposta deve ser 422 (Unprocessable Entity).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->postJson('/api/expenses', [
         'description' => 'expense 1',
         'value' => 100,
         'date' => '2024-01-01',
         'user_id' => 2
     ]);
     ```

### 6. **Testar Atualização de Despesa**
   - **Método**: `test_user_can_update_expense`
   - **Objetivo**: Verificar se o usuário autenticado pode atualizar uma despesa existente.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele faz uma requisição `PUT` para `/api/expenses/1` com os novos dados da despesa.
   - **Validações**:
     - Status de resposta deve ser 200 (OK).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->putJson('/api/expenses/1', [
         'description' => 'expense 1 updated',
         'value' => 200,
         'date' => '2024-01-01',
     ]);
     ```

### 7. **Testar Bloqueio de Atualização de Despesa de Outro Usuário**
   - **Método**: `test_block_update_expense_from_another_user`
   - **Objetivo**: Garantir que o usuário não possa atualizar despesas que pertencem a outros usuários.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele tenta atualizar uma despesa pertencente ao usuário com ID 2.
   - **Validações**:
     - Status de resposta deve ser 403 (Forbidden).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->putJson('/api/expenses/11', [
         'description' => 'expense 1 updated',
         'value' => 200,
         'date' => '2024-01-01',
     ]);
     ```

### 8. **Testar Exclusão de Despesa**
   - **Método**: `test_user_can_delete_expense`
   - **Objetivo**: Verificar se o usuário autenticado pode excluir uma despesa existente.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele faz uma requisição `DELETE` para `/api/expenses/1`.
   - **Validações**:
     - Status de resposta deve ser 200 (OK).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->deleteJson('/api/expenses/1');
     ```

### 9. **Testar Bloqueio de Exclusão de Despesa de Outro Usuário**
   - **Método**: `test_block_delete_expense_from_another_user`
   - **Objetivo**: Garantir que o usuário não consiga excluir despesas de outros usuários.
   - **Cenário**:
     - O usuário com ID 1 é autenticado.
     - Ele tenta excluir uma despesa pertencente ao usuário com ID 2.
   - **Validações**:
     - Status de resposta deve ser 403 (Forbidden).
   - **Exemplo de Requisição**:
     ```php
     $response = $this->deleteJson('/api/expenses/11');
     ```

## Considerações Finais

Os testes descritos garantem que a API de despesas está funcionando corretamente, respeitando as permissões de acesso e validação de dados. Cada teste cobre um aspecto essencial das operações CRUD para despesas, com foco na segurança e consistência dos dados.

Os testes podem ser executados usando o seguinte comando no terminal:
```bash
php artisan test --filter ExpensesAccessTest
```