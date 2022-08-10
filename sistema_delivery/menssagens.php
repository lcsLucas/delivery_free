<?php 
if(isset($sucessoinserir)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> Cadastro realizado com sucesso.
</div>
<?php 
}
if(isset($erroinserir)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Não foi possivel inserir os dados.
</div>
<?php 
}
if(isset($sucessoalterar)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> Cadastro alterado com sucesso.
</div>
<?php 
}
if(isset($erroalterar)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Não foi possivel alterar os dados.
</div>
<?php
}
if(isset($sucessodeletar)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> Cadastro deletado com sucesso.
</div>
<?php 
}
if(isset($errodeletar)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Não foi possivel deletar os dados, verifique se não existe relação com outros cadastros.
</div>
<?php
}
if(isset($errousuarioexiste)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> O usuário que você está tentando cadastrar já está reservado em nosso banco de dados. Informe outro
</div>
<?php
}
if(isset($erroemailexiste)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> O email que você está tentando cadastrar já está reservado em nosso banco de dados. Informe outro
</div>
<?php
}
if(isset($errorelacionar)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Não foi possivel relacionar esse tipo de ususário.
</div>
<?php
}
if(isset($sucessorelacionar)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucess!</a> Tipo de usuário relacionado.
</div>
<?php 
}
if(isset($errodesrelacionar)){
?>
<div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Não foi possivel desrelacionar esse tipo de ususário.
</div>
<?php
}
if(isset($sucessodesrelacionar)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> Tipo de usuário desrelacionado.
</div>
<?php 
}
if(isset($senhasdiferentes)){
?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> As senhas que você informou são diferentes.
</div>
<?php
}
if(isset($senhainvalida)){
?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> A senha que você informou é invalida.
</div>
<?php
}
if(isset($senhaalterada)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> Senha alterada.
</div>
<?php
}

if(isset($sucessoPersonalizado) && !empty($sucessoMensagem)){
?>
<div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Sucesso!</a> <?= $sucessoMensagem ?>
</div>
<?php
}

if(isset($erroPersonalizado) && !empty($erroMensagem)){
?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> <?= $erroMensagem ?>
</div>
<?php
}
?>

<?php
if(isset($erroCamposVazios)){
?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Existem campos obrigatórios não preenchidos.
</div>
<?php
}
?>
<?php
if(isset($erroImgInvalida)){
?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <a href="#" class="alert-link">Erro!</a> Imagem informada inválida, envie outra.
</div>
<?php
}
?>