<?php
// Verifica se o arquivo é acessado diretamente
if (!defined('ABSPATH')) {
  exit(); // Sai se acessado diretamente
}

get_header(); // Inclui o cabeçalho

if (have_posts()): ?>
    <header class="archive-header">
        <h1 class="archive-title">
            <?php if (is_category()) {
              single_cat_title();
            } elseif (is_tag()) {
              single_tag_title();
            } elseif (is_author()) {
              the_post();
              echo 'Author: ' . get_the_author();
              rewind_posts();
            } elseif (is_day()) {
              echo 'Day: ' . get_the_date();
            } elseif (is_month()) {
              echo 'Month: ' . get_the_date('F Y');
            } elseif (is_year()) {
              echo 'Year: ' . get_the_date('Y');
            } else {
              echo 'Archives';
            } ?>
        </h1>
        <?php if (is_category() || is_tag()): ?>
            <div class="archive-description"><?php echo term_description(); ?></div>
        <?php endif; ?>
    </header>

    <?php // Loop através dos posts
    while (have_posts()):
      the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-meta">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"> por <?php the_author(); ?></span>
                </div>
            </header>

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="read-more"><?php _e(
  'Read More'
); ?></a>
            </footer>
        </article>
    <?php
    endwhile; ?>

    <div class="pagination">
        <?php // Paginação
        the_posts_pagination([
          'mid_size' => 2,
          'prev_text' => __('Previous'),
          'next_text' => __('Next')
        ]); ?>
    </div>

<?php else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif;

get_sidebar(); // Inclui a barra lateral
get_footer(); // Inclui o rodapé
?>
