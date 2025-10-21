<!-- ESTILOS DO MODAL  -->
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/includes/modals/general-modal.css?ver=<?= time(); ?>">

<!-- ESTRUTURA DO MODAL -->
<?php
$modalContent = isset($args['content']) ? $args['content'] : null;
?>
<div id="generalModal">
  <div id="generalModalContent" class="modal-container">
    <button id="closeModalBtn" class="close-button" aria-label="Fechar modal">&times;</button>
    <div class="modal-content-body">

    </div>
  </div>
</div>

<script src="<?= get_template_directory_uri(); ?>/js/classes/modal.js"></script>

<script>
  // Inicializa a classe Modal
  // const modalElement = new Modal('generalModal', '.modal-content-body');
  // modalElement.open('<?= $modalContent; ?>', {rootUrl: '<?= get_stylesheet_directory_uri(); ?>'});
 
  
</script>

</body>
</html>