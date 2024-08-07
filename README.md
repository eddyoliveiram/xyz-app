# Aplicação XYZ para Gerenciamento de Treinamentos

## Requisitos

- Docker instalado
- Composer
- Npm (ou Yarn)

## Passo a passo

### Clone o Repositório

(De preferência para um diretório dentro do Linux WSL2 otimizando a performance da API com Laravel Sail)

~~~
git clone https://github.com/eddyoliveiram/xyz-app.git
~~~

### Frontend

Abra um terminal e acessar a pasta do frontend
~~~
cd frontend
~~~		
Instale os pacotes da aplicação
~~~		
npm install
~~~		
Inicie a aplicação	
~~~		
npm run serve
~~~


### Backend

Abra um terminal UBUNTU e acesse a pasta do backend-api
~~~
cd backend-api
~~~		
Instale as dependências:
~~~		
composer install
~~~		
Copie o arquivo .env.example para .env (já deixei configurado para a conexão):
~~~		
cp .env.example .env
~~~		
Levante a aplicação (é necessário que o docker esteja aberto no computador):
~~~		
./vendor/bin/sail up -d
~~~
Rode as migrações com seeders:
~~~
./vendor/bin/sail artisan migrate:fresh --seed
~~~
A aplicação deve estar acessível na porta 3000:
~~~
http://localhost:3000
~~~

### Usuários Criados

Se o comando --seed rodou com sucesso, foram criados 2 usuários admins e 10 usuários subordinados.<BR><BR>
Usuários Admins:

    admin
        Login: admin
        Senha: admin
    admin2
        Login: admin2
        Senha: admin2

Usuários Subordinados:

    joao
        Login: joao
        Senha: 123
    Demais 9 usuários
        Login: ...
        Senha: 123

    OBS:Você pode conferir os logins dos demais usuários na tabela users.

### Recursos Utilizados
~~~
Frontend
   - Framework Vue3

Backend (API REST)
   - Framework Laravel 10.x
   - Laravel Sail (Docker com container MySQL)
   - Laravel Breeze API e Sanctum (autenticação da API)
   - Repository Pattern

Github
   - Conventional Commits
~~~
### Diagrama de Entidade-Relacionamento (ERD)

![drawsql](https://github.com/user-attachments/assets/3b31ae59-4515-4130-99de-54faaae21af8)
