<?php
if (! defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo get_bloginfo('name', 'display'); ?></title>
</head>

<body <?php echo is_rtl() ? 'rightmargin="0" direction="rtl"' : 'leftmargin="0"'; ?>>
  <div class="email-container" style="background-color: #f7f7f7; padding: 20px;">
    <div class="email-box" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e0e0e0;">

      <div style="padding: 20px 0; text-align: center;">
        <div class="logo-container">
          <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo-padrao.png"
            alt="Aerotour Excursões"
            class="light-img"
            width="180"
            style="display: block; max-width: 180px; margin: 0 auto">

          <div class="dark-img-wrapper" style="display:none; overflow:hidden; width:0px; max-height:0px;">
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo-dark-mode.png"
              alt="Aerotour Excursões"
              class="dark-img"
              width="180"
              style="display: block; max-width: 180px; margin: 0 auto">
          </div>
        </div>
      </div>

      <div style="background-color: #400f0f; padding: 20px; text-align: center;">
        <h1 style="color: #ffffff; margin: 0; font-size: 20px; text-align: center; font-family:Raleway, Arial, sans-serif"><?php echo $email_heading; ?></h1>
      </div>

      <div style=" padding: 30px; color: #333333; font-family: Arial, sans-serif; line-height: 1.6;">