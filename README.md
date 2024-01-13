# slytherin-pay
Projeto SLYTHERIN-PAY: Validador de Transações

### Instalação

1. Clonar o Projeto
1. Esse projeto possui Makefile, para subir o container basta executar `make setup`
1. Existe um arquivo `index.php` na pasta `public`, nele é possível simular a aplicação
1. Para velo rodando localmente, basta acessar o endereço [localhost](http://localhost:8089/), rodando na porta `:8089`

### Acessar o Container

1. Executar o comando `make bash` para testes de Unidade

### Testes

1. Executar o comando `make test` para testes de Unidade
1. Executar o comando `make test-coverage` para testes de Unidade com geração de HTML coma cobertura dos testes [`slytherin-pay/coverage/index.html`]
1. Executar o comando `make infection` para testes de Mutação via infection
1. Executar testes dentro do container `./vendor/bin/phpunit --coverage-html coverage`
