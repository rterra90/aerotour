<?php
// Verifica se o arquivo é acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}
global $post;
get_header();

// Calcula tempo de leitura em minutos (base: 200 palavras/min)
$word_count = str_word_count( strip_tags( get_post_field( 'post_content', get_the_ID() ) ) );
$reading_time = ceil($word_count / 200);

// Recupera o Snippet do banco de dados
$snippet_text = get_post_meta(get_the_ID(), '_aer_post_snippet', true);
?>

<!-- Barra de Progresso de Leitura -->
<div id="reading-progress"></div>

<main class="bg-df x-align py-5 py-4 aer-bg-light">
  <div class="breadcrumbs container-md">
    <a aria-label="Voltar para o blog" href="<?php echo esc_url(get_permalink( get_option( 'page_for_posts' ) )); ?>">← Voltar ao blog</a>
  </div>
  
  <div id="single-post" class="container-lg index-inner">
    <?php
    $main_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
    
    if (have_posts()) :
        while (have_posts()) : the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <div class="header-img" style="background-image: url('<?= !empty($main_img[0]) ? esc_url($main_img[0]) : '' ?>')"></div>
                    
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on">📅 <?php echo get_the_date(); ?></span>
                        <span class="reading-time-badge">⏱️ <?= $reading_time ?> min de leitura</span>
                    </div>
                </header>

                <!-- Box de Snippets Dinâmico -->
                <?php if (!empty($snippet_text)): ?>
                <div class="post-snippet-box">
                    <h4 class="snippet-title">Neste artigo você verá:</h4>
                    <p class="snippet-content"><?= nl2br(esc_html($snippet_text)); ?></p>
                </div>
                <?php endif; ?>

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
            if (comments_open() || get_comments_number()) :
              ?>
                <div id="comments_container">
                  <h3 id="title-comments">Comentários</h3>
                  <?php comments_template(); ?>
                </div>
          <?php
            endif;
        endwhile;
    else :
        echo '<p>' . __('Desculpe, nenhum post encontrado.') . '</p>';
    endif;
    ?>
  </div>
  
  <script>
    // Configurações do formulário de comentários
    const commentForm = document.querySelector('form#commentform');
    const respondTextareaLabel = commentForm?.querySelector('.comment-form-comment');

    if(respondTextareaLabel && commentForm){
      commentForm.querySelectorAll('input[type="text"], textarea').forEach(_inp => _inp.classList.add('modern-text-input'));
      commentForm.insertBefore(respondTextareaLabel, commentForm.querySelector('p.comment-form-cookies-consent'));
      respondTextareaLabel.children[1].rows = 3;
    }

    // Lógica da Barra de Progresso
    window.addEventListener('scroll', () => {
        const docElem = document.documentElement;
        const docBody = document.body;
        const scrollHeight = (docElem.scrollHeight || docBody.scrollHeight) - window.innerHeight;
        const scrollTop = docElem.scrollTop || docBody.scrollTop;
        const progress = (scrollTop / scrollHeight) * 100;
        
        const progressBar = document.getElementById('reading-progress');
        if(progressBar) {
            progressBar.style.width = progress + '%';
        }
    });
  </script>
</main>
<?php
get_footer();
?>