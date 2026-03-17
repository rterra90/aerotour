<?php

/**
 * Email Footer
 */
if (! defined('ABSPATH')) exit;
?>
</div>
<div style="background-color: #400f0f; padding: 25px; text-align: center; color: #ffffff;">
  <p style="margin: 0; font-size: 15px; font-weight: bold; letter-spacing: 0.5px; font-family:Raleway, Arial, sans-serif"><?= get_bloginfo('name') ?></p>
  <?php if (!empty($additional_content)) : ?>
    <div style="margin-top: 15px; font-size: 11px; color: #bbb;">
      <p style="margin: 5px 0 15px; font-size: 13px; opacity: 0.9;">
        <?php echo $additional_content; ?>
      </p>
    </div>
  <?php endif; ?>

  <div style="margin-top: 10px;">
    <a href="<?php echo esc_url(home_url()); ?>" style="color: #ffffff; text-decoration: none; margin: 0 10px; font-size: 12px; border: 1px solid rgba(255,255,255,0.3); padding: 5px 12px; border-radius: 4px;">Nosso Site</a>
    <a href="https://www.instagram.com/aerotourexcursoes/" style="color: #ffffff; text-decoration: none; margin: 0 10px; font-size: 12px; border: 1px solid rgba(255,255,255,0.3); padding: 5px 12px; border-radius: 4px;">Instagram</a>
  </div>
</div>

</div>
<div style="padding: 20px; text-align: center;">
  <p style="color: #999999; font-size: 11px; line-height: 1.6; margin: 0;">
    Este e-mail foi enviado automaticamente pelo sistema da Aerotour Excursões.<br>
    <?php echo date('Y'); ?> &copy; Todos os direitos reservados.
  </p>


</div>

</div>
</body>

</html>