<?php

//verifica se aconteceu um POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php?rota=login');
    exit;
}

//vai buscar os dados do POST
$usuario = $_POST['text_usuario'] ?? null;
$senha = $_POST['text_senha'] ?? null;

// verifica se os dados estão preenchidos
if(empty($usuario) || empty($senha)){
    header('Location: index.php?rota=login');
    exit;
}

// a classe de base de dados ja esta carregada no index.php
$db = new database();
$params = [
    ':usuario' => $usuario
];

$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$result =$db->query($sql, $params);

//verifica se aconteceu um erro
if($result['status'] === 'error'){
    header('Location: index.php?rota=404');
    exit;
}

//verifica se o usuario existe
if(count($result['data']) === 0){

    //erro na sessão
    $_SESSION['error'] = 'usuário ou senha inválidos';

    header('Location: index.php?rota=login');
    exit;
}

//verifica se o usuario existe
if(!password_verify($senha, $result['data'][0]->senha)){

    //erro na sessão
    $_SESSION['error'] = 'usuários ou senha inválidos';

    header('Location: index.php?rota=login');
    exit;
}

//define a sessão do usuário
$_SESSION['usuario'] = $result['data'][0];

//redirecionar para a página inicial
header('Location: index.php?rota=home');
