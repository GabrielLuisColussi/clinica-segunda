🚀 Clínica – Sistema de Agendamentos
API Laravel + Interface Blade + Docker (App + Banco + Nginx + phpMyAdmin)

Documentação técnica completa • Execução padronizada • Arquitetura limpa

<div align="center">
🛠 STACK PRINCIPAL










</div>
📁 1. Visão Geral

Este sistema implementa:

API RESTfull em Laravel, utilizando Controllers, FormRequests, Resources, apiResource e validações robustas.

Interface web (Blade + JS) consumindo a API.

Execução padronizada com Docker, contendo:

Container App (PHP 8.2 + Composer)

Container Nginx

Container MySQL

Container phpMyAdmin

Regras de agendamento incluem:

Proibir datas retroativas

Impedir finais de semana

Respeitar janela 08h → 18h

Bloquear agendamentos ao meio-dia

Validar relacionamentos (paciente, médico, horário)

🐳 2. Execução com Docker (Modo Recomendado)
📌 Subir a stack completa
docker-compose up -d


Containers que serão iniciados:

Serviço	Porta	Descrição
Nginx (app)	80	Servidor web
phpMyAdmin	8080	Interface do banco
MySQL	3306	Banco de dados
PHP-FPM	Interno	Execução do Laravel
📌 Rodar migrations dentro do container
docker-compose exec app php artisan migrate

📌 Gerar chave da aplicação
docker-compose exec app php artisan key:generate

🔗 Acessos

Aplicação (Laravel + Blade):
http://localhost

API:
http://localhost/api/qualquer-rota

phpMyAdmin:
http://localhost:8080

usuário: root

senha: (definida no docker-compose)

🧪 3. Execução Local (Sem Docker)
✔ Pré-requisitos

PHP 8.1+

Composer

MySQL

Extensões do Laravel

📌 Passo a passo
1. Clonar o repositório
git clone https://github.com/GabrielLuisColussi/clinica-segunda.git
cd clinica-segunda

2. Instalar dependências
composer install

3. Criar o .env
cp .env.example .env

4. Configurar banco no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinica
DB_USERNAME=root
DB_PASSWORD=senha

5. Gerar key
php artisan key:generate

6. Rodar migrations
php artisan migrate

7. Iniciar servidor
php artisan serve


Aplicação disponível em:
➡ http://localhost:8000

🧩 4. Arquitetura do Projeto
clinica/
│── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/        → validações (Store, Update)
│   │   ├── Middleware/
│   └── Models/
│
│── resources/
│   ├── views/
│       ├── pacientes/
│       ├── medicos/
│       ├── agendamentos/
│       └── layout.blade.php
│
│── routes/
│   ├── api.php      → Rotas REST
│   └── web.php      → Interface front
│
│── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/local.ini
│
│── docker-compose.yml
│── Dockerfile
│── composer.json

🔥 5. API – Endpoints Principais

Rotas seguem padrão apiResource:

Pacientes
Método	Rota	Descrição
GET	/api/pacientes	Listar
POST	/api/pacientes	Criar
PUT	/api/pacientes/{id}	Atualizar
DELETE	/api/pacientes/{id}	Remover
Médicos
Método	Rota	Descrição
GET	/api/medicos	Listar
POST	/api/medicos	Criar
PUT	/api/medicos/{id}	Atualizar
DELETE	/api/medicos/{id}	Remover
Agendamentos

Com validações avançadas:

Sem datas retroativas

Sem finais de semana

Sem meio-dia

Horário entre 08h → 18h

Médico/paciente precisam existir

Método	Rota
GET	/api/agendamentos
POST	/api/agendamentos
PUT	/api/agendamentos/{id}
DELETE	/api/agendamentos/{id}
🧪 6. Validações (Baseado no ZIP)

As regras aplicadas nos Requests incluem:

StoreAgendamentoRequest.php

after_or_equal:today

not_in:2024-12-25 (exemplo de feriado)

Restrições por horário:

< 08:00 → inválido

== 12:00 → inválido

> 18:00 → inválido

exists:pacientes,id

exists:medicos,id

🎨 7. Interface (Blade + JS)

Inclui:

Listagem completa

Formulários reutilizáveis

Layout estruturado

Views:

pacientes/

medicos/

agendamentos/

login.blade.php (se existir no projeto)

⚙ 8. Docker – Arquivos da Stack
Dockerfile (PHP + Composer)

PHP-FPM

Extensões Laravel

Composer 2.x

docker-compose.yml

App

Nginx

MySQL

phpMyAdmin

Volumes persistentes

Nginx

docker/nginx/default.conf com:

location / {
    try_files $uri /index.php?$query_string;
}


Perfeito para Laravel.

📚 9. Sprints Entregues (Conforme Documento do Professor)
Semana 1

Tema, entidades, versionamento, README inicial.

Semana 2

Migrations, Controllers, Models, rotas API.

Semana 3

Interface consumindo API.

Semana 4

P&D aplicado.

Semana 5

Refino e validações.

Semana 6

Docker final + apresentação.

🧠 10. P&D – Resumo Técnico

Dockerização do Laravel

Nginx reverse proxy

Containers independentes

Validações complexas com FormRequest

Boas práticas REST

Persistência via volumes

CI local com Docker Compose

👥 11. Autores

Gabriel Colussi

Samuel

demais membros do grupo

✔ 12. Licença

Uso acadêmico.
