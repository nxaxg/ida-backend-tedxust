<?php
/*Template name: Sponsors*/
get_header('intern');
the_post();
?>

    <main>
        <section class="horizon horizon--sponsors">
            <div class="container">
                <article class="common-box common-box--sponsors">
                    <div class="common-box__link">
                        <a href="<?php echo home_url(); ?>" class="simple-link" title="title">Volver al inicio</a>
                    </div>
                    <h2 class="common-box__title common-box__title--main"><?php the_title(); ?></h2>
                    <div class="common-box__excerpt">
                        <?php the_content(); ?>
                    </div>
                    <div class="gridle-row">
                        <?php
                            $sponsors = get_field('sponsors');
                            foreach($sponsors as $sponsor){
                                $img =  wp_get_attachment_image( $sponsor['sponsor_logo'], 'medium', 'Imagen slide' );
                                $printer .= '<div class="gridle-gr-4 gridle-gr-12@tablet">';
                                $printer .=     '<figure class="common-box__figure common-box__logos">';
                                if($sponsor['sponsor_url']){
                                    $printer .= '<a href="'. ensure_url($sponsor['sponsor_url']) .'" class="simple-link" target="_blank" title="Ir a sitio  de sponsor">';
                                    $printer .=   $img;
                                    $printer .= '</a>';
                                }else{
                                    $printer .=   $img;
                                }
                                $printer .=     '</figure>';
                                $printer .= '</div>';
                            }
                            echo $printer;
                        ?>
                    </div>
                </article>
            </div>
        </section>
    </main>

<?php get_footer(); ?>
