# API REST — CRUD de Usuários com Laravel

API RESTful desenvolvida em PHP com Laravel para gerenciamento de usuários, com operações completas de CRUD, paginação, validação de dados e formatação de respostas via API Resources.

> 📚 Projeto desenvolvido acompanhando o curso **[Como Criar uma API RESTful do Zero com Laravel (PHP) e Consumir com React JS](https://www.youtube.com/watch?v=jLGKI_zMftU&t=3925s)** da **Eduteka**.

---

## Tecnologias

- **PHP** com **Laravel 11**
- **SQLite** (banco de dados local)
- **Laravel Sanctum** (estrutura de autenticação)
- **API Resources** para formatação de respostas JSON
- **Form Requests** para validação

---

## Estrutura do Projeto

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── UserController.php       # Controlador principal do CRUD
│   │   ├── Requests/
│   │   │   ├── StoreUserRequest.php     # Validação para criação de usuário
│   │   │   └── UpdateUserRequest.php    # Validação para atualização de usuário
│   │   └── Resources/
│   │       ├── UserResource.php         # Formatação de um único usuário
│   │       └── UserCollection.php       # Formatação de coleção paginada
│   └── Models/
│       └── User.php                     # Model do usuário
├── database/
│   ├── migrations/                      # Estrutura das tabelas
│   └── database.sqlite                  # Banco de dados SQLite
└── routes/
    └── api.php                          # Definição das rotas da API
```

---

## Banco de Dados

A tabela `users` é criada via migration com os seguintes campos:

| Campo              | Tipo        | Descrição                        |
|--------------------|-------------|----------------------------------|
| `id`               | bigint (PK) | Identificador único              |
| `name`             | string      | Nome do usuário                  |
| `email`            | string      | E-mail único                     |
| `date_of_birth`    | string      | Data de nascimento               |
| `password`         | string      | Senha (hashed)                   |
| `email_verified_at`| timestamp   | Data de verificação do e-mail    |
| `created_at`       | timestamp   | Data de criação                  |
| `updated_at`       | timestamp   | Data de atualização              |

---

## 🔌 Endpoints da API

Base URL: `http://localhost:8000/api`

| Método   | Rota           | Descrição                        |
|----------|----------------|----------------------------------|
| `GET`    | `/users`       | Lista usuários (paginado, 3/pág) |
| `POST`   | `/users`       | Cria um novo usuário             |
| `GET`    | `/users/{id}`  | Exibe um usuário específico      |
| `PUT`    | `/users/{id}`  | Atualiza um usuário              |
| `DELETE` | `/users/{id}`  | Remove um usuário                |

---

## Exemplos de Requisição

### `POST /api/users` — Criar usuário

**Body (JSON):**
```json
{
  "name": "João Silva",
  "email": "joao@email.com",
  "date_of_birth": "1990-05-20"
}
```

**Resposta (201):**
```json
{
  "message": "Usuário criado com sucesso",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@email.com",
    "date_of_birth": "1990-05-20"
  }
}
```

---

### `GET /api/users` — Listar usuários (paginado)

**Resposta (200):**
```json
{
  "data": [
    {
      "id": 3,
      "name": "Maria Souza",
      "email": "maria@email.com",
      "date_of_birth": "1995-08-10"
    }
  ],
  "links": { ... },
  "meta": {
    "current_page": 1,
    "per_page": 3,
    "total": 10
  }
}
```

---

### `PUT /api/users/{id}` — Atualizar usuário

**Body (JSON):**
```json
{
  "name": "João Atualizado",
  "email": "joao.novo@email.com",
  "date_of_birth": "1990-05-20"
}
```

**Resposta (200):**
```json
{
  "message": "Usuário atualizado com sucesso",
  "data": { ... }
}
```

---

### `DELETE /api/users/{id}` — Remover usuário

**Resposta:** `204 No Content`

---

## Validações

### Criação (`StoreUserRequest`)
- `name` — obrigatório
- `email` — obrigatório, formato válido, único na tabela
- `date_of_birth` — obrigatório, formato de data, deve ser anterior à data atual

### Atualização (`UpdateUserRequest`)
- `name` — obrigatório
- `email` — obrigatório, formato válido, único (exceto o próprio usuário)
- `date_of_birth` — obrigatório, formato de data, deve ser anterior à data atual
- Retorna `422` com mensagem de erro se o usuário não existir

---

## ⚙️ Como Rodar o Projeto

### Pré-requisitos
- PHP >= 8.2
- Composer

### Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio

# Instale as dependências
composer install

# Copie o arquivo de ambiente
cp .env.example .env

# Configure o banco de dados no .env (SQLite)
DB_CONNECTION=sqlite

# Crie o arquivo do banco de dados
touch database/database.sqlite

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations
php artisan migrate

# (Opcional) Popule o banco com dados de teste
php artisan db:seed

# Inicie o servidor
php artisan serve
```

A API estará disponível em: `http://localhost:8000/api`

---

## Testes

```bash
php artisan test
```

---

## 📝 Observações

- A senha de usuários criados via API é definida como `123` (hash) por padrão — apenas para ambiente de desenvolvimento/testes.
- A listagem de usuários retorna **3 registros por página**, ordenados pelo `id` decrescente.
- Campos `password` e `remember_token` são ocultados nas respostas da API.
