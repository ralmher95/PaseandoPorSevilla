<?php
/**
 * Archive Paseo (CPT: paseo)
 * Archivo: archive-paseo.php
 */
if ( ! defined('ABSPATH') ) exit;

get_header();
?>

<main class="ps-wrap ps-archive">

  <!-- HERO LISTADO -->
  <header class="ps-archive-hero" aria-label="Listado de paseos">
    <div class="ps-archive-hero__inner">
      <h1 class="ps-archive-title">Paseos</h1>
      <p class="ps-archive-lead">Explora todos los paseos disponibles y reserva en segundos.</p>
    </div>
  </header>

  <!-- GRID TARJETAS -->
  <section class="ps-grid-archive" aria-label="Tarjetas de paseos">

    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php
          $permalink = get_permalink();
          $title = get_the_title();

          // Imagen destacada
          $img_url = has_post_thumbnail()
            ? get_the_post_thumbnail_url(get_the_ID(), 'large')
            : '';

          // Resumen: extracto > recorte de contenido
          $excerpt = has_excerpt()
            ? get_the_excerpt()
            : wp_trim_words( wp_strip_all_tags( get_the_content() ), 18 );
        ?>

        <article class="ps-card ps-card--archive">
          <a class="ps-card__media" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($title); ?>">
            <?php if ( $img_url ): ?>
              <img class="ps-card__img" src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy" />
            <?php else: ?>
              <div class="ps-card__placeholder" aria-hidden="true"></div>
            <?php endif; ?>

            <span class="ps-card__badge">Paseo</span>
          </a>

          <div class="ps-card__body">
            <h2 class="ps-card__title">
              <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h2>

            <?php if ( $excerpt ): ?>
              <p class="ps-card__text"><?php echo esc_html($excerpt); ?></p>
            <?php endif; ?>

            <div class="ps-card__actions">
              <a class="ps-btn ps-btn--primary" href="<?php echo esc_url($permalink); ?>">Ver detalle</a>
              <a class="ps-btn ps-btn--ghost" href="<?php echo esc_url($permalink); ?>#reserva">Reservar</a>
            </div>
          </div>
        </article>

      <?php endwhile; ?>

    <?php else: ?>

      <div class="ps-empty">
        <h2 class="ps-h2">Aún no hay paseos publicados</h2>
        <p class="ps-muted">Cuando se publique el primer paseo, aparecerá automáticamente aquí.</p>
      </div>

    <?php endif; ?>

  </section>

  <!-- PAGINACIÓN -->
  <nav class="ps-pagination" aria-label="Paginación">
    <?php
      the_posts_pagination([
        'mid_size'  => 1,
        'prev_text' => '← Anterior',
        'next_text' => 'Siguiente →',
      ]);
    ?>
  </nav>

</main>

<?php get_footer();