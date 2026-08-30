<?php get_header(); ?>

<main class="bg-df py-5 aer-bg-light" id="blog-home">
  <!-- Trocamos container-fluid por container-xl para limitar o crescimento excessivo em telas ultrawide -->
  <div class="container-xl"> 
    <header class="blog-header text-center mb-5">
      <h1 class="rockstar-font mt-sm-0 mt-2"><span>Blog</span> Aerotour</h1>
      <p class="blog-subtitle">Dicas, roteiros e novidades sobre nossas excursões</p>
    </header>

    <section class="blog-main row gx-5">
      <!-- Coluna Principal dos Posts -->
      <div class="col-lg-9 col-md-8 blog-feed">
        <div class="row">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 9, // Traz o destaque + 8 em grid
            'paged'          => $paged
        );
        $blog_query = new WP_Query($args);

        if ($blog_query->have_posts()) :
            $counter = 0;
            while ($blog_query->have_posts()) : $blog_query->the_post();
                $counter++;
                
                // Pega a primeira categoria para o badge
                $category = get_the_category();
                $cat_name = !empty($category) ? esc_html($category[0]->name) : '';
                $cat_slug = !empty($category) ? esc_attr($category[0]->slug) : '';
                $cat_link = !empty($category) ? get_category_link($category[0]->term_id) : '#';

                // O primeiro post da primeira página vira o "Destaque"
                if ($counter === 1 && $paged === 1) : ?>
                    <div class="col-12 mb-5">
                        <article class="post hero-post card-ui">
                            <a href="<?php the_permalink(); ?>" class="img-wrapper">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                            </a>
                            <div class="post-content">
                                <?php if($cat_name): ?>
                                    <a href="<?= $cat_link ?>" class="cat-badge"><?= $cat_name ?></a>
                                <?php endif; ?>
                                
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <span class="archive-date"><?= get_the_date('d/m/Y'); ?></span>
                                <p class="excerpt"><?= wp_trim_words(get_the_excerpt(), 25, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more">Ler artigo completo →</a>
                            </div>
                        </article>
                    </div>
                <?php else : ?>
                    <!-- Demais posts no grid -->
                    <div class="col-lg-6 col-md-12 mb-4">
                        <article class="post grid-post card-ui">
                            <a href="<?php the_permalink(); ?>" class="img-wrapper">
                                <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                            </a>
                            <div class="post-content">
                                <span class="archive-date"><?= get_the_date('d/m/Y'); ?></span>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </article>
                    </div>
                <?php endif;
            endwhile;
            
            // Paginação nativa
            echo '<div class="col-12 pagination-wrapper mt-4">';
            echo paginate_links(array(
                'total' => $blog_query->max_num_pages,
                'prev_text' => '← Mais recentes',
                'next_text' => 'Mais antigos →'
            ));
            echo '</div>';

            wp_reset_postdata();
        else :
            echo '<p>Nenhum artigo encontrado no momento.</p>';
        endif;
        ?>
        </div>
      </div>

      <!-- Sidebar Redesenhada -->
      <aside id="blog-aside" class="col-lg-3 col-md-4 mt-5 mt-md-0">
        <div class="sidebar-widget search-widget">
            <h4 class="widget-title">Buscar no Blog</h4>
            <?php get_search_form(); ?>
        </div>
        
        <!-- Espaço para um CTA de Vendas / Captura de Leads (Inbound) -->
        <div class="sidebar-widget cta-widget mt-4">
            <h4>Viaje com a Aerotour</h4>
            <p>Garanta seu lugar nas melhores excursões saindo de Campinas e região.</p>
            <a href="/excursoes" class="btn-cta">Ver Excursões</a>
        </div>
      </aside>
    </section>
  </div>
</main>

<?php get_footer(); ?>