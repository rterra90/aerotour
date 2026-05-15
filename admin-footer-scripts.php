<?php
add_action('admin_footer', 'admin_footer_scripts');
function admin_footer_scripts()
{
  global $pagenow;
  if ($pagenow == 'post.php') {
    global $post;

    // Chama updateReactValue no carregamento
    if ($post->post_type === 'product') {
      $obj_passageiros = array();
      if ($_product = wc_get_product($post->ID) !== false) {
        foreach (wc_get_product($post->ID)->get_available_variations() as $var) {
          $_key = 'id' . $var['variation_id'] . '__' . str_replace('/', '_', $var['attributes']['attribute_dia']);
          $obj_passageiros[$_key] = json_decode(get_post_meta($var['variation_id'], 'passageiros', true));
        }
        $obj_passageiros_str = json_encode($obj_passageiros);
      }

?><script>
        updateReactiveValues('obj_passageiros', '<?= $obj_passageiros_str; ?>')
      </script><?php
              }
            }
          }

          function admin_custom_js()
          {
            wp_enqueue_script('react-reservas', get_template_directory_uri() . '/js/react_apps/app_reservas_admin.js?ver=' . time());

            wp_enqueue_script('react-checkin-modal', get_template_directory_uri() . '/js/react_apps/app_checkin.js?ver=' . time());
          }
          add_action('admin_footer', 'admin_custom_js');
                ?>