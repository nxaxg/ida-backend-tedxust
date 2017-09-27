        <section class="horizon">
            <div class="container">
                <div class="gridle-row">
                <?php 
                    $noticias_ted = get_field('noticias_ted');
                    $qant = count($noticias_ted);
                    if($qant>4){
                        $grid_class = 'gridle-gr-12';
                        $grid_width = 'full';
                    }else{
                        $grid_class = 'gridle-gr-6 gridle-gr-12@tablet';
                        $grid_width = 'none';
                    }
                ?>
                    <div class="<?php echo $grid_class; ?>">
                        <?php
                            echo get_news($grid_width, $qant);
                         ?>
                    </div>
                    <div class="<?php echo $grid_class; ?>">
                        <section id="contacto">
                            <h2 class="horizon__title">Contáctanos</h2>
                            <?php
                                $contacto_encargado = get_field('contacto_encargado', 'options');
                                $contacto_horarios = get_field('contacto_horarios', 'options');
                                $contacto_email = get_field('contacto_email', 'options');
                                $contacto_direccion = get_field('contacto_direccion', 'options');
                                $contacto_embed = get_field('contacto_embed', 'options');
                                $contacto_imagen = get_field('contacto_imagen', 'options');
                                $urldireccion = ensure_url('www.google.com/maps/place/'.urlencode($contacto_direccion));
                            ?>
                            <article class="common-box common-box--cover" style="background-image: url('<?php echo $contacto_imagen; ?>');">
                                <dl class="common-box__dl">
                                <?php
                                    if($contacto_encargado):
                                ?>
                                    <dt class="common-box__dl__icon">
                                        <span class="icon-elem icon-elem--person"></span>
                                    </dt>
                                    <dd class="common-box__dl__description">
                                        <?php echo $contacto_encargado; ?>
                                    </dd>
                                <?php
                                    endif;
                                    if($contacto_horarios):
                                ?>
                                    <dt class="common-box__dl__icon">
                                        <span class="icon-elem icon-elem--schedule"></span>
                                    </dt>
                                    <dd class="common-box__dl__description">
                                        <?php echo $contacto_horarios; ?>
                                    </dd>
                                <?php
                                    endif;
                                    if($contacto_email):
                                ?>
                                    <dt class="common-box__dl__icon">
                                        <span class="icon-elem icon-elem--mail_outline"></span>
                                    </dt>
                                    <dd class="common-box__dl__description">
                                        <a href="mailto:contacto@tedxlosangeles.cl" class="simple-link" rel="nofollow" title="E-mail de encargado" target="_blank">
                                            <?php echo $contacto_email; ?>
                                        </a>
                                    </dd>
                                <?php
                                    endif;
                                    if($contacto_direccion):
                                ?>
                                    <dt class="common-box__dl__icon">
                                        <span class="icon-elem icon-elem--place"></span>
                                    </dt>
                                    <dd class="common-box__dl__description">
                                        <a href="<?php echo $urldireccion; ?>" class="simple-link" rel="nofollow" title="Dirección de TEDxUST LA" target="_blank">
                                            <?php echo $contacto_direccion; ?>
                                        </a>
                                    </dd>
                                </dl>
                                <?php
                                    endif;
                                ?>
                            </article>
                            <article class="common-box common-box--full">
                                <div class="gridle-row">
                                    <div class="gridle-gr-12 no-padding">
                                        <iframe src="<?php echo ensure_url($contacto_embed); ?>" height="300" frameborder="0" style="border:0" scrolling="no" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </article>
                        </section>
                    </div>
                </div>
            </div>
        </section>