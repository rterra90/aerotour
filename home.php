<?php get_header(); 

//widget de notícias padrão
function aer_default_news_widget($article_class = '', $exc = NULL, $number = -1){
  foreach(wp_get_recent_posts(array('numberposts' => $number, 'post_status' => 'publish', 'exclude' => $exc,)) as $last){
    ?>
  <article class="post single-news <?= $article_class; ?>">
    <?php
    foreach(get_the_category($last['ID']) as $cat){
    ?>
    <a href="<?= bloginfo('url');?>/blog/categorias/<?= $cat->slug;?>"><span class="cat-badge"><?= $cat->name; ?></span></a>
    <?php
    }
    ?>
    <a href="<?php the_permalink($last['ID']); ?>" title="<?php the_title_attribute($last['ID']);?>">
      <div class="single-news-inner"> 
      <?= get_the_post_thumbnail($last['ID'], 'medium');?> 
        <div>
          <span class="archive-date d-block mt-1"><?= get_the_date('d/m/Y', $last['ID']);?></span> 
          <h2><?= $last['post_title'];?></h2>
        </div>
      </div>
    </a>
  </article>
  <?php
  }
}
?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/home.css">

<main class="bg-df x-align py-5 aer-bg-light" id="blog-home">
  <div class="container-fluid">
    <h1 class="rockstar-font mt-sm-0 mt-2"><span>Blog</span> Aerotour</h1>

    <section class="blog-main">
      <div class="news-area row">
        <div class="col-md-9 row blog-grid">

        <?php
        aer_default_news_widget('col-sm-6 col-md-4 col-lg-4')
        ?>
        </div>


        <div id="blog-aside" class="col-md-3">
        <?php get_search_form(true, 'posts_search_aria'); ?>

        </div>
      </div>
    </section>

  </div>

</main>








<?php get_footer(); ?>