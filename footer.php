<footer id="bottom" class="footer-bar" >
	<div class="container">
		<div class="gridle-row">
			<div class="gridle-gr-3 gridle-gr-12@tablet">
				<a class="app-brand" href="index.html" title="title">
					<img src="<?php echo get_bloginfo('template_directory'); ?>/images/logos/ted-logo-footer.svg" alt="Logo" class="app-brand__logo">
				</a>
			</div>
            <?php
                $menu_footer = wp_get_nav_menu_items('footer');
                $count = 0;
                foreach($menu_footer as $item_f){
                    $count++;
                    if(is_front_page()){
                        if($count<=5){
                            $firstcol .= '<a href="'.$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                        }else{
                            $secondcol .= '<a href="'.$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                        }
                    }else{
                        if($count<=5){
                            if($item_f == end($menu_footer)){
                                $secondcol .= '<a href="'.$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                            }else{
                                $secondcol .= '<a href="'. home_url() .$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                            }
                        }else{
                            if($item_f == end($menu_footer)){
                                $secondcol .= '<a href="'.$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                            }else{
                                $secondcol .= '<a href="'. home_url() .$item_f->url.'" class="footer-bar__link" title="Ir a '.$item_f->title.'">'.$item_f->title.'</a>';
                            }
                        }
                    }
                }
            ?>
			<div class="gridle-gr-2 gridle-gr-5@tablet gridle-prefix-1@tablet">
                <?php echo $firstcol; ?>
			</div>
            <div class="gridle-gr-2 gridle-gr-5@tablet">
                <?php echo $secondcol; ?>
			</div>
			<div class="gridle-gr-2 gridle-gr-12@tablet gridle-prefix-3 gridle-prefix-0@tablet font-righted">
				<div class="footer-bar--info">
                    <p class="footer-bar--info__title">Redes Sociales</p>
                    <p class="footer-bar__social">
                    <?php
                        $menu_rrss = wp_get_nav_menu_items('rrss');

                        foreach($menu_rrss as $rs){
                            echo '<a href="'.ensure_url($rs->url).'" target="_blank" rel="me" title="Ir a '.$rs->title.'" class="social-link--'.strtolower($rs->title).' social-link">'.$rs->title.'</a>';
                        }
                    ?>
                    </p>
                </div>
			</div>
		</div>
	</div>
    <div class="container--separator">
        <div class="gridle-row">
            <div class="common-box__excerpt common-box__excerpt--mini">
                <?php the_field('mensaje_footer', 'options'); ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>