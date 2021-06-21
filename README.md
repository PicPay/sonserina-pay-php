# Desafio Consertando o SonserinaPay
_________
## Apresentações 
Olá, meu nome é Malfoy, Draco Malfoy, como todo bom desenvolvedor também sou um bruxo.

Crabbe, Goyle e eu estavamos cansados da burocracia de pagamentos dos duendes e resolvemos criar nosso proprio app
de pagamentos, o Sonserina Pay. Agora estamos expandindo nossas operações para o mundo dos trouxas, vamos concorrer 
com um tal de PicPay (eles estão lascados). Para garantir que nosso sistema funcione corretamente e não só por mágica, 
contratamos uma consultora externa de qualidade (Hermione Granger, aquela sabe tudo, trouxa de sangu* ***m). 

Durante os testes dela ela levantou alguns problemas no nosso software e você deverá corrigi-los,  afinal de contas eu
sou um genio da programação das trevas muito importante pra isso, mas os créditos se ficar bom serão meus ok?

Tarefas:

1 - Você deverá implementar uma classe para checagem anti fraude (App\Domain\Services\FraudChecker), eu já comecei a
criar a classe, mas fiquei com preguiça. 

A Granger pediu para fazer o código de uma maneira que mais regras podem ser implementadas nesse fluxo. 

As regras dessa classe são:
- Essa classe deve ser chamado toda vez que uma transação for criada
- A classe vai consultar 2 serviços diferentes de checagem, esses serviços são de terceiros e por isso só vamos nos 
  preocupar em se comunicar com eles através de seus clients (SDK ou API)
- Nossa classe de checagem de deverá chamar o primeiro cliente e caso ele diga que está "Autorizado" nós processaremos a
transação sem consultar o segundo
- Caso o primeiro cliente retorne que "Não está autorizado" ou falhe, iremos chamar o segundo cliente.
- Se o segundo cliente retornar que está "Autorizado" nós processaremos a transação.
- Se o segundo cliente retorne que "Não está autorizado" ou falhe. Iremos retornar uma excessão e não salvaremos a
transação
- Se possível ordem de execução dos clientes devem ser alteradas sem necessáriamente alterar a classe

2 - A classe principal do nosso serviço é o TransactionHandler (App\Domain\Services\TransactionHandler) e segundo a Granger,
nosso código não tá bom e apresenta muito erros. Precisamos que você melhore o código para nós.

Problemas que reportados:

- Tem usuários conseguindo sacar dinheiro dos lojistas
- Não estamos salvando corretamente os valores. Parece que não estão salvando a taxa do SonserinaPay, o valor total das 
taxas e o valor total correto das transações
- Notificações não estão funcionando
- Quando as notificações estavam enviando as vezes enviava mesmo quando uma transação falhava na hora de salvar.
- Precisamos colocar essa aplicação em um container (Docker) para que ela não dependa de um ambiente local
- Ela também falou que não estamos cobrindo bem a nossa aplicação com testes, eu até comecei a fazer alguns testes,
  mas achei facil demais, se você quiser pode usar ele como exemplo. Ela disse que o ideal é cobrirmos 100% dos testes. 
  Para executar os testes é só rodar `./vendor/bin/phpunit --coverage-text`.
- A Granger falou que nosso código não tá bom! Quem é essa sang#& ru$% pra falar do meu código. Disse para aplicarmos
  melhor SOLID, Object Calisthenics e conceitos do livro Clean Code (Código Limpo) do Uncle Bob. Acredito que não tem
  como melhorar esse código afinal de contas, fui eu quem fiz. Mas tenta ai só pra que eu tenha certeza que sou perfeito.
- A Granger criou uma tal de pipeline com o Github Actions, ela pediu para tentar fazer ela passar sem nenhum erro.
  
Observação:

_Não precisa se preocupar com fazer um endpoint ou cli para a execução do seu código ou com a implementação real das
chamadas para os clientes, ou persistencia em banco de dados. Faremos isso com mágica._
