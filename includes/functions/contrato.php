<?php
function contrato_rewrite_rules() {
    add_rewrite_rule(
        '^contrato/([^/]+)/?',  // captura qualquer coisa após /contrato/
        'index.php?pagename=contrato&contrato_param=$matches[1]',
        'top'
    );
}
add_action('init', 'contrato_rewrite_rules');

function contrato_query_vars($vars) {
    $vars[] = 'contrato_param';
    return $vars;

}
add_filter('query_vars', 'contrato_query_vars');
?>