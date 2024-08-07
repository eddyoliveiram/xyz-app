# Aplicação de Gerenciamento de Treinamentos

## Requisitos

- Docker instalado
- Composer
- Npm (ou Yarn)

## Passo a passo

### 1) Clonar o Repositório

(De preferência para um diretório dentro do Linux WSL2 otimizando a performance da API com Laravel Sail)

~~~
git clone https://github.com/eddyoliveiram/xyz-app.git
~~~

### Frontend

Abrir um terminal e acessar a pasta do frontend
~~~
cd frontend
~~~		
Instalar os pacotes da aplicação
~~~		
npm install
~~~		
Iniciar a aplicação	
~~~		
npm run serve
~~~


### Backend

Abra um terminal UBUNTU para acessar o Sail na API
~~~
cd backend-api
~~~		
Instale as dependências:
~~~		
composer install
~~~		
Copie o arquivo .env.example para .env (já configurado para a conexão):
~~~		
cp .env.example .env
~~~		
Abra e mantenha aberto no computador o Docker.<BR><BR>
Levante a aplicação:
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

Se o comando --seed rodou com sucesso, foram criados 2 usuários admins e 10 usuários subordinados.
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
