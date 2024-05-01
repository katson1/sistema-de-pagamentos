# Sistemas de Pagamentos Simplificado

Um sistema de pagamento simplificado que permite adicionar usuários comuns e lojistas e realizar transferências. Usuários comuns podem enviar dinheiro para lojistas e entre si. Lojistas apenas recebem transferências.

## Pré-requisitos

| [![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/downloads.php) | [![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/11.x/installation) | [![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/get-started/) |
| - | - | - |
|　 v8.x  |　　v11.x | latest version

## Instalação e Configuração

Clone o projeto:
```bash
git clone https://github.com/katson1/sistema-de-pagamentos.git
```

Acesse a pasta do projeto e instale as dependências necessárias com o composer:
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
### Acessando a Documentação da API

Após iniciar a aplicação, você pode acessar a documentação interativa da API, que é fornecida pelo Swagger. Esta documentação oferece uma visão detalhada de todos os endpoints disponíveis, seus parâmetros, e as respostas esperadas para cada operação. Siga os passos abaixo para acessar a documentação:

1. **Iniciar a Aplicação**: Certifique-se de que a aplicação está rodando. Se você está usando Docker, a aplicação deve estar acessível após os passos de configuração mencionados anteriormente. Para usuários do SQLite, certifique-se de que o comando `php artisan serve` foi executado com sucesso.

2. **Acessar a Documentação**: Abra um navegador de sua preferência e visite o seguinte endereço:
   - Para **Docker**: [http://localhost:8989/api/documentation/](http://localhost:8989/api/documentation/)
   - Para **SQLite**: [http://localhost:8000/api/documentation/](http://localhost:8000/api/documentation/)


## Funcionalidades
Em breve

## Arquitetura do Projeto
Em breve

## Testes
Os testes utilizam o SQLite com a base na memória (:memory:) já que a tabela de banco é simples, facilitando também os testes pelo github.

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
