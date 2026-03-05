<?php
/**
 * Plantilla corregida para evitar duplicidad de descripción
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();

        // Extraemos los metadatos
        $descripcion_personalizada = get_post_meta(get_the_ID(), 'descripcion', true);
        $precio          = get_post_meta(get_the_ID(), 'precio', true);
        $lugar           = get_post_meta(get_the_ID(), 'lugar_de_encuentro', true);
        $incluye         = get_post_meta(get_the_ID(), 'incluye', true);
        $no_incluye      = get_post_meta(get_the_ID(), 'no_incluye', true);
        $duracion        = get_post_meta(get_the_ID(), 'duracion', true);

        $precio_mostrar = $precio ? number_format((float)$precio, 2, ',', '.') : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cata-single'); ?>>

    <header class="cata-header">
        <div class="container">
            <h1 class="cata-title"><?php the_title(); ?></h1>
            <?php if ($precio) : ?>
                <div class="cata-price">
                    <span class="price-amount"><?php echo esc_html($precio_mostrar); ?> €</span>
                    <span class="price-label">por persona</span>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <section class="cata-content container">
        <?php if (has_post_thumbnail()) : ?>
            <div class="cata-featured-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="cata-description">
            <h2>Descripción</h2>
            <div class="content-text">
                <?php 
                if ( !empty($descripcion_personalizada) ) {
                    // Si el campo "descripcion" tiene algo, mostramos eso
                    echo wp_kses_post(wpautop($descripcion_personalizada)); 
                } else {
                    // Si el campo está vacío, mostramos el editor de WordPress
                    the_content(); 
                }
                ?>
            </div>
        </div>

        <div class="cata-details-grid">
            <?php if ($duracion) : ?>
                <div class="detail-item">
                    <h3>Duración</h3>
                    <p><?php echo esc_html($duracion); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($lugar) : ?>
                <div class="detail-item">
                    <h3>Lugar de encuentro</h3>
                    <p><?php echo esc_html($lugar); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($incluye) : ?>
            <div class="cata-includes">
                <h2>Incluye</h2>
                <?php echo format_cata_list($incluye); ?>
            </div>
        <?php endif; ?>

        <?php if ($no_incluye) : ?>
            <div class="cata-excludes">
                <h2>No incluye</h2>
                <?php echo format_cata_list($no_incluye); ?>
            </div>
        <?php endif; ?>

        <div class="cata-cta">
            <a href="#reserva" class="btn-reservar">Reservar ahora</a>
        </div>
    </section>
</article>

<?php
    endwhile;
endif;

get_footer();