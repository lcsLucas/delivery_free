<?php

if (filter_input(INPUT_GET, "rel", FILTER_SANITIZE_SPECIAL_CHARS) === "entrada-insumos") {

    $nome = filter_input(INPUT_GET, "nome", FILTER_SANITIZE_SPECIAL_CHARS);



}