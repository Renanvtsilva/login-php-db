<?php

//destroi a sessão
session_destroy();

//redireciona para a pag inicial
header('Location: index.php?rota=home');