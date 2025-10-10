<?php
/* Template Name: Contrato particular */
$param = get_query_var('contrato_param');
if($param !== null && is_numeric($param)){
  if (!isset($_SESSION['acesso_contrato']) || $_SESSION['acesso_contrato'] != $param){
    wp_safe_redirect(home_url('/contrato'));
  }
}

get_header();

?>
<!-- Estilos da página de contrato particular -->
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/contrato-particular.css?ver=<?= time(); ?>">

<main id="contratoParticular">
 <div class="container-contrato" id="contratoInner">
  <p><?= $param; ?></p>
  <?php
    if($param === 'novo'){
      get_template_part('includes/contrato-particular/contrato-novo-form');
    }else if(is_numeric($param)){
      ?>
      <p>exibe contrato</p>
      <?php
    }else{
      get_template_part('includes/contrato-particular/contrato-home');
      // if (file_exists(get_template_directory() . '/includes/contrato-particular/contrato-home.php')) {
      //     get_template_part('includes/contrato-particular/contrato-home');
      // } else {
      //     echo '<p>Template file not found.</p>';
      // }
    }

  ?>

</div> 
</main>




<?php get_footer(); ?>
