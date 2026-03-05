<?php
/**
 * Plantilla Premium para Paseos - Paseando Sevilla
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();

        // Extraemos los datos de los Campos Personalizados
        $id         = get_the_ID();
        $descripcion = get_post_meta($id, 'descripcion', true);
        $precio      = get_post_meta($id, 'precio', true);
        $duracion    = get_post_meta($id, 'duracion', true);
        $idioma      = get_post_meta($id, 'idioma', true);
        $encuentro   = get_post_meta($id, 'encuentro', true);
        $incluye     = get_post_meta($id, 'incluye', true);
        $no_incluye  = get_post_meta($id, 'no_incluye', true);
        $img_url     = get_the_post_thumbnail_url($id, 'large');
?>

<div class="ps-single ps-wrap">
    
    <header class="ps-hero">
        <div class="ps-hero__media" style="<?php echo $img_url ? 'background-image:url(' . esc_url($img_url) . ');' : ''; ?>">
            <?php if (!$img_url) : ?><div class="ps-hero__placeholder"></div><?php endif; ?>
            <span class="ps-hero__badge">Paseo Guiado Especial</span>
        </div>

        <div class="ps-hero__content">
            <h1 class="ps-title"><?php the_title(); ?></h1>
            <p class="ps-lead"><?php echo get_the_excerpt(); ?></p>
            
            <div class="ps-hero__actions">
                <a href="#reserva" class="ps-btn ps-btn--primary">Reservar ahora</a>
                <a href="/paseos" class="ps-btn ps-btn--ghost">Ver otros paseos</a>
            </div>
            
            <ul class="ps-pills">
                <?php if ($duracion) : ?><li class="ps-pill">⏱ <?php echo esc_html($duracion); ?></li><?php endif; ?>
                <?php if ($precio) : ?><li class="ps-pill">💶 <?php echo esc_html($precio); ?>€</li><?php endif; ?>
                <?php if ($idioma) : ?><li class="ps-pill">🗣 <?php echo esc_html($idioma); ?></li><?php endif; ?>
            </ul>
        </div>
    </header>

    <div class="ps-grid">
        <main class="ps-card ps-card--main">
            <div class="ps-card__body">
                <h2 class="ps-h2">Descripción</h2>
                <div class="ps-prose">
                    <?php 
                    if ($descripcion) {
                        echo wpautop(wp_kses_post($descripcion));
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
        </main>

        <aside class="ps-card ps-card--aside">
            <div class="ps-card__body">
                <h2 class="ps-h2">Ficha Técnica</h2>
                <dl class="ps-meta">
                    <div class="ps-meta__row">
                        <dt>Punto de encuentro</dt>
                        <dd><?php echo $encuentro ? esc_html($encuentro) : 'A concretar'; ?></dd>
                    </div>
                </dl>

                <div class="ps-divider"></div>

                <h3 class="ps-h3">Lo que incluye</h3>
                <div class="ps-list">
                    <?php echo format_cata_list($incluye); ?>
                </div>

                <?php if ($no_incluye) : ?>
                    <div class="ps-divider"></div>
                    <h3 class="ps-h3">No incluye</h3>
                    <div class="ps-list ps-list--danger">
                        <?php echo format_cata_list($no_incluye); ?>
                    </div>
                <?php endif; ?>

                <div class="ps-cta" id="reserva">
                    <p class="ps-note">¡Reserva tu plaza!</p>
                    <a href="/contacto" class="ps-btn ps-btn--primary ps-btn--block">Solicitar Disponibilidad</a>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php
    endwhile;
endif;

get_footer();