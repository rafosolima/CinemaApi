
<p  align="center"><img  src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg"  width="400"></p>
<p  align="center">
<a  href="https://travis-ci.org/laravel/framework"><img  src="https://travis-ci.org/laravel/framework.svg"  alt="Build Status"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/d/total.svg"  alt="Total Downloads"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/v/stable.svg"  alt="Latest Stable Version"></a>
<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/license.svg"  alt="License"></a>
</p>

## Sobre a API
Uma aplicação em Laravel, que permite cadastrar, editar, listar e deletar filmes, atores, diretores e classificação indicativa. Utilizando autenticação JWT para realizar as ações do sistema.
## Instalação
Para iniciar o projeto veja o guia de instalação do Laravel na <a href="https://laravel.com/docs/7.x/installation">Documentação Oficial</a>
 1. Clonar o projeto:
```php
git clone git@github.com:Rafosoboy/CinemaApi.git api && cd api
```
 2. Instalar as dependências:
```php
composer install
```
 3. Copiar o arquivo .env.exemple para a raiz do projeto .env
 ```php
cp ~/CinemaApi/.env.exemple ~/CinemaApi/.env
```
 4. Configurar as informações necessárias para o banco de dados.
 ```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
 5. Gerar chave do laravel:
```php
php artisan key:generate
```
 6. Gerar chave JWT:
```php
php artisan jwt:secret
```
 7. Inicializar a migração das tabelas
```php
php artisan migrate
```
 8. Inicializar o server
 ```php
php artisan serve
 ```
## Extras
Na pasta extras, encontra-se o DER e as configurações do Postman, para auxiliar nas rotas.
## Testes
Caso a necessidade de executar os testes, basta configurar o banco e executar o comando:
```php
php artisan test
```
## Licença
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
