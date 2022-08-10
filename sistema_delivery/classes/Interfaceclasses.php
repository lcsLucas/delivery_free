<?php
/*
 * classe de interface para manter padrão de nomeclatura nas classes
 */
interface Interfaceclasses {
    public function inserir();
    public function alterar();
    public function excluir();
    public function listar();
    public function quantidadeRegistros($filtro,$chaves="");
    public function listarPaginacao($filtro,$inicio,$fim,$chaves="");
    public function carregar();   
}
