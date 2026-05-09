<?php

/**
 * Renderiza o Switch
 */
function render_settings_switch($args)
{
  $option_name = $args['label_for'];
  $value = get_option($option_name);
?>
  <label class="admin-switch">
    <input
      type="checkbox"
      id="<?= $option_name; ?>"
      name="<?php echo esc_attr($option_name); ?>"
      value="1"
      <?php checked(1, $value); ?>>
    <span class="admin-slider"></span>
  </label>
<?php
}


/**
 * Renderiza um campo de texto genérico (text, url, email, etc.)
 * @param array $args Argumentos passados pelo add_settings_field
 */
function render_settings_field_text($args)
{
  $option_name = $args['label_for'];
  $value = get_option($option_name, '');

  // Atributos opcionais com valores padrão
  $type        = isset($args['type']) ? $args['type'] : 'text';
  $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
  $class       = isset($args['class']) ? $args['class'] : 'regular-text';

  echo sprintf(
    '<input type="%s" name="%s" id="%s" value="%s" class="%s" placeholder="%s">',
    esc_attr($type),
    esc_attr($option_name),
    esc_attr($option_name),
    esc_attr($value),
    esc_attr($class),
    esc_attr($placeholder)
  );

  // Exibe uma descrição se ela for passada nos argumentos
  if (isset($args['description'])) {
    echo '<p class="description">' . esc_html($args['description']) . '</p>';
  }
}
