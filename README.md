# api-plan

## Build Setup

```bash
# execute
$ docker-compose up -d --build

# Instale as dependências caso não o foram
$ docker-compose exec app compose install

# acessando serviço php Ex, provavelmente nao será necessário, porq o já está mepeado com o servidor :
$ docker-compose exec app php artisan serve

# rode os seeds
$ docker-compose exec app php artisan db:seed

# O php inciará na porta:9000
# O banco inciará na informada no env
# O servidor inciará na porta:8000 - acesse http://localhost:8000
```

## Login
 verifique users  criados no banco e a senha padrao é password

## api
    >> para testar a api user o prefix api/api
    >> o prefix /frontend é para a autenticacao das rotas do fronte

## porta
    A porta que dev iniciar dev ser a 8000 para autenticacao do frontend funcionar
