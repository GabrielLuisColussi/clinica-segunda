🚀 Clínica – Sistema de Agendamentos
API Laravel + Interface Blade + Docker (App + Banco + Nginx + phpMyAdmin)

Documentação técnica completa • Execução padronizada • Arquitetura limpa

<div align="center">
🛠 STACK PRINCIPAL
<img src="https://img.shields.io/badge/PHP-8.2-blue?logo=php&logoColor=white" /> <img src="https://img.shields.io/badge/Laravel-10-red?logo=laravel&logoColor=white" /> <img src="https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white" /> <img src="https://img.shields.io/badge/MySQL-8.0-blue?logo=mysql&logoColor=white" /> </div>
📁 1. Visão Geral

Este sistema implementa:

API RESTfull em Laravel, utilizando Controllers, FormRequests, Resources, apiResource e validações robustas.

Interface web (Blade + JS) consumindo a API.

Execução padronizada com Docker, contendo:

App (PHP 8.2 + Composer)

Nginx

MySQL

phpMyAdmin

Regras de agendamento incluem:

Proibir datas retroativas

Impedir finais de semana

Respeitar janela 08h → 18h

Bloquear agendamentos ao meio-dia

Validação de paciente e médico existentes

🐳 2. Execução com Docker (Modo Recomendado)
📌 Subir a stack completa
docker-compose up -d

Containers criados:
Serviço	Porta	Descrição
Nginx	80	Servidor da aplicação
phpMyAdmin	8080	Interface do banco
MySQL	3306	Banco
PHP-FPM	Interno	Execução do Laravel
📌 Rodar migrations
docker-compose exec app php artisan migrate

📌 Gerar chave
docker-compose exec app php artisan key:generate

🔗 Acessos

Aplicação:
http://localhost

API:
http://localhost/api

phpMyAdmin:
http://localhost:8080

user: root
senha: (definida no docker-compose)

🧪 3. Execução Local (Sem Docker)
✔ Pré-requisitos

PHP 8.1+

Composer

MySQL

📌 Passo a passo
1. Clonar
git clone https://github.com/GabrielLuisColussi/clinica-segunda.git
cd clinica-segunda

2. Instalar dependências
composer install

3. Copiar env
cp .env.example .env

4. Configurar banco
DB_DATABASE=clinica
DB_USERNAME=root
DB_PASSWORD=senha

5. Gerar key
php artisan key:generate

6. Migrar
php artisan migrate

7. Iniciar
php artisan serve


Aplicação:
➡ http://localhost:8000

🧩 4. Arquitetura do Projeto
clinica/
│── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   ├── Middleware/
│   └── Models/
│
│── resources/
│   └── views/
│       ├── pacientes/
│       ├── medicos/
│       ├── agendamentos/
│       └── layout.blade.php
│
│── routes/
│   ├── api.php
│   └── web.php
│
│── docker/
│   ├── nginx/default.conf
│   └── php/local.ini
│
│── docker-compose.yml
│── Dockerfile
│── composer.json

🔥 5. API – Endpoints
Pacientes
Método	Rota	Ação
GET	/api/pacientes	Listar
POST	/api/pacientes	Criar
PUT	/api/pacientes/{id}	Atualizar
DELETE	/api/pacientes/{id}	Remover
Médicos
Método	Rota	Ação
GET	/api/medicos	Listar
POST	/api/medicos	Criar
PUT	/api/medicos/{id}	Atualizar
DELETE	/api/medicos/{id}	Remover
Agendamentos (com validações)
Método	Rota
GET	/api/agendamentos
POST	/api/agendamentos
PUT	/api/agendamentos/{id}
DELETE	/api/agendamentos/{id}
🚫 Regras aplicadas:

after_or_equal:today

Proibição de sábado e domingo

not_in:12:00

Horário entre 08:00 e 18:00

exists:pacientes,id

exists:medicos,id

⚙ 6. Docker – Arquivos Importantes
✔ Dockerfile

PHP-FPM

Composer

Extensões essenciais

✔ docker-compose.yml

App

MySQL

phpMyAdmin

Nginx

Volumes persistentes

✔ Nginx

docker/nginx/default.conf:

location / {
    try_files $uri /index.php?$query_string;
}

📚 7. Sprints Entregues
Semana 1

Tema, entidades, versionamento, README inicial.

Semana 2

Models, Migrations, Controllers, Rotas API.

Semana 3

Interface consumindo API.

Semana 4

Pesquisa e Desenvolvimento.

Semana 5

Validações + refino.

Semana 6

Docker final + apresentação.

🧠 8. P&D – Resultado

Dockerização total da aplicação

Configuração avançada do Nginx

CRUDs completos

API padronizada

Persistência com volumes

Front Blade consumindo API via fetch

👥 Autores

Gabriel Colussi

Samuel

Demais integrantes

📝 Licença

Uso acadêmico.
