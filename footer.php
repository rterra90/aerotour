<!-- Insere o modal -->
<?php get_template_part('includes/modals/modal', null); ?>

<?php wp_footer(); ?>
</body>


<footer class="text-center" id="aer-footer">
  <div class="container-md">
    <nav class="mt-4 footer-nav">

        <?php wp_nav_menu(['menu' => 'Footer', 'container' => 'ul']); ?>
    
    </nav>

      <hr class="my-5" />

      <section class="my-4">
        <div class="d-flex footer-general-wrapper">
          <div class="footer-general-left">
            <div class="footer-general d-flex">
              <div class="footer-general-pagamento">
                  <span class="mp"><img alt="Ícone do PIX"src="<?= get_stylesheet_directory_uri() ?>/assets/images/icones/mp-footer.png" /></span>
                  <span><img alt="Ícone do Mercado Pago" src="<?= get_stylesheet_directory_uri() ?>/assets/images/icones/pix-footer.webp" /></span>
              </div>
              <div class="footer-general-seguranca">
                  <span><img alt="Ícone do Selo de Segurança SSL"src="<?= get_stylesheet_directory_uri() ?>/assets/images/icones/selo-ssl.png" /></span>
              </div>
              
            </div>
            <div class="footer-cnpj desktop text-start py-4">
              <p>Aerotour Excursões</p>
              <p>10.987.942/0001-69</p>
            </div>
          </div>
          <div class="footer-general-right">
            <div class="footer-redes d-flex gap-3">
              <a href="https://www.facebook.com/aerotourcampinas/" target="_blank" aria-label="Ícone do Facebook"><?= aer_icons(
                'facebook',
                26,
                26
              ) ?></a>   
              <a href="https://www.instagram.com/aerotour_excursoes/" target="_blank" aria-label="Ícone do Instagram"><?= aer_icons(
                'instagram',
                26,
                26
              ) ?></a> 
            </div>
          </div>
        </div>
          
      </section>

    </div>
    <div class="footer-logo">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/aerotour-logo.svg" alt="Logotipo da Aerotour Excursões">
      </div>


</footer>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/main.js"></script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/helper/dropdown.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/helper/btn-reactive-loading.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<!-- Tooltip Bootstrap Init -->
<script>
	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
</script>

</html>