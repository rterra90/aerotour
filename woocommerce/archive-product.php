<?php
defined('ABSPATH') || exit();
get_header('shop');
?>

<section id="archive-product">
  <h1 class="text-center page-title mb-md-5 mb-4 mt-3">Todas as excursões</h1>
  
  <!-- Ponto de montagem da interface interativa -->
  <div id="app-archive-product-root" class="container-xl">
      <!-- Opcional: Inserir um Skeleton Loading em HTML puro aqui para fallback -->
  </div>
</section>
<?php 
// Removida a sidebar antiga, pois os filtros farão parte do app
get_footer('shop'); 
?>
