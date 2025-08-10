<?php 
    $variacao_linhas_meta = get_post_meta($variacao['variation_id'], 'tem_linhas', true);
    $variacao_linhas_qtd = is_numeric($variacao_linhas_meta) ? (int)$variacao_linhas_meta : 1;
    $locais_embarque = json_decode(get_post_meta($post -> ID, 'exc_embarques', true));
?>
        
<section class="linhas-inner <?= $variacao_linhas_qtd > 1 ? '' : 'd-none'; ?>">
    <div class="linhas-inner-flex">
        <?php 
            for($i = 1; $i <= $variacao_linhas_qtd; $i++){
                ?>
                <div class="linha" data-linha="<?= $i; ?>">
                    <p>Linha <?= $i; ?></p>
                        <ul>
                        <?php
                            foreach($locais_embarque as $local_embarque){
                                $local_label = $local_embarque -> nome . ' (' . $local_embarque -> horario . ')';
                                ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" value="<?= $local_label; ?>" data-linha="<?= $i; ?>""><?= $local_label; ?>
                                        </label>
                                    </li>
                                <?php
                            }
                        ?>
                    </ul>
                </div>
        <?php
            }
        ?>
        
    </div>
</section>

