# ArquiteturaPHP
### Instalação do projeto
```shell
C:\root_project> composer install
```
### Testes Unitários
```shell
C:\root_project> phpunit
PHPUnit 5.6.7 by Sebastian Bergmann and contributors.

..............                                                    14 / 14 (100%)

Time: 71 ms, Memory: 2.50MB

OK (14 tests, 14 assertions)

```
### Organização do projeto
```sh
C:.
│   .htaccess
│   composer.json
│   composer.lock
│   phpunit.xml
│   README.md
│
├───App
│   │   routers.php
│   │
│   ├───Controller
│   │       Welcome.php
│   │
│   ├───Kernel
│   │       Core.php
│   │       Request.php
│   │       Route.php
│   │
│   └───View
│           ViewBuilder.php
│
├───public
│   │   .htaccess
│   │   index.php
│   │
│   ├───css
│   ├───fonts
│   └───js
├───resource
│   ├───layout
│   │       footer.php
│   │       head.php
│   │       header.php
│   │
│   └───welcome
│           header.php
│           page.php
│
├───tests
│   └───App
│       └───View
│               ViewBuilderTest.php
│
└───vendor
```

Organização:
  - ./App/routers.php: 
       * Arquivo para declaração de rotas.
  - ./App/Controller/Welcome.php: 
       * Controlador de boas-vindas e serve como exemplo de uso.
  - ./App/Kernel/Core.php: 
       * Atua reflexivamente de acordo com uma requisição (classe interna da arquitetura).
  - ./App/Kernel/Request.php: 
       * Traz um meio comum para lidar com requisições (classe interna da arquitetura). 
  - ./App/Kernel/Route.php: 
       * Registra novas rotas e fornece uma interface amigável para o programador.
  - ./App/View/ViewBuilder.php: 
       * Classe helper que facilita na criação de interfaces dinâmicas.
  - ./public/index.php: 
       * Arquivo que inicia a aplicação e dá ignição ao mapeador de rotas
       * Obs: a pasta public é a única que é visível no navegador. Desse modo, os arquivos css, js e font devem ser armazenados na mesma.
  - ./resource
       *Pasta utilizada para armazenar pedaços de interfaces. 
  - ./tests
      *Pasta dedicada para os testes do PHPUnit
  
### Algumas explicações
Esta arquitetura foi criada usando php 5.6.24. Todas as requisições feitas para a arquitetura devem ser redirecionadas para o arquivo ./public/index.php. O papel de redirecionamento está sendo feito com dois arquivos .htaccess, um na raíz do projeto e outro na pasta public. No entanto, o programador poderá internalizar essas regras diretamente o Apache, por exemplo, e evitar overread.

Esta arquitetura está em fase beta, portanto ainda há restrições no seu uso. Recomenda-se que ela seja instalada na pasta root do Apache ou similar. 

### Entendendo as Rotas
##### Registrando uma rota no arquivo ./App/routes.php

```php
<?php 
use App\Kernel\Route; 

//Registrando uma rota get
Route::get('/teste', function($params){
  return $params; 
}); 

//Registrando uma rota post
Route::post('/teste', function($params){
  return $params; 
}); 

``` 
A classe Router permite que o programador registre facilmente novas rotas. No exemplo acima são registrada a mesma rota que responde a métodos diferentes. O resultado desse comando são essas rotas na sua aplicação: 

http://www.exemplo.com/teste [method get]
http://www.exemplo.com/teste [method post]

Por convenção, a classe route sempre passa um argumento $params para o método que mantém a regra de execução da rota. O output dos métodos de execução devem ser passados via return. A classe Core ajuda em alguns aspectos no retorno de dados ao usuário, um exemplo é retornos em modo texto são retornados como html normal, os retornos em array são convertidos em Json.

```php
<?php 
use App\Kernel\Route; 

//Registrando uma rota get
Route::get('/teste', function($params){
  return ['val' => 1, 'val0' => 2]; 
}); 
/*
    Resultado ao acessar a rota no navegador: 
    {"val": 1, "val0" => 2}
*/


//Registrando uma rota post
Route::post('/teste', function($params){
  return '<h1> Olá, Mundo</h1>'; 
}); 
/*
    Resultado ao acessar a rota no navegador: 
    <h1> Olá, Mundo</h1>
*/
``` 
##### Registrando um controlador em uma rota
A classe Route aceita tanto métodos anônimos quanto strings que com indentificação da classe e método que deve ser executado. Por convernção, a string deve ser escrita da seguinte forma: ClassName@methdo_name. Caso a string estaja bem formada, a classe core consegue atuar reflexivamente nos namespaces declarados na aplicação e instanciar dinamicamente a classe desejada.

A primeira etapa para utilizar essa facilidade da classe Route é declarar um controllador. Na pasta ./App/Controller/ crie: 

```php
<?php 
namespace App\Controller; 

class Teste{
  public function __construct(){
  }

  public function teste_post($param){
    return ['val' => 1, 'val0' => 2]; 
  }
  
  public function teste_get($param){
    return '<h1> Olá, Mundo</h1>'; 
  }
}
``` 
Note que os métodos de um controlador são exatamente iguais a implementação anterior com os métodos anônimos. Agora é necessário registrar as rotas e quais métodos do seu controlador devem ser acionados:

```php
<?php 
use App\Kernel\Route; 

//Registrando uma rota get
Route::get('/teste', 'Teste@teste_get'); 
/*
    Resultado ao acessar a rota no navegador: 
    {"val": 1, "val0" => 2}
*/


//Registrando uma rota post
Route::post('/teste', 'Teste@teste_post'); 
/*
    Resultado ao acessar a rota no navegador: 
    <h1> Olá, Mundo</h1>
*/
``` 
###Entendendo a classe helper ViewBuilder
A classe ViewBuilder tem o papel de anexar vários pedaços de uma interface html e uma só. O programador necessita somente indicar esses padaços da interface html por meio do sistema de arquivos. Veja um exemplo: 

```php
<?php 
namespace App\Controller; 

use App\View\ViewBuilder; 

class Welcome{
  private $view = null;   
  
  public function __construct(){
    $this->view = ViewBuilder::getInstance(); 

    $this->view
       ->set_footer('layout.footer')
       ->set_header('layout.header')
       ->set_head('layout.head'); 
  }

  public function index($param){
    return $this->view
      ->add_js_files(['js/teste.js'])
      ->add_css_files(['css/teste.css'])
      ->set_page('welcome.page')
      ->render(); 
  }
}
``` 
A classe ViewBuilder segue o padrão de projeto Singleton, portanto a sua instância pode ser facilmente recuparada através do método estático ::getInstance(). Para facilitar o uso da classe, todo métood que adiciona algo a fila de renderização retorna o próptio objeto, desse modo o programador pode encadear métodos sucessivamente.

Por convenção, o utlizador da ViewBuilder não necessita indicar o caminho completo do arquivo. Os delimitadores do sistema de arquivo devem ser '.' (pontos) invés de barras ou contra-barras. Os padaços das visões devem ser criados com a extensão .php. Internamente a classe ViewBuilder substitui os '.' (pontos) para o delimitador corrente do sistema operacional e adiciona a extensão .php nos arquivos. Os padaços das interfaces html devem ser armazenados dentro da pasta ./resource/, conforme foi mencionado acima. A classe ViewBuilder concatena o caminho relativo passado como argumento aos métodos setters o path da pasta resource.

O exemplo acima renderiza a seguinte visão no navegador: 
![](http://i.imgur.com/VF3afs1.png)

Html resultante: 
```html
<!doctype html>
<html class="no-js" lang="">

   <!-- Adiciona a tag head dinamicamente. -->
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Corollarium</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

            <link rel="stylesheet" type="text/css" href="css/teste.css">
    </head>
    <body>
    <!-- Adiciona um header dinamicamente. -->
        <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MicroFramework</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="/humano">Humano</a></li>
        <li><a href="/gato">Gato</a></li>
        <li><a href="/cachorro">Cachorro</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

        <div class="container" style="height: 550px;">
          <div class="row"> 
            <div class="col-md-4 col-md-offset-4" style="text-align: center;">
              <h1>Welcome!</h1>
              <p>This is a MicroFramework on PHP.</p>
            </div>      
          </div>
        </div>

        <!-- Adiciona um Footer dinamicamente. -->
        <footer style="background: rgba(0, 0, 0, 0.75);width: 100%;color:white;text-align: center;height: 300px;">
  <p>This is a footer!</p>
</footer>

        <!-- Recupera caso haja algum arquivo js para ser anexado. -->
                  <script src='js/teste.js'></script>
        
        <!-- Arquivos Js estáticos -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

         <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
```
Veja como os arquivos envolvidos nesse processo foram escritos: 
* [layout.footer](https://github.com/Guepardo/ArquiteturaPHP/blob/master/resource/layout/footer.php)
* [layout.header](https://github.com/Guepardo/ArquiteturaPHP/blob/master/resource/layout/header.php)
* [layout.head](https://github.com/Guepardo/ArquiteturaPHP/blob/master/resource/layout/head.php)
* [welcome.page](https://github.com/Guepardo/ArquiteturaPHP/blob/master/resource/welcome/page.php)

A palavra chave 'self' no contexto das interfaces é a própria instância da ViewBuilder.

O método render permite que o programador passe alguns argumentos adicionais para o processo de render. Tais argumentos devem ser passado no formato de hash. Veja o exemplo
![](http://i.imgur.com/IDDbTj3.png)
Nesse exemplo foi passado um arqumento 'name' via get e uma lista de amigos foi criada internamente no controlador.

Primeiro adicione a rota /welcome ao controllador Welcome e aponte o método index.
```php
Route::get('/welcome', 'Welcome@index'); 
``` 
Crie o controllador Welcome e escreva o método index.
```php
<?php 
namespace App\Controller; 
use App\View\ViewBuilder; 

class Welcome{
  private $view = null;   
  
  public function __construct(){
    $this->view = ViewBuilder::getInstance(); 

    $this->view
       ->set_footer('layout.footer')
       ->set_header('layout.header')
       ->set_head('layout.head'); 
  }

  public function index($params){

    $name = (!empty($params['name'])) ? $params['name'] : 'No argument.';

    $friends_name = ['Marcos', 'Mônica', 'Lorena', 'Carlos']; 

    $args_to_build = ['my_name' => $name, 'my_friends' => $friends_name]; 

    return $this->view
      ->add_js_files(['js/teste.js'])
      ->add_css_files(['css/teste.css'])
      ->set_page('welcome.page')
      ->render($args_to_build); 
  }
}
``` 
Crie o seu argumento e passe como parâmetro do no método render. 

```html
<!doctype html>
<html class="no-js" lang="">
   <!-- Adiciona a tag head dinamicamente. -->
   <?php echo self::get_head(); ?>
    <body>
    <!-- Adiciona um header dinamicamente. -->
        <?php echo self::get_header(); ?>
        <div class="container" style="height: 550px;">
          <div class="row"> 
            <div class="col-md-4 col-md-offset-4" style="text-align: center;">
              <h1>Welcome!</h1>
              <p>This is a MicroFramework on PHP.</p>
                    <p>My name is <b><?php echo $this->params['my_name'] ?></b></p>
            </div>    
          </div>
            <div class="row">   
                <div class="col-md-4 col-md-offset-4" style="text-align:center;">
                    <h3>These are my friends</h3>
                </div>      
            </div>
             <div class="row">   
                <div class="col-md-4 col-md-offset-4" >
                    <ul>
                        <?php foreach($this->params['my_friends'] as $name):?>
                            <button><?php echo $name; ?></button>
                        <?php endforeach; ?>
                    </ul>
                </div>      
            </div>
        </div>
        <!-- Adiciona um Footer dinamicamente. -->
        <?php echo self::get_footer(); ?>
        <!-- Recupera caso haja algum arquivo js para ser anexado. -->
        <?php foreach(self::get_js_files() as $path):?>
          <script src='<?php echo $path; ?>'></script>
        <?php endforeach; ?>
        <!-- Arquivos Js estáticos -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
         <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
``` 
No arquivo welcome.page acesse seus parâmetros via $this->params['key']; 
