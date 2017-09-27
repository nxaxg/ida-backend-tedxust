<?php
    global $post, $wp_query;

    //**BASICS & GENERALS**/
    add_image_size( 'main', 1024, 576, true );
    add_image_size( 'medium', 640, 360, true );
    add_image_size( 'small', 360, 202, true );
    add_image_size( 'square', 360, 360, true );
    add_image_size( 'avatar', 100, 100, true );

    //registro thumbnails
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
    }

    add_filter( 'upload_mimes', 'custom_upload_mimes' );
    function custom_upload_mimes( $existing_mimes = array() ) {
        // Add the file extension to the array
        $existing_mimes['svg'] = 'image/svg+xml';
        return $existing_mimes;
    }

    function upload_custom_file( $file_data, $mimes = null ){
        if ( ! function_exists( 'wp_handle_upload' ) ) { require_once( ABSPATH . 'wp-admin/includes/file.php' ); }

        $fotoUpload = wp_handle_upload( $file_data, array( 'mimes' => $mimes, 'test_form' => false ) );
        $filename = $fotoUpload['file'];
        $wp_filetype = wp_check_filetype(basename($filename), null );
        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $filename ),
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $filename );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        return $attach_id;
    }

    function incrustrar_css() {
        wp_register_style('main_style', get_bloginfo('template_directory').'/css/main.css');
        wp_enqueue_style('main_style');
        wp_register_style('main_style_map', get_bloginfo('template_directory').'/css/main.css.map');
        wp_enqueue_style('main_style_map');
        wp_register_style('font_style', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Roboto+Condensed:300,400,700|Roboto:100,300,400,500,700,900');
        wp_enqueue_style('font_style');
    }
    add_action('wp_print_styles', 'incrustrar_css');

    function incrustar_scripts(){
        wp_enqueue_script('jquery', get_bloginfo('template_directory'). '/scripts/libs/jquery-3.1.0.min.js');
        wp_enqueue_script('main', get_bloginfo('template_directory'). '/scripts/min/main.min.js');
        wp_enqueue_script('main_map', get_bloginfo('template_directory'). '/scripts/min/main.min.js.map');
    }
    add_action( 'wp_enqueue_scripts', 'incrustar_scripts');

    function printMe( $thing ){
        echo '<pre>';
        print_r( $thing );
        echo '</pre>';
    }

    function ensure_url( $proto_url, $protocol = 'http' ){
        // se revisa si es un link interno primero
        if( substr($proto_url, 0, 1) === '/' ){
            return $proto_url;
        }if (filter_var($proto_url, FILTER_VALIDATE_URL)) {
            return $proto_url;
        }else if( substr($proto_url, 0, 7) !== 'http://' || substr($proto_url, 0, 7) !== 'https:/' ){
            $url = $protocol . '://' . $proto_url;
        }
        // doble chequeo de validacion de URL
        if ( ! filter_var($url, FILTER_VALIDATE_URL) ) {
            return '';
        }
        return $url;
    }

    function load_template_part($template_name, $part_name=null) {
        ob_start();
        get_template_part($template_name, $part_name);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }

    add_action('after_setup_theme', 'menu_setup');
    function menu_setup() {
        register_nav_menus(array(
            "primary" => "Este es el menu principal",
            "footer" => "Este es el menu del footer",
            "rrss" => "Redes sociales del tema"
        ));
    }

    function get_long_date($date){
        $dia = date_i18n( 'd', strtotime($date) );
        $mes = date_i18n('m', strtotime($date));
        $ano = date_i18n('Y', strtotime($date));
        $fecha = $dia . '/' . $mes . '/' . $ano;
        return $fecha;
    }

    function get_embed_video($videourl) {
        $string     = $videourl;
        $search     = '/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi';
        $replace    = "youtube.com/embed/$1";
        $url = preg_replace($search,$replace,$string);
        return $url;
    }

    //**THE CONTENT**/

    //slider en header
    function get_slider($array){
        $printer = $out = "";
        $count = 0;
        if($array){
            foreach($array as $slide){
                $count++;
                $img =  wp_get_attachment_image( $slide['imagen_slider'], 'full', 'Imagen slide' );
                $tipo_red = $slide['tipo_redireccion'];

                $printer .= '<div class="slider__slide" data-role="slider-slide">';
                $printer .=     '<article class="common-box common-box--slide">';
                $printer .=         '<figure class="common-box__figure">';
                $printer .=             $img;
                $printer .=         '</figure>';
                $printer .=         '<div class="common-box__body">';
                $printer .=             '<h1 class="common-box__title upper">'.$slide['titulo_slider'].'</h1>';
                $printer .=             '<div class="common-box__excerpt">';
                $printer .=                 $slide['bajada_slider'];
                $printer .=             '</div>';
                $printer .=             '<div class="common-box__button">';
                if($tipo_red == 'interna'):
                $printer .=                 '<a href="#'.$slide['enlace_boton_slider'].'" class="button button--wide button--main">'.$slide['texto_boton_slider'].'</a>';
                elseif($tipo_red == 'externa'):
                $printer .=                 '<a href="'.ensure_url($slide['enlace_boton_slider']).'" class="button button--wide button--main" target="_blank">'.$slide['texto_boton_slider'].'</a>';
                endif;
                $printer .=             '</div>';
                $printer .=         '</div>';
                $printer .=     '</article>';
                $printer .= '</div>';
            }
            $out  = '<section id="que-es" class="main__slide">';
            $out .= '<div class="slider slider--overlay" data-module="slider">';
            $out .=     '<div class="slider__items" data-role="slider-list">';
            $out .=         $printer;
            $out .=     '</div>';
            if($count>1){
                $out .=     '<div class="slider__arrows">';
                $out .=         '<button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button>';
                $out .=         '<button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button>';
                $out .=     '</div>';
            }
            $out .= '</div>';
            $out .= '</section>';

        }
        return $out;
    }

    //quienes somos
    function get_quienes($seccion){
        $printer = $out = "";
        if($seccion){
            $printer  = '<section id="'.$seccion['id_seccion'].'" class="horizon--simple">';
            $printer .=     '<div class="container">';
            $printer .=         '<div class="gridle-row">';
            $printer .=             '<div class="gridle-gr-6 gridle-gr-12@tablet no-padding--left no-padding--at_tablet">';
            $printer .=                 '<article class="common-box">';
            $printer .=                     '<div class="common-box__body">';
            $printer .=                         '<h2 class="horizon__title">'.$seccion['titulo_que'].'</h2>';
            $printer .=                         '<div class="common-box__excerpt">'.$seccion['bajada_que'].'</div>';
            $printer .=                     '</div>';
            $printer .=                 '</article>';
            $printer .=             '</div>';
            $printer .=             '<div class="gridle-gr-6 gridle-gr-12@tablet no-padding--left no-padding--at_tablet">';
            $printer .=                 '<article class="common-box">';
            $printer .=                     '<div class="common-box__body">';
            $printer .=                         '<h2 class="horizon__title">'.$seccion['titulo_quienes'].'</h2>';
            $printer .=                         '<div class="common-box__excerpt">'.$seccion['bajada_quienes'].'</div>';
            $printer .=                     '</div>';
            $printer .=                 '</article>';
            $printer .=             '</div>';
            $printer .=         '</div>';
            $printer .=     '</div>';
            $printer .= '</section>';
        }
        return $printer;
    }

    //calendario de actividades
    function get_calendario($seccion){
        $printer = $out = "";
        if($seccion){
            $printer  = '<section id="'.$seccion['id_seccion'].'" class="horizon">';
            $printer .=     '<div class="container">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon '.$seccion['tipo_calendario'].'">'.$seccion['titulo_calendarios'].'</h2>';
            foreach($seccion['calendario'] as $fecha){
                $printer .=         '<article class="common-box common-box--calendar">';
                $printer .=             '<div class="gridle-row">';
                $printer .=                 '<div class="gridle-gr-2 gridle-gr-12@tablet no-padding--vertical">';
                $printer .=                     '<div class="common-box__figure">';
                $printer .=                         '<p class="common-box__date">'.$fecha['calendario_fechas'].'</p>';
                $printer .=                     '</div>';
                $printer .=                 '</div>';
                $printer .=                 '<div class="gridle-gr-10 gridle-gr-12@tablet no-padding--vertical">';
                $printer .=                     '<div class="common-box__body">';
                $printer .=                         '<h4 class="common-box__title common-box__title--regular">'.$fecha['calendario_titulo'].'</h4>';
                $printer .=                         '<div class="common-box__excerpt common-box__excerpt--tiny">'.$fecha['calendario_descripcion'].'</div>';
                $printer .=                     '</div>';
                $printer .=                 '</div>';
                $printer .=             '</div>';
                $printer .=         '</article>';
            }
            $printer .=     '</div>';
            $printer .= '</section>';
        }

        return $printer;
    }

    //formulario de contacto
    function get_formulario($seccion){
        $printer = $out = "";
        $out = load_template_part('partials/formulario-inscripcion');
        if($seccion['cantidad_columnas']=='una'){
            $dividir = false;
            $columnas = '12';
        }else{
            $dividir = true;
            $columnas = '6';
        }

        if($seccion){
            $printer  = '<section id="'.$seccion['id_seccion'].'" class="horizon">';
            $printer .=     '<div class="container" id="feedback">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon inscripcion">'.$seccion['titulo_seccion'].'</h2>';
            $printer .=         '<div class="common-box">';
            $printer .=             '<div class="gridle-row">';

            if(!$dividir){
            $printer .=                 '<div class="gridle-gr-'.$columnas.' gridle-gr-12@tablet">';
            $printer .=                     '<div class="common-box__excerpt">';
            $printer .=                         $seccion['descripcion_seccion_1'];
            $printer .=                     '</div>';
            $printer .=                 '</div>';
            }else{
            $printer .=                 '<div class="gridle-gr-'.$columnas.' gridle-gr-12@tablet">';
            $printer .=                     '<div class="common-box__excerpt">';
            $printer .=                         $seccion['descripcion_seccion_1'];
            $printer .=                     '</div>';
            $printer .=                 '</div>';
            $printer .=                 '<div class="gridle-gr-'.$columnas.' gridle-gr-12@tablet">';
            $printer .=                     '<div class="common-box__excerpt">';
            $printer .=                         $seccion['descripcion_seccion_2'];
            $printer .=                     '</div>';
            $printer .=                 '</div>';
            }

            $printer .=             '</div>';
            $printer .=             $out;
            $printer .=         '</div>';
            $printer .=     '</div>';
            $printer .= '</section>';
        }

        return $printer;
    }

    //listado de speakers
    function get_speakers($seccion){
        $printer = $out = "";

        if($seccion){
            $printer  = '<section id="'.$seccion['id_seccion'].'" class="horizon">';
            $printer .=     '<div class="container">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon speakers">'.$seccion['titulo_seccion'].'</h2>';
            $printer .=         '<div class="common-box__excerpt horizon__excerpt">';
            $printer .=             $seccion['bajada_seccion'];
            $printer .=         '</div>';
            $printer .=         '<div class="gridle-row">';

            foreach($seccion['lista_speakers'] as $speaker){
                $speaker_cargo = get_field('cargo_speaker', $speaker);
                $desc_corta = get_field('descripcion_corta', $speaker);
                $desc_oculta = get_field('descripcion_oculta', $speaker);

                $printer .=             '<div class="gridle-gr-6 gridle-gr-12@tablet">';
                $printer .=                 '<article class="common-box common-box--news common-box--card">';
                $printer .=                     '<figure class="common-box__figure">';
                $printer .=                         get_the_post_thumbnail( $speaker, 'square', array( 'class' => 'elastic-img rounded-img' ));
                $printer .=                     '</figure>';
                $printer .=                     '<div class="common-box__body">';
                $printer .=                         '<h4 class="common-box__title common-box__title--midtall">'.$speaker->post_title.'</h4>';
                $printer .=                         '<span class="common-box__meta">'.$speaker_cargo.'</span>';
                $printer .=                         '<div class="common-box__excerpt">';
                $printer .=                             $desc_corta;
                $printer .=                         '</div>';
                $printer .=                         '<button class="button button--masinfo">+ Más información</button>';
                $printer .=                         '<div class="mas-info__body">';
                $printer .=                             $desc_oculta;
                $printer .=                         '</div>';
                $printer .=                     '</div>';
                $printer .=                 '</article>';
                $printer .=             '</div>';
            }

            $printer .=         '</div>';
            $printer .=     '</div>';
            $printer .= '</section>';
        }
        return $printer;
    }

    //video embedido full
    function get_welcu($seccion){
        $printer = $out = "";

        if($seccion){
            $urlvideo = get_embed_video($seccion['embed_video']);

            $printer  = '<section id="asistir" class="horizon">';
            $printer .=     '<div class="container">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon inscripcion">'.$seccion['titulo_seccion'].'</h2>';
            $printer .=         '<figure class="common-box__figure common-box__iframe change">';
            $printer .=            '<iframe src="'. $urlvideo .'" showinfo="0" frameborder="0" allowfullscreen></iframe>';
            $printer .=         '</figure>';
            $printer .=     '</div>';
            $printer .= '</section>';
        }

        return $printer;
    }

    //mosaico de videos
    function get_videos($seccion){
        $printer = $out = '';
        $count = 0;
        $galeria_id = $seccion['galeria_seccion'][0];

        if($seccion){
            $videos = get_field('videos', $galeria_id);
            $encargado = get_field('encargado_videos', $galeria_id);
            $encargado = $encargado[0];

            $printer  =  '<section id="'.$seccion['id_seccion'].'" class="horizon">';
            $printer .=     '<div class="container">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon video">'.$seccion['titulo_seccion'].'</h2>';
            $printer .=         '<div class="gridle-row">';

            foreach($videos as $video){
                $urlvideo = get_embed_video($video['url_video']);

                $count++;
                if($count<=1){
                    $out_f .=     '<article class="common-box common-box--video common-box--video--big">';
                    $out_f .=         '<figure class="common-box__figure">';
                    $out_f .=             '<iframe src="'.$urlvideo.'" showinfo="0" frameborder="0" allowfullscreen></iframe>';
                    $out_f .=         '</figure>';
                    $out_f .=         '<div class="common-box__body">';
                    $out_f .=             '<h4 class="common-box__title common-box__title--video">';
                    $out_f .=                 $video['titulo_video'];
                    $out_f .=             '</h4>';
                    $out_f .=             '<div class="common-box__meta common-box__meta--video">';
                    $out_f .=                 $encargado->post_title;
                    $out_f .=             '</div>';
                    $out_f .=         '</div>';
                    $out_f .=     '</article>';
                }elseif($count<=3){
                    $out_n .=     '<article class="common-box common-box--video">';
                    $out_n .=         '<figure class="common-box__figure">';
                    $out_n .=             '<iframe src="'.$urlvideo.'" showinfo="0" frameborder="0" allowfullscreen></iframe>';
                    $out_n .=         '</figure>';
                    $out_n .=         '<div class="common-box__body">';
                    $out_n .=             '<h4 class="common-box__title common-box__title--video">';
                    $out_n .=                 $video['titulo_video'];
                    $out_n .=             '</h4>';
                    $out_n .=             '<div class="common-box__meta common-box__meta--video">';
                    $out_n .=                 $encargado->post_title;
                    $out_n .=             '</div>';
                    $out_n .=         '</div>';
                    $out_n .=     '</article>';
                }else{
                    $out_x .=   '<div class="gridle-gr-6 gridle-gr-12@tablet">';
                    $out_x .=     '<article class="common-box common-box--video">';
                    $out_x .=         '<figure class="common-box__figure">';
                    $out_x .=             '<iframe src="'.$urlvideo.'" showinfo="0" frameborder="0" allowfullscreen></iframe>';
                    $out_x .=         '</figure>';
                    $out_x .=         '<div class="common-box__body">';
                    $out_x .=             '<h4 class="common-box__title common-box__title--video">';
                    $out_x .=                 $video['titulo_video'];
                    $out_x .=             '</h4>';
                    $out_x .=             '<div class="common-box__meta common-box__meta--video">';
                    $out_x .=                 $encargado->post_title;
                    $out_x .=             '</div>';
                    $out_x .=         '</div>';
                    $out_x .=     '</article>';
                    $out_x .=   '</div>';
                }
            }

            $printer .=             '<div class="gridle-gr-8 gridle-gr-12@tablet">';
            $printer .=                 $out_f;
            $printer .=             '</div>';
            $printer .=             '<div class="gridle-gr-4 gridle-gr-12@tablet no-padding--top_tablet">';
            $printer .=                 $out_n;
            $printer .=             '</div>';
            $printer .=             $out_x;
            $printer .=         '</div>';
            $printer .=      '</div>';
            $printer .= '</section>';
        }
        return $printer;
    }

    //mosaico de imágenes
    function get_imagenes($seccion){
        $printer = $out = '';
        $count = 0;
        $galeria_id = $seccion['galeria_img_seccion'][0];

        if($seccion){
            $imagenes = get_field('imagenes', $galeria_id);

            $printer  =  '<section id="'.$seccion['id_seccion'].'" class="horizon">';
            $printer .=     '<div class="container">';
            $printer .=         '<h2 class="horizon__title horizon__title--icon imagen">'.$seccion['titulo_seccion'].'</h2>';
            $printer .=         '<div class="common-box__excerpt">'.$seccion['bajada_seccion'].'</div>';
            $printer .=             '<div class="common-box--mosaic">';

            foreach($imagenes as $img){
                if($count==0){
                    $first_col .= '<a href="#" class="common-box--mosaic__item" data-module="modal" data-role="modal-btn" data-method="post" data-query="pid='.$galeria_id.'" data-target="/wp-json/deploy/gallery/" style="background-image: url('.$img['imagen'].');"></a>';
                }elseif($count>0 && $count<=2){
                    $second_col .= '<a href="#" class="common-box--mosaic__item" data-module="modal" data-role="modal-btn" data-method="post" data-query="pid='.$galeria_id.'" data-target="/wp-json/deploy/gallery/" style="background-image: url('.$img['imagen'].');"></a>';
                }elseif($count>2 && $count<=4){
                    $third_col .= '<a href="#" class="common-box--mosaic__item" data-module="modal" data-role="modal-btn" data-method="post" data-query="pid='.$galeria_id.'" data-target="/wp-json/deploy/gallery/" style="background-image: url('.$img['imagen'].');"></a>';
                }elseif($count>4 && $count<=5){
                    $fourth_col .= '<a href="#" class="common-box--mosaic__item" data-module="modal" data-role="modal-btn" data-method="post" data-query="pid='.$galeria_id.'" data-target="/wp-json/deploy/gallery/" style="background-image: url('.$img['imagen'].');"></a>';
                }
                $count++;
            }
            $printer .=                 '<div class="common-box--mosaic__column common-box--mosaic__column--big">';
            $printer .=                 $first_col;
            $printer .=                 '</div>';
            $printer .=                 '<div class="common-box--mosaic__column common-box--mosaic__column--small">';
            $printer .=                 $second_col;
            $printer .=                 '</div>';
            $printer .=                 '<div class="common-box--mosaic__column common-box--mosaic__column--small">';
            $printer .=                 $third_col;
            $printer .=                 '</div>';
            $printer .=                 '<div class="common-box--mosaic__column common-box--mosaic__column--big">';
            $printer .=                 $fourth_col;
            $printer .=                 '</div>';
            $printer .=             '</div>';
            $printer .=         '</div>';
            $printer .=     '</div>';
            $printer .=  '</section>';
        }
        return $printer;
    }

    //Noticias desde santotomas en linea -> blog_url(2) network-santotomas
    function get_news($width, $qant){
        $printer = $print_out = "";
        $noticias_ted = get_field("noticias_ted");
        $posts_per_page = !empty($noticias_ted)? count($noticias_ted) : 4 ;
        $count = 0;
        switch_to_blog(2);
        $args = array(
            'post_type' => 'any',
            'posts_per_page' => $posts_per_page,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'post__in' => $noticias_ted,
            'orderby' => 'post__in'
        );

        $noticias = new WP_Query($args);
        if($noticias->have_posts()):
            $print_out  = '<section id="noticias">';
            $print_out .=     '<h2 class="horizon__title">Noticias</h2>';

                while($noticias->have_posts()):
                    $count++;
                    $noticias->the_post();
                    $date = get_the_date(d, $post).'/'.get_the_date( m, $post ).'/'.get_the_date( Y, $post );

                    if (($noticias->current_post +1) == ($noticias->post_count)) {
                        $printer .=     '<article class="common-box common-box--news no-border">';
                    }else{
                        $printer .=     '<article class="common-box common-box--news">';
                    }
                    if(has_post_thumbnail($post)):
                    $printer .=         '<figure class="common-box__figure">';
                    $printer .=             '<a href="'.get_permalink($post).'" target="_blank" title="Ir a '.get_the_title( $post ).'">';
                    $printer .=                 get_the_post_thumbnail( $post, 'medium', 'post-title' );
                    $printer .=             '</a>';
                    $printer .=         '</figure>';
                    endif;
                    $printer .=         '<div class="common-box__body">';
                    $printer .=             '<h3 class="common-box__title common-box__title--news common-box__title--link">';
                    $printer .=                 '<a href="'.get_permalink($post).'" class="simple-link" target="_blank" title="Ir a '.get_the_title( $post ).'">';
                    $printer .=                     get_the_title( $post ) .' <span class="icon-elem icon-elem--open_in_new"></span>';
                    $printer .=                 '</a>';
                    $printer .=             '</h3>';
                    $printer .=             '<div class="common-box__info">';
                    $printer .=                 '<p>Publicado por <span class="common-box__info--from">ST EnLínea</span> el <span class="common-box__info--date">'. $date .'</span></p>';
                    $printer .=             '</div>';
                    $printer .=         '</div>';
                    $printer .=      '</article>';

                    if($width=='full'){
                        if($count==3 || $count == $qant){
                            $out .= '<div class="gridle-gr-6 gridle-gr-12@tablet">';
                            $out .= $printer;
                            $out .= '</div>';
                            $printer = '';
                            if($count==$qant){
                                $print_out .= '<div class="gridle-row full-articles">' . $out . '</div>';
                            }
                        }
                    }else{
                        if($count==$qant){
                            $print_out .= $printer;
                        }
                    }

                endwhile;
            $print_out .= '</section>';
        endif;
        wp_reset_query();
        restore_current_blog();

        return $print_out;
    }


    //**COMPLEX**/

    /**
    * Sete el contenido de un email a html
    * se usa en send_custom_email
    */
    function set_html_content_type(){
        return 'text/html';
    }

    /**
    * Devuelve un array asociativo de emails correspondientes a las notificaciones
    * Estos se setean en el area de administracion bajo "opciones generales" > "notificaciones"
    * @return array
    */
    function get_emails(){
        return get_field('emails_notificaciones', 'options')[0];
    }
    /**
    * Envia un email usando una de las plantillas previamente determinadas,
    * Esta funcion usa los output buffers de php para usar la plantilla de emails
    * de esta forma se hace mas facil la edicion y administracion de estas plantillas
    * @param  array $email_data - Array de datos que debe contener el email, tiene la forma de
    * array(
    *        'type' => 'notificacion',
    *        'to' => $emails['contacto'],
    *        'subject' => 'Nuevo Mensaje de contacto',
    *        'headers' => array(
    *            'From: Santo Tomás en Línea <'. $emails['permanente'] .'>',
    *            'Cc: '. $emails['permanente'],
    *            'Reply-To: '. $data['contact-name'] .' <'. $data['contact-email'] .'>'
    *        ),
    *        'email_contents' => array(
    *            'title' => '',
    *            'titulo' => '',
    *            'intro' => '',
    *            'mensaje' => ''
    *        )
    *    )
    * @return  void
    */
    function send_custom_email( $email_data, $return = false ){
        // $email_data['email_contents'] = array();
        // type = 'notificacion',
        // title = <title> del email (obligatorio),
        // intro = introduccion al mensaje (obligatorio)
        // mensaje = mensaje del email en formato HTML (obligatorio)
        $type = $email_data['type'];
        $to = $email_data['to'];
        $subject = $email_data['subject'];
        $headers = $email_data['headers'];
        $attachments = isset($email_data['attachments']) && !empty($email_data['attachments']) ? $email_data['attachments'] : null;

        $GLOBALS['email_contents'] = $email_data['email_contents'];

        // se empieza un output buffer para contener el template del email
        ob_start();
        if($type == 'notificacion'){
            get_template_part('partials/email-notificacion');
        }else{
            get_template_part('partials/email-administrador');
        }
        $message = ob_get_clean();
        // temina el output buffer

        // solo en caso de que se quiera devolver el string del correo
        if( !!$return ){ return $message; }

        add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        wp_mail( $to, $subject, $message, $headers, $attachments );
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    }

    /**
    * Se encarga de recibir y guardar las inscripciones de los speakers
    * @param  [array] $data - Informacion del POST
    * @return bool - true en exito, false en fracaso
    */
    function send_inscripcion_speaker_form( $data ){
        global $wpdb;
        // si no pasa el nonce muere
        // if( ! wp_verify_nonce( $data['st_nonce'], 'send_inscripcion_speaker_form' ) ){
        //     return 'invalid';
        // }

        // validacion de email por php
        if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'invalid';
        }

        // finfo para revisar los mime types
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // comprobante
        if( !empty($_FILES) && !empty($_FILES['fotografia']) ){
            // revisa el mime type
            // debe ser jpg o pdf
            $extension = array_search($finfo->file($_FILES['fotografia']['tmp_name']), array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png'
            ), true);

            if( $extension === false ){ return 'bad_mimetype'; }

            $fotografia_id = upload_custom_file( $_FILES['fotografia'] );
            if( !$fotografia_id ){
                wp_die('Error al subir el archivo de fotografia');
            }
        } else {
            return 'missing_file';
        }

        // primero se hace el post
        // Primero se guarga el respaldo en un post tipo contacto.
        $new_id = wp_insert_post(array(
            'post_title' => 'Inscripción de '. $data['nombres'] .' '. $data['apellidos'],
            'post_type' => 'inscripcion_speakers',
            'post_status' => 'publish'
        ));

        if( !$new_id || is_wp_error($new_id) ){
            wp_die('Error al crear inscripción');
        }

        switch ($data['presentacion-tipo']){
            case 'uno':
                $tipo_presentacion = 'La gran Idea: esta presentación trata de uno o dos temas centrales que son muy importantes y relevantes';
                break;
            case 'dos':
                $tipo_presentacion = 'Demostración Tecnológica: Demostración de una innovación tecnológica en la que el expositor ha participado en su creación';
                break;
            case 'tres':
                $tipo_presentacion = 'Declaración del artista: el artista muestral su arte y obras y expone lo que representa y todo el proceso de creación que involucra';
                break;
            case 'cuatro':
                $tipo_presentacion = 'Performance: Música, baile, magia, u otro tipo de exhibición de talentos para cautivar al público.';
                break;
            case 'cinco':
                $tipo_presentacion = 'Asombrado con las maravillas de la ciencia: Aquí el eje principal es el poder de la  ciencia y sus descubrimientos';
                break;
            case 'seis':
                $tipo_presentacion = 'Pequeñas grandes ideas: esta presentación no se concentra en una gran idea, sino más  bien en un tema con varias ideas que motivan la reflexión.';
                break;
            case 'siete':
                $tipo_presentacion = 'El problema: Esta presentación expone un tema o problemática de la que se sabe muy poco o casi nada';
                break;
        }

        //
        // primer tab
        //

        // campo: "nombre"
        update_field( "field_593ab6eb61d9d", $data['nombres'], $new_id );

        // campo: "apellidos"
        update_field( "field_593ab71261d9e", $data['apellidos'], $new_id );

        // campo: "email"
        update_field( "field_593ab71a61d9f", $data['email'], $new_id );

        // campo: "región"
        update_field( "field_593ab76561da0", $data['region'], $new_id );

        // campo: "ciudad"
        update_field( "field_593ab77161da1", $data['ciudad'], $new_id );

        // campo: "direccion"
        update_field( "field_593ab77a61da2", $data['direccion'], $new_id );

        // campo: "fotografia"
        update_field( "field_593ab78261da3", $fotografia_id, $new_id );

        //
        // segundo tab
        //

        // campo: "puesto"
        update_field( "field_593ab7e861da5", $data['puesto'], $new_id );

        // campo: "empresa"
        update_field( "field_593ab7ee61da6", $data['empresa'], $new_id );

        // campo: "area-biografia"
        update_field( "field_593ab7f361da7", $data['area-biografia'], $new_id );

        //
        // tercer tab
        //

        // campo: "presentacion-titulo"
        update_field( "field_593ab82e61da9", $data['presentacion-titulo'], $new_id );

        // campo: "presentacion-duracion"
        update_field( "field_593ab83f61daa", $data['presentacion-duracion'], $new_id );

        // campo: "presentacion-area"
        update_field( "field_593ab84a61dab", $data['presentacion-area'], $new_id );

        // campo: "presentacion-tipo"
        update_field( "field_593ab85461dac", $tipo_presentacion, $new_id );

        // campo: "area-presentacion"
        update_field( "field_593ab85f61dad", $data['area-presentacion'], $new_id );

        //////////////////
        ////////////
        //////////// ENVIAR NOTIFICACION
        ////////////

        $detalles = '<p>';
        $detalles .= '<strong>Datos Personales:</strong><br>';
        $detalles .= '<strong>Nombres:</strong> '. $data['nombres'] .'<br>';
        $detalles .= '<strong>Apellidos:</strong> '. $data['apellidos'] .'<br>';
        $detalles .= '<strong>Email:</strong> '. $data['email'] .'<br>';
        $detalles .= '<strong>Región:</strong> '. $data['region'] .'<br>';
        $detalles .= '<strong>Ciudad:</strong> '. $data['ciudad'] .'<br>';
        $detalles .= '<strong>Dirección:</strong> '. $data['direccion'] .'<br>';
        $detalles .= '<br>';
        $detalles .= '<strong>Datos Laborales:</strong><br>';
        $detalles .= '<strong>Puesto:</strong> '. $data['puesto'] .'<br>';
        $detalles .= '<strong>Empresa:</strong> '. $data['empresa'] .'<br>';
        $detalles .= '<strong>Biografía:</strong> '. $data['area-biografia'] .'<br>';
        $detalles .= '<br>';
        $detalles .= '<strong>Datos Presentación:</strong><br>';
        $detalles .= '<strong>Título:</strong> '. $data['presentacion-titulo'] .'<br>';
        $detalles .= '<strong>Duración:</strong> '. $data['presentacion-duracion'] .'<br>';
        $detalles .= '<strong>Área:</strong> '. $data['presentacion-area'] .'<br>';
        $detalles .= '<strong>Tipo:</strong> '. $tipo_presentacion .'<br>';
        $detalles .= '<strong>Resumen:</strong> '. $data['area-presentacion'] .'<br>';

        $detalles .= '</p>';


        $emails = get_emails();

        /// email para el usuario
        $mensaje = '<p>Recibimos correctamente  su postulación  que ingresó a través de nuestro formulario en TEDx Los Ángeles.</p>';
        $mensaje .= '<p>Recuerda que te contactaremos si eres seleccionado como speaker.</p>';
        $mensaje .= '<p>Los datos enviados son:</p>';
        $mensaje .= $detalles;

        send_custom_email(array(
            'type' => 'notificacion',
            'to' => $data['nombres'] .' <'. $data['email'] .'>',
            'subject' => 'Gracias por postular a TEDx Los Ángeles Chile',
            'headers' => array(
                'From: TEDxUST <'. $emails['permanente'] .'>',
                'Reply-To: TEDxUST <'. $emails['permanente'] .'>'
            ),
            'email_contents' => array(
                'title' => 'Inscripción Speakers TED',
                'intro' => 'Estimado/da '. $data['nombres'] . ':',
                'mensaje' => $mensaje
            )
        ));

        /// email para el administrador
        $mensaje = '<p>Hola, se recibió una nueva inscripción para los speakers TED</p>';
        $mensaje .= '<p>Los detalles de la solicitud son:</p>';
        $mensaje .= $detalles;

        $mensaje .= '<p style="margin-top:40px; font-size:11px;" >Enviamos una confirmación automática al remitente del mensaje, notificándole que su solicitud de inscripción ha sido recibida.</p>';

        send_custom_email(array(
            'type' => 'administrador',
            'to' => 'mailsantotomas@gmail.com',
            'subject' => 'Nueva postulación speaker TEDx Los ángeles '. date('Y'),
            'headers' => array(
                'From: TEDxUST <'. $emails['permanente'] .'>',
                'Cc: '. $emails['permanente']
            ),
            'attachments' => array(
                get_attached_file( $fotografia_id )
            ),
            'email_contents' => array(
                'title' => 'Nueva inscripción TEDxUST',
                'intro' => 'Estimado/da: ',
                'mensaje' => $mensaje
            )
        ));

        return true;
    }

    /**
    * Devuelve informacion variada acerca de un attachment en cuanto al archivo
    * @param  int $attach_id - ID del attachment
    * @return array - Coleccion de datos del attachment
    */
    function get_file_info( $attach_id ) {
        $filePath = get_attached_file( $attach_id );
        $attach = get_post( $attach_id );

        if ( is_object($attach) ){
            return array(
                'attachment-id' => $attach_id,
                'attachment' => $attach,
                'filepath' => $filePath,
                'file_url' => $attach->guid,
                'file_mimetype' => parse_mime_type( $filePath ),
                'file_size' => get_attachment_size( $filePath )
            );
        }

        return array();
    }

    /**
    * Devuelve la extension del archivo
    * @param  string $file_path - PATH al archivo
    * @return string - Extension del archivo
    */
    function parse_mime_type( $file_path ) {
        $chunks = explode('/', $file_path);
        return substr(strrchr( array_pop($chunks) ,'.'),1);
    }

    /**
    * Devuelve el peso del archivo formateado
    * @param  string $attachment_file_path - PATH al archivo
    * @return string - Tamano formateado en kb
    */
    function get_attachment_size( $attachment_file_path ) {
        return size_format( filesize( $attachment_file_path ) );
    }

    /**
    * Genera la galería de slides a utilizar en modal slider
    * @param  string $attachment_file_path - PATH al archivo
    * @return string - Tamano formateado en kb
    */
    function generate_regular_gallery_slider($pid){
        $galeria = get_field('imagenes', $pid);
        $count = 0;
        if($galeria):
            foreach( $galeria as $img ){
                $items .= '<div class="slider__slide" data-role="slider-slide">';
                $items .=   '<article class="common-box"><figure class="common-box__figure">';
                $items .=       '<img src="'.$img['imagen'].'" class="cover-img" alt="Imagen galería">';
                if($img['pie']):
                $items .=       '<figcaption>'.$img['pie'].'</figcaption>';
                endif;
                $items .= '</div>';
                $count++;
            }
        endif;
    
        $out = '<section class="modal-box" data-role="modal-content">';
        $out .=         '<div class="slider" data-module="slider">';
        $out .=                 '<div class="slider__items" data-role="slider-list">';
        $out .=                     $items;
        $out .=                 '</div>';
        $out .=                 '<div class="slider__arrows">';
        $out .=                     '<button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button>';
        $out .=                     '<button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button>';
        $out .=                 '</div>';
        $out .=         '</div>';
        $out .= '</section><script src="'.get_bloginfo('template_directory').'/scripts/min/main.min.js"></script>';
        //el modal necesita un script fuera del body de llamado
        return $out;
    }
    
    //Deploy modal gallery
    //HTML  -> partials/slider.php
    //JS    -> scripts/src/modals.js
    $api_rest = new api_rest();
    class api_rest {
      function __construct(){
        add_action('rest_api_init', array( $this, 'set_endpoints' ));
      }
    
      function set_endpoints(){
        register_rest_route('deploy/','gallery/', array(
          'methods' => 'POST',
          'callback' => array($this, 'deploy_gallery')
        ));
    
      }
    
      private function generate_slider_modal($info = array(), $template = 'slider.php') {
        $data = shortcode_atts(array(
            'html_slider' => false
          ), $info);
        $data = http_build_query($data);    
        $context_options = array(
          'http' => array(
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data
          )
        );
        $context = stream_context_create($context_options);
        return file_get_contents(get_bloginfo('template_directory') . '/partials/' . $template, false, $context);
      }
    
      function deploy_gallery(WP_REST_Request $request){
          $datos = $request->get_params();
          $pid = $datos['pid'];
          $html = $this->generate_slider_modal(
              array(
                  'html_slider'=> generate_regular_gallery_slider($pid)
              ),
              'slider.php'
          );
          return $html;
      }
    }

?>
