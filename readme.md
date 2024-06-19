# Execução do Projeto Backend PHP e Laravel com Docker

## Introdução

Este guia serve como referência para configurar e executar o projeto backend utilizando Docker. Ele abrange desde a preparação do ambiente até a execução dos serviços necessários para o funcionamento do projeto.

## Pré-requisitos

Antes de prosseguir, verifique se possui os seguintes pré-requisitos instalados:

- Docker: Acesse [Docker Get Started](https://www.docker.com/get-started) para instalar.
- Docker Compose: Consulte [Docker Compose Install](https://docs.docker.com/compose/install/) para obter instruções de instalação.

## Estrutura do Projeto

O projeto está organizado em várias pastas, incluindo `src/products/`, que é o foco desta documentação. Esta pasta contém os arquivos Docker específicos para os produtos do projeto.

## Instruções de Execução

### 1. Preparação do Ambiente

Certifique-se de que o Docker e o Docker Compose estão instalados e funcionando corretamente em sua máquina.

### 2. Navegação até a Pasta dos Produtos

Abra um terminal e navegue até a pasta `src/products/` do seu projeto. Use o comando `cd` para mudar de diretório:

bash cd caminho/para/seu/projeto/src/products/


Substitua `caminho/para/seu/projeto` pelo caminho real onde o projeto está armazenado em sua máquina.

### 3. Execução com Docker Compose

Dentro da pasta `src/products/`, execute o seguinte comando para iniciar os serviços necessários:

sudo docker compose up


Este comando irá construir e iniciar os contêineres definidos no arquivo `docker-compose.yml` presente na pasta.

### Notas Adicionais

- Se você fizer alterações nos arquivos de configuração ou no código após a inicialização, precisará reconstruir os contêineres. Para isso, use os comandos:
bash sudo docker compose down sudo docker compose up

- Verifique se não há conflitos de portas entre os serviços e outros aplicativos em execução na sua máquina.
