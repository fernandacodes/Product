# Execução do Projeto Backend PHP e Laravel com Docker

## Introdução

Este guia detalha a configuração e execução do projeto backend utilizando Docker, abrangendo desde a preparação do ambiente até a execução dos serviços necessários para o funcionamento do projeto. Foi projetado para oferecer uma experiência de desenvolvimento consistente e isolada, permitindo que os desenvolvedores trabalhem em ambientes semelhantes independentemente da máquina local.

## Pré-requisitos

Antes de prosseguir, verifique se possui os seguintes pré-requisitos instalados:

- Docker: Acesse [Docker Get Started](https://www.docker.com/get-started) para instalar.
- Docker Compose: Consulte [Docker Compose Install](https://docs.docker.com/compose/install/) para obter instruções de instalação.

## Estrutura do Projeto

O projeto está organizado em várias pastas, incluindo `src/products/`, que é o foco desta documentação. Esta pasta contém os arquivos Docker específicos para os produtos do projeto, demonstrando uma abordagem modular para a gestão de serviços e recursos.

## Instruções de Execução

### 1. Preparação do Ambiente

Certifique-se de que o Docker e o Docker Compose estão instalados e funcionando corretamente em sua máquina. Isso garante que os contêineres possam ser criados e gerenciados eficientemente.

### 2. Navegação até a Pasta dos Produtos

Abra um terminal e navegue até a pasta `src/products/` do seu projeto. Use o comando `cd` para mudar de diretório:

### 3. Execução com Docker Compose

Dentro da pasta `src/products/`, execute o seguinte comando para iniciar os serviços necessários:

```bash
docker compose up -d
```

Este comando irá construir e iniciar os contêineres definidos no arquivo `docker-compose.yml` presente na pasta, configurando automaticamente o ambiente de desenvolvimento.

### Descrição dos Serviços

#### App

- **Imagem:** Utiliza a imagem `laravel-app` personalizada, construída a partir do `Dockerfile` localizado no diretório raiz do projeto.
- **Portas:** Expõe a porta `8000` do contêiner para a porta `8000` do host, permitindo o acesso ao aplicativo Laravel.
- **Volumes:** Mapeia o diretório atual do projeto para `/var/www` dentro do contêiner, garantindo que as alterações locais reflitam imediatamente no contêiner.

#### Db

- **Imagem:** Usa a imagem `mysql:latest` para fornecer um banco de dados MySQL.
- **Variáveis de Ambiente:** Configura as credenciais do banco de dados e outras configurações necessárias para o funcionamento do aplicativo.
- **Portas:** Expõe a porta `3306` do contêiner para a porta `3306` do host, permitindo conexões externas ao banco de dados.
- **Volumes:** Armazena os dados do banco de dados em um volume Docker chamado `db_data`, garantindo persistência dos dados entre reinicializações do contêiner.

#### Nginx

- **Imagem:** Utiliza a imagem `nginx:alpine` para atuar como servidor web reverso.
- **Portas:** Expõe as portas `8080` e `443` do contêiner para as mesmas portas do host, permitindo o acesso ao aplicativo via HTTP(S).
- **Volumes:** Mapeia o diretório atual do projeto para `/var/www` dentro do contêiner e também mapeia o diretório de configurações do Nginx para `/etc/nginx/conf.d/` dentro do contêiner, permitindo customizações nas configurações do servidor.

### Notas Adicionais

Se você fizer alterações nos arquivos de configuração ou no código após a inicialização, precisará reconstruir os contêineres. Para isso, use os comandos:

```bash
sudo docker compose down
sudo docker compose up
```

