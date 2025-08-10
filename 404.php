<?php
// Verifica se o arquivo é acessado diretamente
if (!defined('ABSPATH')) {
    exit; // Sai se acessado diretamente
}

get_header(); // Inclui o cabeçalho
?>

<main class="bg-df x-align py-5 py-4 aer-bg-light">
  <div class="container">
    <h2 class="d-block text-center">Página não encontrada...</h2>
    <p class="d-block text-center">Desculpe, mas a página que você está procurando não existe ou foi removida.</p>
    <u class="d-block text-center my-3"><a href="<?= site_url('/excursoes')?>">Ver todas as excursões</a></u>
    <u class="d-block text-center"><a href="<?= site_url()?>">Página inicial</a></u>
  </div>

</main>
<?php
get_footer()
?>