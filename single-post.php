<?php
// Verifica se o arquivo é acessado diretamente
if (!defined('ABSPATH')) {
    exit; // Sai se acessado diretamente
}
global $post;
get_header(); // Inclui o cabeçalho
?>
<main class="bg-df x-align py-5 py-4 aer-bg-light">
  <div class="breadcrumbs container-md">
    <a aria-label="Voltar para o blog" href=<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">← Voltar para o blog</a>
  </div>
  <div id="single-post" class="container-lg index-inner">
    <?php
    $main_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
    if (have_posts()) :
        while (have_posts()) : the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <div class="header-img" style="background-image: url('<?= $main_img[0] ?>')"></div>
                    <?php //get_the_post_thumbnail( get_the_ID(), 'single-post-thumbnail'); ?>
                    
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                    </div>

                    <?php
                      foreach(get_the_tags($post) as $_tag){
                        if($_tag -> name == 'liverpool'){
                          ?>
                            <div class="container-parceiro mt-3">
                              <div class="banner-parceiro">
                                <div class="img">
                                  <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/parceiros/os-garotos-de-liverpool.webp" alt="Logo do blog Os Garotos de Liverpool">
                                </div>
                                <div class="text">
                                  Este é um conteúdo produzido em parceria com
                                  <span class="d-block"><a href="https://www.osgarotosdeliverpool.com.br/" target="_blank">Os Garotos de Liverpool</a></span>
                                </div>
                              </div>
                            </div>
                          <?php
                        };
                      };
                    ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php if (has_category()) : ?>
                        <span class="cat-links"><?php _e('Categorias: '); ?><?php the_category(', '); ?></span>
                    <?php endif; ?>
                    <?php if (has_tag()) : ?>
                        <span class="tag-links"><?php _e('Tags: '); ?><?php the_tags('', ', ', ''); ?></span>
                    <?php endif; ?>
                </footer>
            </article>

            <?php
            // Se os comentários estiverem abertos ou houver pelo menos um comentário, exibe a seção de comentários
            if (comments_open() || get_comments_number()) :
              ?>
                <div id="comments_container">
                  <h3 id="title-comments">Comentários</h3>
                  <?php
                    comments_template();
                    endif;
                  ?>
                </div>
              
          <?php
        endwhile;
    else :
        echo '<p>' . __('Desculpe, nenhum post encontrado.') . '</p>';
    endif;
    ?>
  </div>
  <script>
    const commentForm = document.querySelector('form#commentform');
    const respondTextareaLabel = commentForm.querySelector('.comment-form-comment');

    

    if(respondTextareaLabel && commentForm){
      commentForm.querySelectorAll('input[type="text"], textarea').forEach(_inp => _inp.classList.add('modern-text-input'));
      commentForm.insertBefore(respondTextareaLabel, commentForm.querySelector('p.comment-form-cookies-consent'));
      respondTextareaLabel.children[1].rows = 3;

    }
  </script>
</main>
<?php
// get_sidebar(); // Inclui a barra lateral
get_footer(); // Inclui o rodapé
?>
