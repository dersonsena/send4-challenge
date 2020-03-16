# Send4 Challenge

Feito por: Kilderson Sena ([@dersonsena](https://github.com/dersonsena))

Nesse projeto você poderá rodar uma API desenvolvido feita com Laravel e integrado com o [Shopify](https://pt.shopify.com). Mais detalhes sobre as funcionalidades pode ser visto no [Documento de Requisitos](/documento-requisitos.pdf) do teste.

## Pré-requisitos

É requisito para rodar este projeto:

- Docker;
- Usar um host UNIX;

## Instalação

### Clone do Repositório

Abra seu terminal e faça o clone deste projeto:

```bash
$ git clone git@github.com:dersonsena/send4-challenge.git
```

### Arquivo `.env`

Entre no diretório do projeto e faça uma cópia do `.env.example` renomeando para `.env` e preencha as variáveis de ambiente.

```bash
$ cd send4-challenge
$ cp .env.example .env
``` 

No arquivo `.env` já é sugerido alguns valores para algumas variáveis de ambiente, mas, fique a vontade para alterá-las de acordo com seu ambiente.

### Variáveis de Ambiente

Algumas variáveis de ambiente devem ser configuradas para que você consiga subir a API em sua máquina.

No parâmetro abaixo coloque uma senha de sua preferência para o usuário root do MySQL Server:
```
DB_PASSWORD=secret
```

A API é integrada com uma loja do Shopify e para essa integração funcionar é necessário informar a `API KEY` e o `PASSWORD`. Você pode acessar esses valores no [Documento de Requisitos](/documento-requisitos.pdf) para poder preencher no seu arquivo `.env`. 
```
SHOPIFY_API_KEY=
SHOPIFY_PASSWORD=
```

Alguns endpoints precisam fazer envio de e-mail e para isso precisamos configurar algumas informações para ter êxito. Eu criei uma conta no [Mailtrap](https://mailtrap.io) para poder usar neste teste, então, você pode usar as credenciais abaixo:
```
MAIL_PORT=2525
MAIL_USERNAME=ed8e4adb29a1d4
MAIL_PASSWORD=f528c4edabe064
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=dersonsena@gmail.com
MAIL_FROM_NAME="Send4 Notifications"
```

### 4 - Fazendo setup

Execute o comando abaixo para ser executado uma espécie de pipeline de instalação e configuração do projeto:

```bash
$ make setup
```

Se ocorrer tudo certo durante o setup os containers docker já estarão de pé e prontos para serem consumidos

> **IMPORTANTE:** ao terminar o setup o serviço de filas do laravel ficará sendo executando em background. Você poder cancelar esse processo com `CTRL + C` e para subir novamente o serviço basta executar o comando `make queueWork`.

## Enpoints

### Login

URL: `GET api/auth/login?email=admin@send4.com.br&password=admin`

> **IMPORTANTE:** ao consumir esse serviço, você deverá pegar o Token JWT de autenticação para serem informados nos outros serviços

### Me

URL: `GET /api/users/me`

Header: `Authorization Bearer <JWT_TOKEN>`

### Register

URL: `POST /api/users/register`

Header: `Authorization Bearer <JWT_TOKEN>`

Body: `{"name": "José da Silva", "email": "jose@domain.com.br", "password": "123456"}`

### My Favorites

URL: `GET /api/products/favorites`

Header: `Authorization Bearer <JWT_TOKEN>`

### Favorite Product

URL: `POST /api/products/favorite/<SHOPIFY_PRODUCT_ID>`

Header: `Authorization Bearer <JWT_TOKEN>`

### Disfavor Product

URL: `POST /api/products/disfavor/<SHOPIFY_PRODUCT_ID>`

Header: `Authorization Bearer <JWT_TOKEN>`

## Sobre o Makefile

Eu desenvolvi um script [makefile](/makefile) que só dá para ser usando nativamente em hosts UNIX. Eu uso esse script para executar rapidamente comandos dentro dos container Docker me tornando um pouco mais produtivo em comandos rotineiros. Vide exemplo abaixo:

```bash
$ make migrate
```

Esse script irá executar o comando abaixo.

```
$ docker exec -it ${DOCKER_APP_SERVICE_NAME} php artisan migrate
```

A variável de ambiente `${DOCKER_APP_SERVICE_NAME}` representa o nome do serviço relacionado ao servidor web onde estará rodando a API que pode ser visto no seu arquivo `.env`.
