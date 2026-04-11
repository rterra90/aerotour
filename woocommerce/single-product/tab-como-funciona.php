<!-- TAB CONTENT COMO FUNCIONA -->
<?php
$todos_sets = get_option('como_funciona_sets', []);
$set_padrao_id = get_option('como_funciona_set_padrao', '');
$set_id_final  = (!empty($args['set_escolhido']) && isset($todos_sets[$args['set_escolhido']]))
  ? $args['set_escolhido']
  : $set_padrao_id;
$frases = (isset($todos_sets[$set_id_final]['frases'])) ? $todos_sets[$set_id_final]['frases'] : [];

?>

<div id="tab1" class="tab-content tab-como-funciona active">
  <ul class="list-group list-group-flush">
    <?php if (!empty($frases)) : ?>
      <?php foreach ($frases as $f) :
        // 2. Normalização: garante que funcione com dados novos (array) ou antigos (string)
        if (!is_array($f)) {
          $f = [
            'texto' => $f,
            'is_destaque' => '0',
            'texto_secundario' => '',
            'icone' => 'bi-arrow-right' // ícone padrão antigo
          ];
        }

        $is_destaque = ($f['is_destaque'] === '1');

        // Define o ícone: se for SVG ou se tiver classe específica, caso contrário usa a seta padrão
        $icone_url = !empty($f['icone']) ? $f['icone'] : '';
        $classe_item  = $is_destaque ? 'item-destaque' : '';
      ?>
        <li class="list-group-item bg-transparent <?= $classe_item; ?>">
          <div class="d-flex align-items-center">

            <!-- Insere ícone, se houver -->
            <?php if (!empty($icone_url)) : ?>
              <div class="como-funciona-icon me-3" style="width: 32px; flex-shrink: 0;">
                <?php if (strpos($icone_url, '.svg') !== false) :
                  // Se quiser que o SVG aceite cores via CSS, pode-se usar file_get_contents, 
                  // mas por segurança e performance, usamos img aqui:
                ?>
                  <img src="<?= esc_url($icone_url); ?>" alt="Ícone" style="width: 100%; height: auto;">
                <?php else : ?>
                  <img src="<?= esc_url($icone_url); ?>" alt="Ícone" style="width: 100%; height: auto; border-radius: 4px;">
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <div class="como-funciona-text">
              <?php if ($is_destaque) : ?>
                <h4 class="texto-principal d-block mb-1"><?= esc_html($f['texto']); ?></h4>
              <?php else : ?>
                <i class="bi bi-arrow-right me-2"></i> <?= esc_html($f['texto']); ?>
              <?php endif; ?>


              <?php if ($is_destaque && !empty($f['texto_secundario'])) : ?>
                <p class="texto-secundario text-muted"><?= esc_html($f['texto_secundario']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>

    <?php else : ?>
      <li id="sem-padrao-placeholder" class="list-group-item bg-transparent">
        Nenhuma orientação cadastrada...
      </li>
    <?php endif; ?>
  </ul>
</div>