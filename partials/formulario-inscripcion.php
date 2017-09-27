<?php
    $sending_form_valid = false;

    if( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false && !isset( $_POST['st_nonce'] ) ){
        wp_redirect( get_permalink( $post->ID ), 6 );
        exit;
    }
    elseif( isset( $_POST['st_nonce'] ) ){
        $sending_form_valid = send_inscripcion_speaker_form( $_POST );
    }
?>
<div class="gridle-row">
    <div class="gridle-prefix-1 gridle-gr-10 gridle-gr-12@tablet gridle-prefix-0@tablet">
        <div class="content-box content-box--form">

            <?php if( $sending_form_valid === true ) : ?>
            <section>
                <div class="gridle-row">
                    <div class="gridle-gr-12">
                        <h3 class="horizon__title upper">Gracias</h3>
                        <div class="common-box__excerpt">
                            <p>Su formulario ha sido recibido satisfactoriamente.</p>
                        </div>
                    </div>
                </div>
            </section>
            <?php elseif( $sending_form_valid === 'invalid' ) : ?>
            <section>
                <div class="gridle-row">
                    <div class="gridle-gr-12">
                        <h3 class="horizon__title upper">Lo sentimos</h3>
                        <div class="common-box__excerpt">
                            <p>
                                Su inscripción no pudo ser enviada, recomendamos que <a href="<?php the_permalink(); ?>" class="" title="Volver al formulario">intente de nuevo</a> o espere un momento para volver intentar.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <?php else: ?>
            <form action="<?php echo home_url(); ?>#feedback" method="post" id="formulario-speaker" class="form form--principal" data-module="common-form" novalidate data-validzr-handled="true" enctype="multipart/form-data">
                <div class="gridle-row">
                    <div class="gridle-gr-12 no-padding--bottom">
                        <h3 class="horizon__title upper">Datos personales</h3>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Debes ingresar sólo valores alfabéticos">
                            <label for="nombres" class="form-control__label">Nombres *</label>
                            <input type="text" class="form-control__field" id="nombres" name="nombres" placeholder="Escriba sus nombres" data-custom-validation="onlyString" required>
                            <span class="form-control__message">Sólo valores alfanúmericos. Ejemplo: Francisco</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Debes ingresar sólo valores alfabéticos">
                            <label for="apellidos" class="form-control__label">Apellidos *</label>
                            <input type="text" class="form-control__field" id="apellidos" name="apellidos" placeholder="Escriba sus apellidos" data-custom-validation="onlyString" required>
                            <span class="form-control__message">Sólo valores alfanúmericos. Ejemplo: Fuenzalida</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Debes ingresar un mail válido">
                            <label for="email" class="form-control__label">Mail *</label>
                            <input type="email" class="form-control__field" id="email" name="email" placeholder="Escribe tu email" required>
                            <span class="form-control__message">Ejemplo: mimail@empresa.com</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Seleccione entre las opciones">
                            <label for="region" class="form-control__label">Región *</label>
                            <select name="region" id="region" class="form-control__field form-control__field--select" required>
                                <option selected disabled>Seleccione su Región</option>
                                <option value="Región Metropolitana">Región Metropolitana</option>
                                <option value="I Región">I Región</option>
                                <option value="II Región">II Región</option>
                                <option value="III Región">III Región</option>
                                <option value="IV Región">IV Región</option>
                                <option value="V Región">V Región</option>
                                <option value="VI Región">VI Región</option>
                                <option value="VII Región">VII Región</option>
                                <option value="VIII Región">VII Región</option>
                                <option value="IX Región">IX Región</option>
                                <option value="X Región">X Región</option>
                                <option value="XI Región">XI Región</option>
                                <option value="XII Región">XII Región</option>
                                <option value="XIV Región">XIV Región</option>
                                <option value="XV Región">XV Región</option>
                            </select>
                            <span class="form-control__message">Seleccione entre las opciones</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="ciudad" class="form-control__label">Ciudad *</label>
                            <input type="text" class="form-control__field" id="ciudad" name="ciudad" placeholder="Ingrese su Ciudad" required>
                            <span class="form-control__message">Valores alfabéticos</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="direccion" class="form-control__label">Dirección *</label>
                            <input type="text" class="form-control__field" id="direccion" name="direccion" placeholder="Ingrese su dirección" required>
                            <span class="form-control__message">Valores alfabéticos y numéricos</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="fotografia" class="form-control__label">Adjunta fotografía</label>
                            <div class="form-control__field form-control__field--file">
                                <span class="form-control__field--file__txt">Fotografía</span>
                                <input type="file" id="fotografia" name="fotografia" accept="image/jpeg, image/jpg, image/png" required>
                            </div>
                            <span class="form-control__message">Formato .jpg o .png (Peso máx 2 MB)</span>
                        </div>
                    </div>
                </div>

                <div class="gridle-row">
                    <div class="gridle-gr-12 no-padding--bottom">
                        <h3 class="horizon__title upper">Datos laborales</h3>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Sólo valores alfabéticos">
                            <label for="puesto" class="form-control__label" required>Puesto Actual *</label>
                            <input type="text" class="form-control__field" id="puesto" name="puesto" placeholder="Ingresa el nombre de tu cargo actual" required>
                            <span class="form-control__message">Sólo valores alfabéticos</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Sólo valores alfabéticos">
                            <label for="empresa" class="form-control__label" required>Empresa *</label>
                            <input type="text" class="form-control__field" id="empresa" name="empresa" placeholder="Ingresa el nombre de tu cargo actual" required>
                            <span class="form-control__message">Sólo valores alfabéticos</span>
                        </div>
                    </div>
                    <div class="gridle-gr-12 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="area-biografia" class="form-control__label" required>Biografía *</label>
                            <textarea name="area-biografia" rows="5" class="form-control__field" id="area-biografia" placeholder="Escribe sobre tu trabajo estudios, investigaciones"
                                minlength="10" maxlength="800" required></textarea>
                            <span class="form-control__message">Puede tener una extensión máxima de <span id="max-biografia">800</span> caracteres.</span>
                        </div>
                    </div>
                </div>

                <div class="gridle-row">
                    <div class="gridle-gr-12 no-padding--bottom">
                        <h3 class="horizon__title upper">Datos de la presentación</h3>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Valores alfabéticos y numéricos">
                            <label for="presentacion-titulo" class="form-control__label">Título presentación <span class="lower">(10 palabras max.)</span></label>
                            <input type="text" class="form-control__field" id="presentacion-titulo" name="presentacion-titulo" required>
                            <span class="form-control__message">Valores alfabéticos y numéricos</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control" data-error-message="Seleccione un rango de duración">
                            <label for="presentacion-duracion" class="form-control__label">Duración *</label>
                            <select name="presentacion-duracion" id="presentacion-duracion" class="form-control__field form-control__field--select" required>
                                <option selected disabled>Ingrese duración</option>
                                <option value="5-min">5 minutos</option>
                                <option value="9-min">9 minutos</option>
                                <option value="12-min">12 minutos</option>
                                <option value="15-min">15 minutos</option>
                                <option value="18-min">18 minutos</option>
                            </select>
                            <span class="form-control__message">Seleccione un rango de duración</span>
                        </div>
                    </div>
                    <div class="gridle-gr-4 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="presentacion-area" class="form-control__label">Área del conocimiento *</label>
                            <select name="presentacion-area" id="presentacion-area" class="form-control__field form-control__field--select" required>
                                <option selected disabled>Ingrese área</option>
                                <option value="Ciencias naturales">Ciencias Naturales</option>
                                <option value="Ciencias económicas">Ciencias Económicas</option>
                                <option value="Astronomía y Astrofísica">Astronomía y Astrofísica</option>
                                <option value="Antropología">Antropología</option>
                                <option value="Ingeniería">Ingeniería</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Ciencias Médicas y de la Salud">Ciencias Médicas y de la Salud</option>
                                <option value="Ciencias Agrícolas">Ciencias Agrícolas</option>
                                <option value="Ciencias Sociales">Ciencias Sociales</option>
                                <option value="Educación">Educación</option>
                                <option value="Humanidades y Artes">Humanidades y Artes</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Otros">Otros</option>
                            </select>
                            <span class="form-control__message">Seleccione un área</span>
                        </div>
                    </div>

                    <div class="gridle-gr-12 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="presentacion-tipo" class="form-control__label">Tipo de presentación</label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="uno">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    La gran Idea: esta presentación trata de uno o dos temas centrales que son muy importantes y relevantes.
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="dos">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    Demostración Tecnológica: Demostración de una innovación tecnológica en la que el expositor ha participado en su creación.
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="tres">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    Declaración del artista: el artista muestral su arte y obras y expone lo que representa y todo el proceso de creación que involucra.
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="cuatro">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    Performance: Música, baile, magia, u otro tipo de exhibición de talentos para cautivar al público.
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="cinco">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    Asombrado con las maravillas de la ciencia: Aquí el eje principal es el poder de la  ciencia y sus descubrimientos. 
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="seis">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    Pequeñas grandes ideas: esta presentación no se concentra en una gran idea, sino más  bien en un tema con varias ideas que motivan la reflexión.
                                </span>
                            </label>
                            <label class="form-switch form-switch--block">
                                <input type="radio" class="valid-input" name="presentacion-tipo" value="siete">
                                <span class="form-switch__input form-switch__input--radio"></span>
                                <span class="form-switch__label">
                                    El problema: Esta presentación expone un tema o problemática de la que se sabe muy poco o casi nada.
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="gridle-gr-12 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label for="area-presentacion" class="form-control__label" required>Resumen de la presentación <span class="lower">(100 palabras max.)</span></label>
                            <textarea name="area-presentacion" rows="4" id="area-presentacion" class="form-control__field" maxlength="800" required></textarea>
                            <span class="form-control__message"><span id="max-presentacion">100</span> palabras como máximo</span>
                        </div>
                    </div>

                    <div class="gridle-gr-12 gridle-gr-12@tablet">
                        <div class="form-control">
                            <label class="form-switch form-switch--block form-switch--flexie">
                                <input type="checkbox" id="acepto" name="acepto" required>
                                <span class="form-switch__input form-switch__input--checkbox"></span>
                                <span class="form-switch__label">Estoy en conocimiento que los expositores en TEDxUniversidadSantoTomasLosAngeles no reciben compensación, retribución económica ni de ningún otro tipo de pago y que la presentación debe seguir estrictamente los protocolos establecidos por la comisión.</span>
                            </label>
                        </div>
                    </div>
                    <div class="gridle-gr-12 gridle-gr-12@tablet font-centered no-padding--bottom">
                        <span class="form-control__message">* Campos obligatorios</span>
                    </div>
                    <div class="gridle-gr-12 gridle-gr-12@tablet font-centered">
                        <div class="form-control form-control--button">
                            <input type="submit" class="button button--wide button--almost" value="Enviar">
                        </div>
                    </div>
                    <?php wp_nonce_field('enviar_inscripcion_speaker', 'st_nonce'); ?>
                </div>
            </form>
            <?php endif; ?>

        </div>
    </div>
</div>
