# Desafio Backend Sênior - PX Center

Bem-vindo ao desafio de backend da PX Center! Este repositório contém a implementação de uma API para gerenciamento de tarefas, seguindo as melhores práticas de desenvolvimento e design.

## Tecnologias Usadas

- **Laravel 11**: Framework PHP para desenvolvimento de aplicações web robustas e seguras.
- **PHP 8.2**: Linguagem de programação utilizada no desenvolvimento do backend.
- **PostgreSQL**: Banco de dados relacional usado para armazenar as informações das tarefas e usuários.
- **Redis**: Sistema de filas utilizado para processar notificações e relatórios de forma assíncrona.
- **Docker**: Ferramenta para containerização da aplicação, garantindo um ambiente consistente e fácil de configurar.
- **Mail**: Sistema de envio de e-mails para notificações.
- **Queues**: Para processamento assíncrono de notificações e relatórios.

## Estrutura do Projeto

### Funcionalidades da API

A API permite gerenciar tarefas com as seguintes funcionalidades:

1. **Listar Tarefas**: `GET /tasks` - Retorna uma lista de tarefas com título, status e deadline.
2. **Detalhar Tarefa**: `GET /tasks/{id}` - Retorna detalhes de uma tarefa específica, incluindo prioridade, descrição, e data de criação.
3. **Criar Tarefa**: `POST /tasks` - Cria uma nova tarefa.
4. **Atualizar Tarefa**: `PUT /tasks/{id}` - Atualiza informações da tarefa, como status, título e descrição.
5. **Concluir Tarefa**: `PUT /tasks/{id}/complete` - Marca a tarefa como "Concluída".
6. **Solicitar Relatório**: `POST /reports/tasks` - Gera um relatório de tarefas concluídas e pendentes.
7. **Baixar Relatório**: `GET /reports/download?file={nome_do_arquivo}` - Baixa o relatório gerado.

### Estratégias Escolhidas

- **SOLID e Clean Code**: O projeto segue os princípios de SOLID e boas práticas de clean code para garantir um código manutenível e escalável.
- **Repository Pattern**: Utilizado para desacoplar a lógica de acesso a dados da lógica de negócios.
- **Notificações Assíncronas**: A notificação por e-mail é processada de forma assíncrona utilizando filas (Redis).
- **Relatórios em Background**: Relatórios são gerados em background e o usuário é notificado por e-mail quando o relatório está pronto para download.

### Motivações

- **Camada de Serviço**: Optei por não criar uma camada de serviço, para evitar muitas abstrações desnecessárias em um projeto pequeno.

## Instalação

### Pré-requisitos

- Certifique-se de ter Docker instalado

### Passos para Instalação

1. **Clone o Repositório**

   ```bash
   git clone https://github.com/Bubex/desafio-px-center.git
   cd desafio-px-center
   ```

2. **Rode o Docker**

    Construa e inicie os containers Docker:

    ```bash
    docker-compose up --build
    ```

3. **Instale as Dependências**

   ```bash
   docker exec -it app composer install
   ```

4. **Configuração do Ambiente**

   Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente, caso necessário:

   ```bash
   docker exec -it app cp .env.example .env
   ```

   No .env.example, as variáveis já foram deixadas de acordo com os dados dos containers.

5. **Execute as Migrations e Seed**

   Acesse o container PHP e execute as migrations e seeders:

   ```bash
   docker exec -it app php artisan migrate --seed
   ```

6. **Abra o Serviço de E-mail**

   Abra o serviço de e-mail no navegador:

   http://localhost:1080/

   Através do serviço de e-mail, você poderá ver os e-mails enviados pelo sistema.

## Testes
Para executar os testes, use o seguinte comando:

```bash
docker exec -it app php artisan test
```

### Os testes incluem:

- **Testes de Endpoints**: Verificam a funcionalidade dos endpoints da API.
- **Testes de Notificações**: Asseguram que as notificações por e-mail são enviadas corretamente.
- **Testes de Relatórios**: Confirmam que os relatórios são gerados e que os e-mails de notificação são enviados quando o relatório está pronto.

## Considerações Finais
- **Segurança**: Assegure-se de que o aplicativo está seguro e protegido contra ataques comuns.
- **Desempenho**: Considere o uso de caching e otimização para melhorar o desempenho da aplicação.
