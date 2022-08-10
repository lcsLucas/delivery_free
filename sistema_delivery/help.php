<?php
$menu = "Home";
$submenu = "";
include 'topo.php';

?>

<div class="block-header">
	<h2 class="titulo-pagina">Tópicos mais frequentes</h2>
</div>

<div class="accordion" id="accordionHelp">

	<h5 class="text-center text-uppercase text-dark font-weight-bold mb-4">Insumos</h5>

	<div class="card">
		<div class="card-header" id="headingOne">
			<h5 class="mb-0">
				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
					Categorias de Insumos
				</button>
			</h5>
		</div>

		<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionHelp">
			<div class="card-body">
				<p>
					Na página de categoria de insumo você pode fazer todo o gerenciamento das categorias, desde criar uma nova categoria e editar, até desatilitar ou excluir uma categoria.
				</p>

				<p>
					Campos do formulário:
				</p>

				<ul>
					<li><strong>Nome da Categoria:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a categoria. Ex: "Frios"</li>
					<li><strong>Descrição:</strong> Esse campo é opcional e se você quiser pode colocar uma descrição, que pode ser qualquer texto para essa categoria</li>
				</ul>

				<p>
					Além do formulario de cadastro dos insumos, também é listado todas as categorias já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
				</p>

			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header" id="heading2">
			<h5 class="mb-0">
				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
					Gerenciar Insumos
				</button>
			</h5>
		</div>

		<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionHelp">
			<div class="card-body">
				<p>
					Na página de gerenciar insumos você pode fazer todo o gerenciamento de seus insumos, desde cadastrar e editar, até desatilitar ou excluir um insumo.
				</p>

				<p>
					Campos do formulário:
				</p>

				<ul>
					<li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar ao seu insumo. Ex: "Calabresa"</li>
					<li><strong>Unidade de Medida:</strong> Esse campo é obrigatório e você deve selecionar qual a unidade de media você gostaria de usar para esse insumo.</li>
					<li><strong>Categoria do Insumo:</strong> Esse campo é obrigatório e você deve selecionar categoria que esse insumo pertence, para selecionar a categoria do insumo, ela já deve estar cadastrada no sistema antes de você cadastrar o novo insumo.</li>
					<li><strong>Fornecedor do Insumo:</strong> Esse campo é obrigatório e você deve selecionar o fornecedor desse insumo, para selecionar o fornecedor do insumo, ele já deve estar cadastrado no sistema antes de você cadastrar o novo insumo.</li>
					<li><strong>Controle de estoque:</strong> Esse campo é opcional e se você quiser pode checar para que o sistema faça o controle de estoque desse insumo, lembrando que por default esse campo vem desmarcado deixando explícito que por default o sistema não faz o controle de estoque dos insumos, sendo necessário ser marcado para o sistema entender que você quer que faça o controle de estoque desse insumo.</li>
					<li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação no insumo, que pode ser qualquer texto, sendo usado apenas como consulta para você sobre o insumo.</li>
				</ul>

				<p>
					Além do formulario de cadastro dos insumos, também é listado todos os insumos já cadastrados, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
					Além também de um campo de busca para filtrar os registros através da procura pelo nome do insumo.
				</p>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header" id="heading3">
			<h5 class="mb-0">
				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
					Baixa do uso
				</button>
			</h5>
		</div>

		<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionHelp">
			<div class="card-body">
				<p>
					Na página Baixa do uso você pode fazer todo o gerenciamento de consumo de seus insumos, podendo realizar uma nova baixa.
				</p>

				<p>
					Campos do formulário:
				</p>

				<ul>
					<li><strong>Selecione o Insumo:</strong> Esse campo é obrigatório e você deve selecionar o insumo que você gostaria de dar a baixa, para selecionar o insumo, ele ja deve estar cadastrado previamente no sistema antes de dar a nova baixa.</li>
					<li><strong>Selecione o Motivo:</strong> Esse campo é obrigatório e você deve selecionar o motivo que você gostaria de dar a baixa, para selecionar o motivo, ele ja deve estar cadastrado previamente no sistema antes de dar a nova baixa.</li>
					<li><strong>Quantidade usada:</strong> Esse campo é obrigatório e você deve informar a quantidade que gostaria de dar a baixa no insumo.</li>
				</ul>

				<p>
					Além do formulario de cadastro para dar nova baixa em um insumo, também é listado todas as baixas já realizadas, além de um campo de busca para filtrar os registros através da procura pelo nome do insumo ou motivo da baixa.
				</p>
			</div>
		</div>
	</div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Produtos</h5>

    <div class="card">
        <div class="card-header" id="heading4">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    Categorias de Produtos
                </button>
            </h5>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de categoria de produtos você pode fazer todo o gerenciamento das categorias, desde criar uma nova categoria e editar, até desatilitar ou excluir uma categoria.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome da Categoria:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a categoria. Ex: "Refrigerantes"</li>
                    <li><strong>Descrição:</strong> Esse campo é opcional e se você quiser pode colocar uma descrição, que pode ser qualquer texto para essa categoria</li>
                </ul>

                <p>
                    No cadastro das categorias você também pode adicionar um ou mais complementos a categoria que está cadastrando, basta você clicar no botão "Adicionar Categorias de Complementos", ao clicar nesse botão vai aparecer um bloco de campos para você poder preencher e informar as opções do novo complemento.
                    Complementos de categoria são opções adicionais que você dá ao cliente para escolher quando ele seleciona um produto que pertence a essa categoria. Por exemplo ao cadastrar uma categoria "Lanches", você pode informar para o sistema que sempre que o cliente escolher um produto que pertence a essa categoria, mostre
                    para ele os complementos "Bacon", "Salsicha" ou "Catupiry" para adicionar no produto, caso ele queira. Isso é bem útil para situações aonde apenas cadastrar o produto não é o suficiente, precisando que o cliente forneceça mais informações ao produto.
                </p>

                <p>
                    Campos do Complemento:
                </p>

                <ul>
                    <li><strong>Categoria do Complemento:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a categoria(Esse nome será mostrado para o cliente). Ex: "Selecione o Sabor"</li>
                    <li><strong>Obrigatório:</strong> Esse campo é opcional, ele serve para você dizer ao sistema se esse complemento deve ser obrigatório o preenchimento do cliente</li>
                    <li><strong>Qtde Min:</strong> Esse campo é opcional e se você quiser pode colocar a quantidade miníma de opções que o cliente deve selecionar para complemento</li>
                    <li><strong>Qtde Max:</strong> Esse campo é opcional e se você quiser pode colocar a quantidade máxima de opções que o cliente deve selecionar para complemento</li>
                </ul>

                <p>
                    Campos de cada opção do complemento:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a opção do complemento. Ex: "Sabor Morango"</li>
                    <li><strong>Descrição:</strong> Esse campo é opcional, caso você queira colocar alguma descrição na opção para ser mostrada além do nome da opção</li>
                    <li><strong>Preço:</strong> Esse campo é opcional, caso essa opção tenha um valor adicional ao produto</li>
                </ul>

                <p>
                    Além do formulario de cadastro das categorias de produtos, também é listado todas as categorias já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading5">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                    Gerenciar Produtos
                </button>
            </h5>
        </div>

        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de gerenciar produtos você pode fazer todo o gerenciamento de seus produtos, desde cadastrar e editar, até desatilitar ou excluir um produto.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar ao seu produto. Ex: "Refrigerante"</li>
                    <li><strong>Unidade de Medida:</strong> Esse campo é obrigatório e você deve selecionar qual a unidade de media você gostaria de usar para esse produto.</li>
                    <li><strong>Categoria de Produtos:</strong> Esse campo é obrigatório e você deve selecionar categoria que esse produto pertence, para selecionar a categoria do produto, ela já deve estar cadastrada no sistema antes de você cadastrar o novo insumo.</li>
                    <li><strong>Fornecedor do produto:</strong> Esse campo é opcional, neele você deve selecionar o fornecedor desse produto, para selecionar o fornecedor do produto, ele já deve estar cadastrado no sistema antes de você cadastrar o novo insumo.</li>
                    <li><strong>Preço de Custo:</strong> Esse campo é obrigatório e você deve colocar o preço de custo do produto.</li>
                    <li><strong>Preço de Venda:</strong> Esse campo é obrigatório e você deve colocar o preço de venda do produto.</li>
                    <li><strong>Controle de estoque:</strong> Esse campo é opcional e se você quiser pode checar para que o sistema faça o controle de estoque desse produto, lembrando que por default esse campo vem desmarcado deixando explícito que por default o sistema não faz o controle de estoque dos insumos, sendo necessário ser marcado para o sistema entender que você quer que faça o controle de estoque desse insumo.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação no produto, que pode ser qualquer texto, sendo usado apenas como consulta para você sobre o insumo.</li>
                    <li><strong>Imagem do Produto:</strong> Esse campo é opcional e nele você pode enviar uma imagem para o produto.</li>
                </ul>

                <p>
                    No cadastro dos produtos você também pode adicionar um ou mais complementos a categoria que está cadastrando, basta você clicar no botão "Adicionar Categorias de Complementos", ao clicar nesse botão vai aparecer um bloco de campos para você poder preencher e informar as opções do novo complemento.
                    Complementos de categoria são opções adicionais que você dá ao cliente para escolher quando ele seleciona um produto que pertence a essa categoria. Por exemplo ao cadastrar uma categoria "Lanches", você pode informar para o sistema que sempre que o cliente escolher um produto que pertence a essa categoria, mostre
                    para ele os complementos "Bacon", "Salsicha" ou "Catupiry" para adicionar no produto, caso ele queira. Isso é bem útil para situações aonde apenas cadastrar o produto não é o suficiente, precisando que o cliente forneceça mais informações ao produto.
                </p>

                <p>
                    Campos do Complemento:
                </p>

                <ul>
                    <li><strong>Categoria do Complemento:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a categoria(Esse nome será mostrado para o cliente). Ex: "Selecione o Sabor"</li>
                    <li><strong>Obrigatório:</strong> Esse campo é opcional, ele serve para você dizer ao sistema se esse complemento deve ser obrigatório o preenchimento do cliente</li>
                    <li><strong>Qtde Min:</strong> Esse campo é opcional e se você quiser pode colocar a quantidade miníma de opções que o cliente deve selecionar para complemento</li>
                    <li><strong>Qtde Max:</strong> Esse campo é opcional e se você quiser pode colocar a quantidade máxima de opções que o cliente deve selecionar para complemento</li>
                </ul>

                <p>
                    Campos de cada opção do complemento:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a opção do complemento. Ex: "Sabor Morango"</li>
                    <li><strong>Descrição:</strong> Esse campo é opcional, caso você queira colocar alguma descrição na opção para ser mostrada além do nome da opção</li>
                    <li><strong>Preço:</strong> Esse campo é opcional, caso essa opção tenha um valor adicional ao produto</li>
                </ul>

                <p>
                    Além do formulario de cadastro das categorias de produtos, também é listado todas as categorias já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Finanças</h5>

    <div class="card">
        <div class="card-header" id="heading6">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                    Contas a Pagar
                </button>
            </h5>
        </div>

        <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de Contas a Pagar, você pode fazer o gerenciamento de todas as suas contas a pagar que foram geradas através de entradas de insumos e produtos, podendo editar uma conta já existente, dar baixa na conta ou exluir.
                </p>
                <p>
                    Campos do formulário:
                </p>
                <ul>
                    <li>
                        <strong>Código:</strong> Esse campo é opcional, nele você pode colocar o código de sua contas a pagar que já existe e licar no botão ao lado com uma lupa para pesquisar por uma conta essa conta específica com esse código.
                    </li>
                    <li>
                        <strong>Nº da Parcela:</strong> Esse campo é disabilitado, ele serve apenas para mostrar o número da parcela da conta que está sendo visualizada.
                    </li>
                    <li>
                        <strong>Data da Emissão:</strong> Esse campo é disabilitado, ele serve apenas para mostrar a data em que foi emitada a conta que está sendo visualizada.
                    </li>
                    <li>
                        <strong>Data do Vencimento:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado a data do vencimento da conta.
                    </li>
                    <li>
                        <strong>Data do Pagamento:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado a data de pagamento da conta.
                    </li>
                    <li>
                        <strong>Valor da Parcela:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado o valor da conta.
                    </li>
                    <li>
                        <strong>Valor a Pagar:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado o valor pago dessa conta.
                    </li>
                    <li>
                        <strong>Finalizar Conta?:</strong> Esse campo é opcional, cso você queria finalizar a conta mesmo que o valor pago seja inferir ao valor da conta.
                    </li>
                </ul>
                <p>
                    Além do formulario de contas a pagar, também é listado todas as contas já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading7">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                    Contas a Receber
                </button>
            </h5>
        </div>

        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de Contas a Receber, você pode fazer o gerenciamento de todas as suas contas a receber que foram geradas através de entradas de insumos e produtos, podendo editar uma conta já existente, dar baixa na conta ou exluir.
                </p>
                <p>
                    Campos do formulário:
                </p>
                <ul>
                    <li>
                        <strong>Código:</strong> Esse campo é opcional, nele você pode colocar o código de sua contas a receber que já existe e licar no botão ao lado com uma lupa para pesquisar por uma conta essa conta específica com esse código.
                    </li>
                    <li>
                        <strong>Nº da Parcela:</strong> Esse campo é disabilitado, ele serve apenas para mostrar o número da parcela da conta que está sendo visualizada.
                    </li>
                    <li>
                        <strong>Data da Emissão:</strong> Esse campo é disabilitado, ele serve apenas para mostrar a data em que foi emitada a conta que está sendo visualizada.
                    </li>
                    <li>
                        <strong>Data do Vencimento:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado a data do vencimento da conta.
                    </li>
                    <li>
                        <strong>Data do Pagamento:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado a data de pagamento da conta.
                    </li>
                    <li>
                        <strong>Valor da Parcela:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado o valor da conta.
                    </li>
                    <li>
                        <strong>Valor a Receber:</strong> Esse campo é obrigatório quando você está visualizando uma conta, nele deve ser informado o valor pago dessa conta.
                    </li>
                    <li>
                        <strong>Finalizar Conta?:</strong> Esse campo é opcional, cso você queria finalizar a conta mesmo que o valor pago seja inferir ao valor da conta.
                    </li>
                </ul>
                <p>
                    Além do formulario de contas a receber, também é listado todas as contas já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Cadastros</h5>

    <div class="card">
        <div class="card-header" id="heading8">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                    Formas de Pagamento
                </button>
            </h5>
        </div>

        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Formas de pagamento você pode fazer todo o gerenciamento de seus tipos de pagamento, desde cadastrar e editar, até desatilitar ou excluir uma forma de pagamento.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome que você quer dar a nova forma de pagamento. Ex: "3 Vezes"</li>
                    <li><strong>Número de Parcelas:</strong> nEsse campo é obrigatório e você deve colocar o número de parcelas que a forma de pagamento terá.</li>
                    <li><strong>Descrição:</strong> Esse campo é opcional e se você quiser pode colocar uma descrição, que pode ser qualquer texto para essa forma de pagamento</li>
                    <li><strong>Entrada:</strong> Esse campo é opcional e se você quiser pode setar que essa forma de pagamento tem uma entrada além das parcelas</li>
                </ul>

                <p>
                    Além do formulario de cadastro das categorias de produtos, também é listado todas as categorias já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading9">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                    Gerenciar Entregadores
                </button>
            </h5>
        </div>

        <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Entregadores você pode fazer todo o gerenciamento de seus entregadores, desde cadastrar e editar, até desatilitar ou excluir um entregador.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome do entregador.</li>
                    <li><strong>Email:</strong> Esse campo é opcional, e você pode colocar o email do entregador.</li>
                    <li><strong>Telefone:</strong> Esse campo é opcional, e você pode colocar o telefone do entregador.</li>
                    <li><strong>Celular:</strong> Esse campo é obrigatório e você deve colocar o celular do entregador.</li>
                    <li><strong>Celular 2:</strong> Esse campo é opcional, e você pode colocar um segundo celular para o entregador.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação para o entregador</li>
                </ul>

                <p>
                    Você também deve colocar os dados de endereço do entregador, sendo obrigatório o preenchimento dos campos referente a rua, número, cep, bairro e cidade do entregador
                </p>

                <p>
                    Além do formulario de cadastro dos entregadores, também é listado todos os entregadores já cadastrados, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading10">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                    Gerenciar Clientes
                </button>
            </h5>
        </div>

        <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Clientes você pode fazer todo o gerenciamento de seus clientes, desde cadastrar e editar, até desatilitar ou excluir um cliente.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome:</strong> Esse campo é obrigatório e você deve colocar o nome do cliente.</li>
                    <li><strong>Email:</strong> Esse campo é opcional, e você pode colocar o email do cliente.</li>
                    <li><strong>Telefone:</strong> Esse campo é opcional, e você pode colocar o telefone do cliente.</li>
                    <li><strong>Celular:</strong> Esse campo é obrigatório e você deve colocar o celular do cliente.</li>
                    <li><strong>Celular 2:</strong> Esse campo é opcional, e você pode colocar um segundo celular para o cliente.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação para o cliente</li>
                </ul>

                <p>
                    Você também deve colocar os dados de endereço do cliente, sendo obrigatório o preenchimento dos campos referente a rua, número, cep, bairro e cidade do cliente
                </p>

                <p>
                    Além do formulario de cadastro dos clientes, também é listado todos os clientes já cadastrados, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading11">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                    Gerenciar Fornecedores
                </button>
            </h5>
        </div>

        <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Fornecedores você pode fazer todo o gerenciamento de seus fornecedores, desde cadastrar e editar, até desatilitar ou excluir um fornecedor.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Nome da Empresa:</strong> Esse campo é obrigatório e você deve colocar o nome do fornecedor.</li>
                    <li><strong>Email:</strong> Esse campo é opcional, e você pode colocar o email do fornecedor.</li>
                    <li><strong>Razão Social:</strong> Esse campo é obrigatório e você deve colocar a razão Social do fornecedor.</li>
                    <li><strong>Telefone:</strong> Esse campo é opcional, e você pode colocar o telefone do fornecedor.</li>
                    <li><strong>Celular:</strong> Esse campo é obrigatório e você deve colocar o celular do fornecedor.</li>
                    <li><strong>Celular 2:</strong> Esse campo é opcional, e você pode colocar um segundo celular para o fornecedor.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação para o fornecedor</li>
                </ul>

                <p>
                    Você também deve colocar os dados de endereço do fornecedor, sendo obrigatório o preenchimento dos campos referente a rua, número, cep, bairro e cidade do fornecedor
                </p>

                <p>
                    Além do formulario de cadastro dos fornecedores, também é listado todos os fornecedores já cadastrados, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Movimentos</h5>

    <div class="card">
        <div class="card-header" id="heading12">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                    Entrada de Insumos
                </button>
            </h5>
        </div>

        <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Entrada de Insumos você pode fazer todo o gerenciamento de suas entradas de insumos, desde cadastrar e editar, até excluir uma entrada.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Número da Compra:</strong> Esse campo é opcional e você pode colocar o número de uma entrada para fazer a busca por essa entrada específica.</li>
                    <li><strong>Número da Nota:</strong> Esse campo é opcional e você pode colocar o número da nota fiscal para ficar como referência da conta quando precisar fazer uma busca.</li>
                    <li><strong>Data da Compra:</strong> Esse campo é obrigatório e você deve informar a data que ocorreu a compra.</li>
                    <li><strong>Forma de Pagamento:</strong> Esse campo é obrigatório e você deve informar a forma de pagamento dessa compra.</li>
                    <li><strong>Insumo:</strong> Esse campo é obrigatório e você deve informar todos os insumos que foram comprados nessa entrada.</li>
                    <li><strong>Qtde:</strong> Esse campo é obrigatório e você deve informar as quantidades de cada insumo que está vinculado nessa entrada.</li>
                    <li><strong>Preço:</strong> Esse campo é obrigatório e você deve informar os preços de cada insumo que está vinculado nessa entrada.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação para o fornecedor</li>
                    <li><strong>Valor do Frete:</strong> Esse campo é opcional e se você quiser pode informar o valor do frete dessa conta.</li>
                    <li><strong>Valor do Desconto:</strong> Esse campo é opcional e se você quiser pode informar o valor de desconto dessa conta.</li>
                    <li><strong>Outros Valores:</strong> Esse campo é opcional e se você quiser pode informar outros valores presente nessa conta.</li>
                </ul>

                <p>
                    Após o confirmamento da entrada de insumos, caso você tenha selecionado uma forma de pagamento à prazo, se abrirá as janelas para definir as contas a pagar no sistema. Aonde você poderá definir a data de vencimento da conta e o valor dela.
                </p>

                <p>
                    Além do formulario de cadastro das entradas de insumos, também é listado todas as entradas já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading13">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                    Entrada de Produtos
                </button>
            </h5>
        </div>

        <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Entrada de Produtos você pode fazer todo o gerenciamento de suas entradas de produtos, desde cadastrar e editar, até excluir uma entrada.
                </p>

                <p>
                    Campos do formulário:
                </p>

                <ul>
                    <li><strong>Número da Compra:</strong> Esse campo é opcional e você pode colocar o número de uma entrada para fazer a busca por essa entrada específica.</li>
                    <li><strong>Número da Nota:</strong> Esse campo é opcional e você pode colocar o número da nota fiscal para ficar como referência da conta quando precisar fazer uma busca.</li>
                    <li><strong>Data da Compra:</strong> Esse campo é obrigatório e você deve informar a data que ocorreu a compra.</li>
                    <li><strong>Forma de Pagamento:</strong> Esse campo é obrigatório e você deve informar a forma de pagamento dessa compra.</li>
                    <li><strong>Produto:</strong> Esse campo é obrigatório e você deve informar todos os produtos que foram comprados nessa entrada.</li>
                    <li><strong>Qtde:</strong> Esse campo é obrigatório e você deve informar as quantidades de cada produto que está vinculado nessa entrada.</li>
                    <li><strong>Preço:</strong> Esse campo é obrigatório e você deve informar os preços de cada produto que está vinculado nessa entrada.</li>
                    <li><strong>Observação:</strong> Esse campo é opcional e se você quiser pode colocar uma observação para o fornecedor</li>
                    <li><strong>Valor do Frete:</strong> Esse campo é opcional e se você quiser pode informar o valor do frete dessa conta.</li>
                    <li><strong>Valor do Desconto:</strong> Esse campo é opcional e se você quiser pode informar o valor de desconto dessa conta.</li>
                    <li><strong>Outros Valores:</strong> Esse campo é opcional e se você quiser pode informar outros valores presente nessa conta.</li>
                </ul>

                <p>
                    Após o confirmamento da entrada de produtos, caso você tenha selecionado uma forma de pagamento à prazo, se abrirá as janelas para definir as contas a pagar no sistema. Aonde você poderá definir a data de vencimento da conta e o valor dela.
                </p>

                <p>
                    Além do formulario de cadastro das entradas de produtos, também é listado todas as entradas já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: desabilitar, editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading14">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                    Pedidos Realizados
                </button>
            </h5>
        </div>

        <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Pedidos Realizados você pode visualizar todos os pedidos já realizados no seu restaurante, podendo ver mais detalhes de um pedido específico clicando no botão "detalhes", onde mostrará todos os detalhes do pedido, como o cliente, produtos, valores, além do status do pedido.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading15">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                    Avaliações de Pedidos
                </button>
            </h5>
        </div>

        <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Avaliações de Pedidos você poderá visualizar todas as avaliações que foram feitas no seu restaurante através do site, você visualizará as notas e os comentários que cada cliente deixou do seu pedido no restaurante.
                    Você também poderá responder a essas avaliações colocando uma mensgem como resposta a avaliação, clicando no botão "Responder" abrirá um campo para você colocar sua resposta a avaliação e poder dar a resposta.
                </p>

            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Promoções</h5>

    <div class="card">
        <div class="card-header" id="heading16">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                    Gerenciar Promoções de Produtos
                </button>
            </h5>
        </div>

        <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Promoções de Produtos você pode fazer todo o gerenciamento de suas promoções, desde cadastrar e editar, até excluir uma promoção.
                </p>
                <p>
                    Campos do formulário:
                </p>
                <ul>
                    <li><strong>Nome da Promoção:</strong> Esse campo é obrigatório e você deve colocar o nome da Promoção.</li>
                    <li>
                        <strong>Data de Início:</strong> Esse campo é obrigatório e você deve colocar a data inicial que você quer que a promoção comece.
                    </li>
                    <li>
                        <strong>Data Final:</strong> Esse campo é obrigatório e você deve colocar a data final que você quer que a promoção encerre.
                    </li>
                    <li>
                        <strong>Tipo de Desconto:</strong> Esse campo é obrigatório e você deve selecionar o tipo de desconto que você quer aplicar nos produtos, podendo escolher o desconto "Porcentual" ou "Valor Fixo"
                    </li>
                    <li>
                        <strong>Porcentagem do Desconto:</strong> Esse campo é obrigatório caso você tenha selecionado "Porcentual" no campo Tipo de desconto, nele você deve colocar colocar o percentual de desconto que será aplicado nos produtos.
                    </li>
                    <li>
                        <strong>Valor do Desconto:</strong> Esse campo é obrigatório caso você tenha selecionado "Valor Fixo" no campo Tipo de desconto, nele você deve colocar colocar o valor fixo de desconto que será aplicado nos produtos.
                    </li>
                    <li><strong>Produto:</strong> Esse campo é obrigatório e você deve informar todos os produtos que gostaria de aplicar a promoção.</li>

                </ul>
                <p>
                    Além do formulario de promoção de produtos, também é listado todas as promoções já cadastradas, onde é possível realizar algumas ações para cada registros listado, como: editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading17">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                    Gerenciar Cupons Promocionais
                </button>
            </h5>
        </div>

        <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Cupons Promocionais você pode fazer todo o gerenciamento de seus cupons promocionais, desde cadastrar e editar, até excluir um cupom.
                </p>
                <p>
                    Campos do formulário:
                </p>
                <ul>
                    <li><strong>Código Promocional:</strong> Esse campo é obrigatório e você deve colocar o código de identifcação que gostaria para o cupom.</li>
                    <li><strong>Nome da Promoção:</strong> Esse campo é obrigatório e você deve colocar o nome do cupom.</li>
                    <li>
                        <strong>Data de Início:</strong> Esse campo é obrigatório e você deve colocar a data inicial que você quer que a promoção comece.
                    </li>
                    <li>
                        <strong>Data Final:</strong> Esse campo é obrigatório e você deve colocar a data final que você quer que a promoção encerre.
                    </li>
                    <li>
                        <strong>Tipo de Desconto:</strong> Esse campo é obrigatório e você deve selecionar o tipo de desconto que você quer aplicar nos produtos, podendo escolher o desconto "Porcentual" ou "Valor Fixo"
                    </li>
                    <li>
                        <strong>Porcentagem do Desconto:</strong> Esse campo é obrigatório caso você tenha selecionado "Porcentual" no campo Tipo de desconto, nele você deve colocar colocar o percentual de desconto que será aplicado nos produtos.
                    </li>
                    <li>
                        <strong>Valor do Desconto:</strong> Esse campo é obrigatório caso você tenha selecionado "Valor Fixo" no campo Tipo de desconto, nele você deve colocar colocar o valor fixo de desconto que será aplicado nos produtos.
                    </li>
                </ul>
                <p>
                    Além do formulario de cupons promocionais, também é listado todos os cupons já cadastrados, onde é possível realizar algumas ações para cada registros listado, como: editar e excluir, bastando apenas clicar no botão associado a cada ação que está na tabela.
                </p>
            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Configurações</h5>

    <div class="card">
        <div class="card-header" id="heading18">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                    Categorias da Cozinha
                </button>
            </h5>
        </div>

        <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página Categorias da Cozinha você pode selecionar os tipos de cozinhas que o seu restaurante prepara, isso serve para podermos dar uma visibilidade melhor ao seu restaurante nessas cozinhas selecionadas. Nessa página a esquerda é listado todas as cozinhas cadastradas no Delivery Free e a direita todas
                    as cozinhas a qual você selecionou para o seu restaurante, sendo organizadas por ordem de importância, sendo a primeira cozinha principal e assim por diante.
                </p>
                <p>
                    <span class="text-info">OBS: </span> Caso o seu restaurante tenha alguma prato que pertence a uma categoria de cozinha a qual não está listado, por favor entre em contato com a gente pela página Fale Conosco
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading19">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse19" aria-expanded="false" aria-controls="collapse19">
                    Informações
                </button>
            </h5>
        </div>

        <div id="collapse19" class="collapse" aria-labelledby="heading19" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Informações você pode colocar as informações mais importantes do seu restaurante para serem visualizadas pelos seus clientes, desde o nome do restaurante e descrição, até o o endereço e
                    telefones para contato, lembre-se essas informações são muito importante para o cliente conseguir entrar em contato com vocês caso ocorrá alguma coisa, então mantenha sempre esses dados atualizados.
                </p>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading20">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse20" aria-expanded="false" aria-controls="collapse20">
                    Gerenciar Imagens
                </button>
            </h5>
        </div>

        <div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordionHelp">
            <div class="card-body">

                <p>
                    Na página de Gerenciar Imagens você pode enviar a logo e o favicon do seu restaurante para aparecerem na página do seu restaurante, lembre-se que é sempre muito importante dar uma boa impressão ao cliente.
                </p>

            </div>
        </div>
    </div>

    <h5 class="text-center text-uppercase text-dark font-weight-bold mb-4 mt-5">Dashboard</h5>

    <div class="card">
        <div class="card-header" id="heading21">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse21" aria-expanded="false" aria-controls="collapse21">
                    Como definir o tempo estimado de entrega
                </button>
            </h5>
        </div>

        <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de Dashboard você poderá definir o tempo de entrega estimado naquele momento do seu restaurante, isso serve para que os cliente tenham uma noção do quanto eles possivelmente deveram esperar para que o pedido seja feito e entregue em seu endereço naquela hora.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading22">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                    Como definir o preço de entrega
                </button>
            </h5>
        </div>

        <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de Dashboard você poderá definir o preço de entrega do restaurante, esse preço será cobrado nos pedidos realizados. O preço de entrega é fixo, ou seja não é possível fazer o controle dos preço de entrega pelo site, todas as entregas independente da distância teram o mesmo valor.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading23">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse23" aria-expanded="false" aria-controls="collapse23">
                    Como aceitar ou recusar pedidos em aberto
                </button>
            </h5>
        </div>

        <div id="collapse23" class="collapse" aria-labelledby="heading23" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Na página de Dashboard você poderá ver e gerenciar todos os pedidos em abertos que são os pedidos realizados pelos clientes que ainda não foram aceitos pelo restaurante, em cada pedido você poderá ver os dados do cliente como o endereço e clicar em "detalhes"
                    para poder ver mais detalhes dos itens que foram pedidos e ver mais dados do cliente. Nessa fase você possui duas ações que são a de "recusar" o pedido ou "aceitar" o pedido. Ao recusar um pedido, o status do pedido será alterado para "Pedido cancelado", e será visível para o
                    cliente que o pedido foi cancelado. Caso o pedido seja aceito, seu status será alterado para "pedido em andamento" e isso também será visível ao cliente que o pedido está sendo preparando pelo restaurnate.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading24">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse24" aria-expanded="false" aria-controls="collapse24">
                    Como realizar uma nova entrega
                </button>
            </h5>
        </div>

        <div id="collapse24" class="collapse" aria-labelledby="heading24" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Assim que você aceita um pedido em aberto, seu status é alterado para "pedido em andamento", que é o momento em que o pedido está sendo preparado pela cozinha, após ele ser preparado e iniciar uma nova entrega,
                    você pode também registrar essa nova entrega no sistema, na parte de "realizar nova entrega", a onde basta você selecionar o entregador que fará a entrega e selecionar os pedidos que fará parte dessa entrega e confirmar. Com esse controle, o sistema consegue ir atualizando o cliente do status
                    em que seu pedido está, deixando-o mais tranquilo quanto ao seu processo.
                </p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading25">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse25" aria-expanded="false" aria-controls="collapse25">
                    Como Finalizar uma entrega em andamento
                </button>
            </h5>
        </div>

        <div id="collapse25" class="collapse" aria-labelledby="heading25" data-parent="#accordionHelp">
            <div class="card-body">
                <p>
                    Após iniciar uma entrega, todas as entregas em andamento ficam na área de "Finalizar entrega", assim que os entregadores retornam basta você selecionar uma ou mais entregas para finaliza-lá, alterando os status dos pedidos dessas entregas para "pedido entregue"
                </p>
            </div>
        </div>
    </div>

</div>


<?php
include 'rodape.php';
?>

