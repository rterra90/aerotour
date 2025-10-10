<?php
require_once('../../../../../wp-load.php');
$contratos_senhas = [
    '123' => 'abc123',
    '456' => 'senha456',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numeroContrato'], $_POST['senhaContrato'])) {
    $num = trim($_POST['numeroContrato']);
    $senha = trim($_POST['senhaContrato']);

    // IMPLEMENTAR AQUI A LÓGICA DE AUTENTICAÇÃO
    if (isset($contratos_senhas[$num]) && $senha === $contratos_senhas[$num]) {
        $_SESSION['acesso_contrato'] = $num;
        wp_safe_redirect(home_url("/contrato/$num"));
        exit;
    } else {
        wp_safe_redirect(add_query_arg('erro', 'auth', home_url('/contrato')));
        exit;
    }
}


wp_safe_redirect(home_url('/contrato'));
exit;
?>