<?php get_header(); ?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/search.css">
<main id="search-main" class="bg-df x-align py-5 aer-bg-light">
  <div class="container-fluid">
    <section class="search-results">
        <header class="page-header">
        <?php get_search_form(true, 'posts_search_aria'); ?>

            <h1 class="page-title text-center">
                <?php printf( esc_html__( 'Resultados da pesquisa para: %s', 'textdomain' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="blog-grid row">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="post col-sm-6 col-md-4 col-lg-4">
                    <div class="single-news-inner">
                        <header class="entry-header">
                        <?= get_the_post_thumbnail(get_the_ID(), 'medium');?> 
                            <span class="archive-date d-block mt-1"><?= get_the_date('d/m/Y', get_the_ID());?></span> 
                            <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h2>
                        </header>
                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                        
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h2 class="page-title"><?php esc_html_e( 'Nada encontrado', 'textdomain' ); ?></h2>
                </header>
                <div class="page-content">
                    <p><?php esc_html_e( 'Desculpe, mas nada corresponde aos seus termos de pesquisa. Por favor, tente novamente com algumas palavras-chave diferentes.', 'textdomain' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
        <?php endif; ?>
    </section>
  </div>
</main>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
