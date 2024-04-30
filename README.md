# Sistemas de Pagamentos Simplificado

Um sistema de pagamento simplificado que permite adicionar usuários comuns e lojistas e realizar transferências. Usuários comuns podem enviar dinheiro para lojistas e entre si. Lojistas apenas recebem transferências.

## Pré-requisitos
[![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/downloads.php)
[![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/11.x/installation)

Opcional:

[![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/get-started/)

## Instalação e Configuração

Clone o projeto:
```bash
git clone https://github.com/katson1/sistema-de-pagamentos.git
```

Acesse a pasta do projeto e configure-o:
```bash
cd sistema-de-pagamentos
composer install
```
O projeto pode utilizar o SQLite e fornece suporte ao Docker, que gerencia uma imagem do Postgres. Note que o o Docker requer instalação prévia.
Você pode utilizar os seguintes comandos do composer para configurar o uso do SQLite, ou do Docker:
| SQLite         | Docker         |
| -------------- | -------------- |
| `composer setup-sqlite` | `composer setup-docker` |

Se você está utilizando `docker` execute os seguintes comandos para a configuração:
```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## Como Usar
Se você está utilizando `docker` após a execução do comando no passo anterior, a aplicação já está em execução.
Acesse a documentação da aplicação feita em swagger:
`http://localhost:8989/api/documentation/`

Se você está utilizando `SQLite` execute a aplicação:
```bash
php artisan serve
```
E acesse a documentação da aplicação feita em swagger:
`http://localhost:8000/api/documentation/`

## Funcionalidades
Em breve

## Arquitetura do Projeto
Em breve

## Testes
Use o seguinte comando para executar os testes automatizados localmente (unitários e de integração):
```bash
php artisan test
```
Ou no docker:
```bash
docker-compose exec app php artisan test
```

## Autor
<div align="left">
  <div>
    Katson Matheus
    <a href="https://github.com/katson1">
      <img src="https://skillicons.dev/icons?i=github" alt="html" height="15" />
    </a>
    <a href="https://discordapp.com/users/210789016675549184">
      <img src="https://skillicons.dev/icons?i=discord" alt="html" height="15"/>
    </a>
    <a href="https://www.linkedin.com/in/katsonmatheus/">
      <img src="https://skillicons.dev/icons?i=linkedin" alt="html" height="15"/>
    </a>
    <a href="mailto:katson.alves@ccc.ufcg.edu.br">
      <img src="https://skillicons.dev/icons?i=gmail" alt="html" height="15"/>
    </a>
  </div>
</div>
