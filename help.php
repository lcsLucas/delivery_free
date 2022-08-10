<?php
	include_once "topo.php";

    $fancybox = true;
?>

<div class="container mt-5 mb-5">

    <h2 id="titulo-pagina" class="text-center">
        Tópicos Frequentes
        <hr>
    </h2>

    <div class="accordion" id="accordionHelp">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Como se cadastrar no site?
                    </button>
                </h5>
            </div>

            <style>

                .wrapper-img-fancy {
                    width: 300px;
                    height: 250px;
                    overflow: hidden;
                    padding: 10px;
                    margin: 10px;
                }

                a[data-fancybox] img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }

            </style>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Para a utilização do Delivery Free é necessário que você tenha uma conta para que possamos lhe oferecer uma melhor experiência na utilização do site.
                    </p>
                    <p>
                        Para realizar o cadastro, é muito simples, basta que você acesse a página de <a target="_blank" href="<?= $baseurl ?>cadastro">cadastro</a>, onde você poderá preencher o formulário para criar uma nova conta no site.
                    </p>
                    <p>
                        Após informar os seus dados e confirmar os termos de uso do site, sua conta já estará ativada, assim como todas as funcionalidades do site também estaram disponiveis para você começar a utilizar!!!
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Area para se cadastrar" data-fancybox="galeria-anuncio" href="<?= $baseurl ?>img/help/print-cad-1.jpg">
                                <img src="<?= $baseurl ?>img/help/print-cad-1-thumb.jpg" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">

                            <a class="text-center" data-caption="Página de cadastro" data-fancybox="galeria-anuncio" href="<?= $baseurl ?>img/help/print-cad-2.jpg">
                                <img src="<?= $baseurl ?>img/help/print-cad-2-thumb.jpg" class="img-fluid" alt="">
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Como realizar o login da minha conta?
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>Caso você já tenha um cadastro no site, você pode realizar o login através da página de <a target="_blank" href="<?= $baseurl ?>login">login</a> para poder entrar em sua conta e continuar utilizando todos os recuros do Delivery Free, podendo alterar suas informações ou endereços, fazer pedidos, ver pedidos e avaliações já realizados no site.</p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">

                            <a class="text-center" data-caption="Area para fazer login" data-fancybox="galeria-login" href="<?= $baseurl ?>img/help/print-login-1.jpg">
                                <img src="<?= $baseurl ?>img/help/print-login-1.jpg" class="img-fluid" alt="">
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Como recuperar minha senha?
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Caso você tenha esqucido a sua senha, você pode acessar a página de <a target="_blank" href="<?= $baseurl ?>login">recuperar minha senha</a>, onde você informará seu email cadastrado no site para receber mais intruções de como você conseguir redefinir sua senha.
                    </p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading4">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Como alterar meus dados cadastrados?
                    </button>
                </h5>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Para você poder alterar seu cadastrado, você deverá estar logado no site com a sua conta cadastrada. Assim que você estiver logado basta você acessar a página  <a target="_blank" href="<?= $baseurl ?>minha-conta">minha conta</a> para alterar suas informações.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">

                            <a class="text-center" data-caption="Area para alterar seus dados" data-fancybox="galeria-conta" href="<?= $baseurl ?>img/help/print-conta.png">
                                <img src="<?= $baseurl ?>img/help/print-conta.png" class="img-fluid" alt="">
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading5">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        Como alterar minha senha?
                    </button>
                </h5>
            </div>
            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Para você poder alterar sua senha, você deverá estar logado no site com a sua conta cadastrada. Assim que você estiver logado basta você acessar a página  <a target="_blank" href="<?= $baseurl ?>minha-conta">minha conta</a> e ir na seção "Alterar minha senha " para conseguir informar a nova senha.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">

                            <a class="text-center" data-caption="Area para alterar sua senha" data-fancybox="galeria-conta" href="<?= $baseurl ?>img/help/print-conta-2.png">
                                <img src="<?= $baseurl ?>img/help/print-conta-2.png" class="img-fluid" alt="">
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading12">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                        Como cadastrar meus endereços para a entrega?
                    </button>
                </h5>
            </div>
            <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordionHelp">
                <div class="card-body">

                    <p>
                        Você pode cadastrar vários endereços para poder selecioná-lo quando estiver finalizando o pedido. Na página
                        <a href="<?= $baseurl ?>meus-enderecos">meus endereços</a> você encontra todos os endereços cadastrados e também pode cadastrar um novo endereço.
                    </p>

                    <p>
                        Para cadastrar um novo endereço, você deve colocar o CEP do endereço e clicar no botão "Prosseguir", após clicar nesse botão será mostrado para você os campos dos
                        endereços pré-preenchidos para você conferir as informações e terminar de preencher com o número da residência ou corrigir alguma informação caso ela esteja desatualizada. Após ter feito isso, é só clicar em "Confirmar" para
                        cadastrar o novo endereço.
                    </p>

                    <p>
                        Abaixo do cadastro de endereços você verá listado todos os seus endereços já cadastrados, você pode cadastrar até 5 endereços no site (não sendo permitido mais que isso). Cada endereço possui uma
                        opção com o ícone de uma "estrela" para você poder defini-lo como sendo o endereço principal de entregas, caso o endereço tenha esse "status" ele será utilizado para o site saber quando quando você estiver finaliando o pedido
                        qual é o endereço que você gostaria de pré-definir para a entrega (lembrando que mesmo que você tenha um endereço "principal" você ainda poderá alterar o endereço de entrega) na hora de finalizar o pedido.
                    </p>

                    <p>
                        Além da opção de definir um endereço principal, existe outra opção nos endereços listados, que é a de você pode excluir um endereço, caso você não veja mais utilidade de listar ele. Lembrando que ao excluir um endereço, não será mais possível recuperá-lo,
                        tendo que cadastra-lo novamente caso queria utiliza-lo novamente.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Area para cadastrar endereços" data-fancybox="galeria-endereco" href="<?= $baseurl ?>img/help/print-end-1.png">
                                <img src="<?= $baseurl ?>img/help/print-end-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Area para cadastrar endereços" data-fancybox="galeria-endereco" href="<?= $baseurl ?>img/help/print-end-2.png">
                                <img src="<?= $baseurl ?>img/help/print-end-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Area para cadastrar endereços" data-fancybox="galeria-endereco" href="<?= $baseurl ?>img/help/print-end-3.png">
                                <img src="<?= $baseurl ?>img/help/print-end-3.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Area para cadastrar endereços" data-fancybox="galeria-endereco" href="<?= $baseurl ?>img/help/print-end-4.png">
                                <img src="<?= $baseurl ?>img/help/print-end-4.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading7">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        Onde posso ver as informações dos restaurantes?
                    </button>
                </h5>
            </div>
            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Na página dos <a target="_blank" href="<?= $baseurl ?>restaurantes">restaurantes</a> você encontrará uma lista com todos os restaurantes que estão próximos a você(caso esteja logado), você pode definir um filtro para organizar a listagem dos restaurantes.
                    </p>
                    <p>
                        No filtro você pode definir mostrar os restaurantes por avaliações de outros clientes que já fizeram algum pedido com eles, ou também organizar a lista por categorias de cozinha e/ou tempo estimado de entrega do restaurante. Além de ter sempre disponível para você o campo de busca
                        no topo do site para você poder fazer uma busca por um restaurante específico ou procurar restaurantes que sirvam uma cozinha específica que você goste, como por exemplo "comida japonesa"
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos restaurantes" data-fancybox="galeria-restaurantes" href="<?= $baseurl ?>img/help/print-rest-1.png">
                                <img src="<?= $baseurl ?>img/help/print-rest-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Detalhes do restaurante" data-fancybox="galeria-restaurantes" href="<?= $baseurl ?>img/help/print-rest-2.png">
                                <img src="<?= $baseurl ?>img/help/print-rest-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading8">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                        Como selecionar os produtos para colocar no carrinho?
                    </button>
                </h5>
            </div>
            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionHelp">
                <div class="card-body">

                    <p>
                        Assim que você seleciona um restaurante, você é levado para a página de produtos desse restaurante, nessa página você pode ver alguns detalhes do restaurante como por exemplo o tempo estimado de entrega dos pedidos, as avaliações de outros clientes que já fizeram pedidos nesse restaurante e além dos dados para entrar em contato com o restaurante.
                    </p>

                    <p>
                        Além disso você verá todo o cardápio com os produtos desse restaurante, onde estará disponivel para você selecionar o produto desejável e então assim que você selecionar o produto, se abrirá uma janela de opções para você poder colocar a quantidade que gostaria desse produto e se quiser colocar alguma observação para esse item.
                    </p>
                    <p>
                        Em alguns produtos na janela de opções que se abre quando você o seleciona, você verá que além de poder colocar a quantidade e a observação do produto, você ainda poderá selecionar itens complementares para o produto, esses itens complementares poderam ser obrigatórios ou opcionais dependendo do produto e além disso podem ou não impactar o preço final do produto, caso sejam adicionados
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos produtos do restaurante" data-fancybox="galeria-carrinho" href="<?= $baseurl ?>img/help/print-carr-1.png">
                                <img src="<?= $baseurl ?>img/help/print-carr-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos produtos do restaurante" data-fancybox="galeria-carrinho" href="<?= $baseurl ?>img/help/print-carr-2.png">
                                <img src="<?= $baseurl ?>img/help/print-carr-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos produtos do restaurante" data-fancybox="galeria-carrinho" href="<?= $baseurl ?>img/help/print-carr-3.png">
                                <img src="<?= $baseurl ?>img/help/print-carr-3.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos produtos do restaurante" data-fancybox="galeria-carrinho" href="<?= $baseurl ?>img/help/print-carr-4.png">
                                <img src="<?= $baseurl ?>img/help/print-carr-4.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading9">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                        Como aplicar um cupom promocional no meu pedido?
                    </button>
                </h5>
            </div>
            <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Caso você tenha um cupom promocional de um restaurante, você poderá receber um desconto quando for fazer um pedido nesse restaurante. Depois de selecionar os produtos, na página de confirmação do pedido, basta você informar o código do cupom para aplicar o desconto no seu pedido.
                    </p>

                    <p>
                        <strong class="text-danger text-uppercase">Atenção: </strong> Cada restaurante possui seus próprios códigos de cupom promocional, ou seja um cupom promocional de um restaurante não funcionará caso seja aplicado em um restaurante diferente, então sempre verique corretamente de que restaurante pertence o código promocional que você possui.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de cupom promocional" data-fancybox="galeria-cupom" href="<?= $baseurl ?>img/help/print-cupom-1.png">
                                <img src="<?= $baseurl ?>img/help/print-cupom-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de cupom promocional" data-fancybox="galeria-cupom" href="<?= $baseurl ?>img/help/print-cupom-2.png">
                                <img src="<?= $baseurl ?>img/help/print-cupom-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de cupom promocional" data-fancybox="galeria-cupom" href="<?= $baseurl ?>img/help/print-cupom-3.png">
                                <img src="<?= $baseurl ?>img/help/print-cupom-3.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading10">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                        Como realizar um pedido?
                    </button>
                </h5>
            </div>
            <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Após você selecionar os produtos e coloca-lo no carrinho, você irá para tela de confirmação do pedido, caso já esteja logado, senão terá que fazer o login ou se cadastrar, se não tiver uma conta.
                    </p>
                    <p>
                        Na página de confirmação de pedido você verá todos os itens que você colocou no carrinho, além de seus valores. Nessa página você poderá aplicar um cupom promocional caso tenha e prosseguir para a página de
                        finalização do pedido.
                    </p>
                    <p>
                        Na página de finalização de pedido você poderá escolher a forma de pagamento que gostaria de pagar o pedido, podendo escolher entre pagamento em dinheiro ou cartão. Caso escolha pagar em dinheiro, você poderá informar se
                        precisará que o entregador leve troco na hora da entrega, caso não precise, você poderá ignorar esse campo, e ir para a parte das informações de entrega no endereço, caso escolha o pagamento em cartão, você informará os dados
                        do cartão e o pagamento é confirmado na hora para o restaurante.
                    </p>
                    <p>
                        Na parte de informações para entrega, você pode selecionar o endereço onde você quer que seja entregue o pedido selecionando um de seus endereços já cadastrados, caso não tenha nenhum endereço cadastrado você terá que
                        cadastrar um endereço antes de finalizar o pedido. Assim que todos os dados de pagamento estiver preenchidos e o endereço selecionado, você poderá finalizar o pedido.
                    </p>
                    <p>
                        Após o pedido ser confirmado, você poderá conferir o andamento do seu pedido através da
                        página <a target="_blank" href="<?= $baseurl ?>meus-pedidos">meus pedidos</a>, nessa página você encontrará todos os seus pedidos realizados assim como o status de cada um.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de pedido" data-fancybox="galeria-pedido" href="<?= $baseurl ?>img/help/print-ped-1.png">
                                <img src="<?= $baseurl ?>img/help/print-ped-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de pedido" data-fancybox="galeria-pedido" href="<?= $baseurl ?>img/help/print-ped-2.png">
                                <img src="<?= $baseurl ?>img/help/print-ped-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de pedido" data-fancybox="galeria-pedido" href="<?= $baseurl ?>img/help/print-ped-3.png">
                                <img src="<?= $baseurl ?>img/help/print-ped-3.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página de pedido" data-fancybox="galeria-pedido" href="<?= $baseurl ?>img/help/print-ped-4.png">
                                <img src="<?= $baseurl ?>img/help/print-ped-4.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading11">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                        Como cancelar um pedido?
                    </button>
                </h5>
            </div>
            <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Caso você queira cancelar um pedido já realizado, atente para o status em que seu pedido se encontra, caso ele ainda esteja com o status de
                        <strong>"aguardando"</strong> ou <strong>"em andamento"</strong>, você ainda pode tentar fazer o cancelamento do pedido entrando em contato diretamente com o restaurante (os dados para contato com o restaurante se encontra no topo de sua página do cardápio)
                        para cancelar seu pedido, ficando a cargo do restaurante cancelar o pedido no sistema para o sitema gerar o cancelamento da operação do cartão caso o pedido tenha sido pago com um cartão de crédito.
                    </p>

                    <p>
                        Caso o pedido já esteja com o status de "<strong>saiu para a entrega</strong>" ou
                        "<strong>pedido entregue</strong>" não é mais possível fazer o cancelamento do pedido pelo sistema. Caso você tenha algum problema após o pedido ser entregue, por favor entre em contato diretamente com o restaurante.
                    </p>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="heading13">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                        Onde vejo meus pedidos já realizados?
                    </button>
                </h5>
            </div>
            <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Você pode visualizar seus pedidos realizados na página <a target="_blank" href="<?= $baseurl ?>meus-pedidos">pedidos realizados</a>, nesssa página é mostrado todos os pedidos que você já fez, além de mostrar os detalhes de cada pedido junto com o status de cada um.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página dos pedidos realizados" data-fancybox="galeria-realizado" href="<?= $baseurl ?>img/help/print-rea-1.png">
                                <img src="<?= $baseurl ?>img/help/print-rea-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card border-bottom-0">
            <div class="card-header" id="heading14">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                        Como faço para avaliar meus pedidos realizados?
                    </button>
                </h5>
            </div>
            <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordionHelp">
                <div class="card-body">
                    <p>
                        Você pode avaliar todos os pedidos que você já realizado, na página <a href="<?= $baseurl ?>minhas-avaliacoes">minhas
                            avaliações</a>, você encontrará todas as avaliações que você já fez e os pedidos que ainda não foram avaliados para você avaliar.
                    </p>

                    <div class="d-flex justify-content-center">

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página das avaliações" data-fancybox="galeria-avaliacoes" href="<?= $baseurl ?>img/help/print-ava-1.png">
                                <img src="<?= $baseurl ?>img/help/print-ava-1.png" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="wrapper-img-fancy img-thumbnail">
                            <a class="text-center" data-caption="Página das avaliações" data-fancybox="galeria-avaliacoes" href="<?= $baseurl ?>img/help/print-ava-2.png">
                                <img src="<?= $baseurl ?>img/help/print-ava-2.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>


<?php
	include_once "rodape.php";
?>