<form class="form-validable" method="POST" action="<?php echo getUrl("ActividadesSeguimiento","Actividades","postCreate")?>">
    
    <div class="display-4 mb-4 border-bottom pb-2">
         Registro de Seguimiento de Tanque 🐟
    </div>

    <h5 class="mt-4 mb-3 text-secondary">Identificación del Seguimiento</h5>
    <div class="row g-4 justify-content-center"> 
        
        <div class="col-12 col-lg-4"> 
            <div class="form-floating">
                <input type="date" name="fecha" id="fecha" class='form-control' placeholder="Fecha" required data-tipo="date" 
                value="<?php echo date('Y-m-d'); ?>">
                <label for="fecha"><span class="text-danger">*</span> Fecha</label>
                <div id="fechaFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="form-floating">
                <select name="id_zoocriadero" id="id_zoocriadero" class='form-select' required data-tipo="select"
                     data-url='<?php echo getUrl("ActividadesSeguimiento","Actividades","getTanquesByZoo",false,"ajax")?>'>
                    <option value="">Seleccione Zoocriadero...</option>
                    <?php 
                        if (!empty($zoocriaderos)) {
                            foreach ($zoocriaderos as $zoo) {
                                echo "<option value='{$zoo['id_zoocriadero']}'>{$zoo['nombre_zoocriadero']}</option>";
                            }
                        }
                    ?>
                </select>
                <label for="id_zoocriadero"><span class="text-danger">*</span> Zoocriadero</label>
                <div id="id_zoocriaderoFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-4">
            <div class="form-floating">
                <select name="id_tanque" id="id_tanque" class='form-select' required data-tipo="select"
                data-url='<?php echo getUrl("ActividadesSeguimiento", "Actividades", "getCantidadPecesByTanque",false,"ajax");?>'>
                    <option value="">Seleccione un Zoocriadero primero</option>
                </select>
                <label for="id_tanque"><span class="text-danger">*</span>Tanque</label>
                <div id="id_tanqueFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="cantidad_inicial_tanque" id="cantidad_inicial_tanque" value="">


    <h5 class="mt-5 mb-3 text-secondary">Parámetros de Calidad del Agua</h5>
    <div class="row g-4 justify-content-center">

       <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="ph" id="ph" class='form-control' placeholder="pH" required data-tipo="float" 
                    value="">
                <label for="ph"><span class="text-danger">*</span> pH (Ej: 7.20)</label>
                <div id="phFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="temperatura" id="temperatura" class='form-control' placeholder="Temperatura" required  data-tipo="float">
                <label for="temperatura"><span class="text-danger">*</span> Temperatura (°C)</label>
                <div id="temperaturaFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="cloro" id="cloro" class='form-control' placeholder="Cloro" required data-tipo="float">
                <label for="cloro"><span class="text-danger">*</span> Cloro (ppm)</label>
                <div id="cloroFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>
    </div>

        <h5 class="mt-5 mb-3 text-secondary">Conteo de Población y Detalles</h5>
    <div class="row g-4 justify-content-center">

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <select name="id_actividad" id="id_actividad" class='form-select' required data-tipo="select">
                    <option value="">Seleccione Actividad...</option>
                    <?php 
                        if (!empty($actividades)) {
                            foreach ($actividades as $act) {

                                echo "<option value='{$act['id_actividad']}'>{$act['nombre']}</option>";
                            }
                        }
                    ?>
                </select>
                <label for="id_actividad"><span class="text-danger">*</span> Actividad Realizada</label>
                <div id="id_actividadFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="num_alevines" id="num_alevines" class='form-control' placeholder="Nacimientos" value="0" required 
                data-tipo="number">
                <label for="num_alevines"><span class="text-danger">*</span> N° Alevines (Nacimientos)</label>
                <div id="num_alevinesFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="num_muertes_hembras" id="num_muertes_hembras" class='form-control' placeholder="Muertes Hembras" value="0" required data-tipo="number">
                <label for="num_muertes_hembras"><span class="text-danger">*</span> N° Muertes Hembras</label>
                <div id="num_muertes_hembrasFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating">
                <input type="number" name="num_muertes_machos" id="num_muertes_machos" class='form-control' placeholder="Muertes Machos" value="0" required data-tipo="number">
                <label for="num_muertes_machos"><span class="text-danger">*</span> N° Muertes Machos</label>
                <div id="num_muertes_machosFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12">
            <div class="form-floating">
                <textarea name="observaciones" id="observaciones" class='form-control' placeholder="Observaciones" style="height: 120px" required>Ninguna</textarea>
                <label for="observaciones"><span class="text-danger">*</span> Observaciones</label>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save me-2"></i> Registrar Seguimiento
            </button>
            <a href="<?php echo getUrl("ActividadesSeguimiento","Actividades","list")?>" class="btn btn-secondary btn-lg ms-2">
                <i class="fas fa-list me-2"></i> Ver Historial
            </a>
        </div>
    </div>

</form>