<?php
get_header();
the_post();
$secciones = get_field('secciones');
?>
    <main>
    <?php
        $sliders = get_field('slider_principal', 'options');
        echo get_slider($sliders);
        //horizontes
        foreach($secciones as $seccion):
            if($seccion['acf_fc_layout']=='quien_quienes'):
                echo get_quienes($seccion);
            endif;
            if($seccion['acf_fc_layout']=='calendarios'):
                echo get_calendario($seccion);
            endif;
            if($seccion['acf_fc_layout']=='formularios'):
                echo get_formulario($seccion);
            endif;
            if($seccion['acf_fc_layout']=='speakers'):
                echo get_speakers($seccion);
            endif;
            if($seccion['acf_fc_layout']=='welcu'):
                echo get_welcu($seccion);
            endif;
            if($seccion['acf_fc_layout']=='videos'):
                echo get_videos($seccion);
            endif;
            if($seccion['acf_fc_layout']=='galeria'):
                echo get_imagenes($seccion);
            endif;
        endforeach;
        //horizonte noticias + contacto
        get_template_part('partials/last-horizon');
    ?>
    </main>

<?php get_footer(); ?>