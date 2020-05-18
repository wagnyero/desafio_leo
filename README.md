<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre a API

Desenvolvimento de uma API REST para cadastrar Cursos. Foi utilizado as seguintes tecnologias abaixo:

- PHP 7.4
- Laravel 7.1
- MariaDb
- JSON
- HTTP 1.1


## Processo de instalação

- Fazer uma cópia do arquivo .env.example e salvar como .env
- Criar um vhost em seu servidor para a pasta public do projeto
- Criar um database chamado desafio_leo, com charset utf8 e collation utf8_unicode_ci
- Executar o comando php artisan migrate


## Utilização dos EndPoints

- **ENDPOINT - Course**
- Listagem de todos os Cursos  
**GET**  http://seuservidor/api/v1/course  

- Listagem de um curso específico
**GET**  http://seuservidor/api/v1/course/#ID  
**CAMPOS**  
#ID = Id do Curso que deseja-se excluir  

- Busca Personalizada: trazer apenas determinados campos  
**GET**  http://seuservidor/api/v1/course?fields=id,title,description  
**CAMPOS**  
fields = informar todos os campos que desejar separados por virgula  

- Busca Personalizada: fazer busca parcial usando controladores como: =, >=, <=, like  
**GET**  http://seuservidor/api/v1/course?coditions=title:like:r%;id:>=:10  
**CAMPOS**  
coditions = esse campo recebe todas as condições que desejar fazer, no exemplo acima a api irá retornar todos os cursos que iniciam com "r" e que o id seja maior ou igual a 10  

**OBS** É possível fazer a busca parcial informando os dois campos juntos: fields e coditions  

- Novo Curso
**POST**  http://seuservidor/api/v1/course  
**CAMPOS**  
title = título do curso  
description = descrição do curso  
link_slide_show = url do slide show  
images[] = campo do tipo file, deve ser informada a imagem desejada  

- Alterar Curso
**PUT**  http://seuservidor/api/v1/course  
**CAMPOS**  
title = título do curso  
description = descrição do curso  
link_slide_show = url do slide show  
images[] = campo do tipo file, deve ser informada a nova imagem desejada  

**OBS** Para multiplas imagens basta enviar multiplos campos do tipo images[]  

- Excluir Curso  
**DELETE**  http://seuservidor/api/v1/course/#ID  
**CAMPOS**  
#ID = Id do Curso que deseja-se excluir  
