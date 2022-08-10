<?php
	if (empty($page))
		$page = 0;
?>
<ul id="conta-menu" class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link <?= $page === 1 ? 'active' : '' ?>" href="<?= $baseurl ?>minha-conta">Meus Dados</a>
	</li>
	<li class="nav-item">
		<a class="nav-link <?= $page === 2 ? 'active' : '' ?>" href="<?= $baseurl ?>meus-enderecos">Meus Endereços</a>
	</li>
	<li class="nav-item">
		<a class="nav-link <?= $page === 4 ? 'active' : '' ?>" href="<?= $baseurl ?>meus-pedidos">Pedidos Realizados</a>
	</li>
	<li class="nav-item">
		<a class="nav-link <?= $page === 3 ? 'active' : '' ?>" href="<?= $baseurl ?>minhas-avaliacoes">Minhas Avaliações</a>
	</li>
</ul>