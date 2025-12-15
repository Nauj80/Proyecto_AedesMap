<form class="form-validable" method="POST" action="<?php echo getUrl("ActividadesSeguimiento","Actividades","postCreate")?>">
    
    <div class="display-4 mb-4 border-bottom pb-2">
        Registro de Seguimiento de Tanque
    </div>

    <h5 class="mt-4 mb-3 text-secondary">Identificación del Seguimiento</h5>
    <div class="row g-4 justify-content-center"> 
        
        <div class="col-12 col-lg-4"> 
            <label for="fecha"><span class="text-black">*</span> Fecha</label> 
            <input type="date" name="fecha" id="fecha" class='form-control' placeholder="Fecha" required data-tipo="date" 
            value="<?php echo date('Y-m-d'); ?>">
            <div id="fechaFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <label for="id_zoocriadero"><span class="text-black">*</span> Zoocriadero</label>
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
            <div id="id_zoocriaderoFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>
        
        <div class="col-12 col-lg-4">
            <label for="id_tanque"><span class="text-black">*</span>Tanque</label>
            <select name="id_tanque" id="id_tanque" class='form-select' required data-tipo="select"
            data-url='<?php echo getUrl("ActividadesSeguimiento", "Actividades", "getCantidadPecesByTanque",false,"ajax");?>'>
                <option value="">Seleccione un Zoocriadero primero</option>
            </select>
            <div id="id_tanqueFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>
    </div>

    <input type="hidden" name="cantidad_inicial_tanque" id="cantidad_inicial_tanque" value="">

    <h5 class="mt-5 mb-3 text-secondary">Parámetros de Calidad del Agua</h5>
    <div class="row g-4 justify-content-center">

       <div class="col-12 col-md-4">
           <label for="ph"><span class="text-black">*</span> pH </label>
           <input type="number" step="0.01" name="ph" id="ph" class='form-control' placeholder="(Ej: 7.20)" required data-tipo="float" 
                value="">
           <div id="phFeedback" class="invalid-feedback">
               El campo es requerido.
           </div>
       </div>

        <div class="col-12 col-md-4">
            <label for="temperatura"><span class="text-black">*</span> Temperatura (°C)</label>
            <input type="number" step="0.01" name="temperatura" id="temperatura" class='form-control' placeholder="(Ej: 32)" required  data-tipo="float">
            <div id="temperaturaFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="cloro"><span class="text-black">*</span> Cloro (ppm)</label>
            <input type="number" step="0.01" name="cloro" id="cloro" class='form-control' placeholder="(Ej: 1.5)" required data-tipo="float">
            <div id="cloroFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>
    </div>

    <h5 class="mt-5 mb-3 text-secondary">Conteo de Población y Detalles</h5>
    <div class="row g-4 justify-content-center">

        <div class="col-12 col-md-4">
            <label for="id_actividad"><span class="text-black">*</span> Actividad Realizada</label>
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
            <div id="id_actividadFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="num_alevines"><span class="text-black">*</span> N° Alevines (Nacimientos)</label>
            <input type="number" name="num_alevines" id="num_alevines" class='form-control' placeholder="Nacimientos" value="0" required 
            data-tipo="number">
            <div id="num_alevinesFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="num_muertes_hembras"><span class="text-black">*</span> N° Muertes Hembras</label>
            <input type="number" name="num_muertes_hembras" id="num_muertes_hembras" class='form-control' placeholder="Muertes Hembras" value="0" required data-tipo="number">
            <div id="num_muertes_hembrasFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="num_muertes_machos"><span class="text-black">*</span> N° Muertes Machos</label>
            <input type="number" name="num_muertes_machos" id="num_muertes_machos" class='form-control' placeholder="Muertes Machos" value="0" required data-tipo="number">
            <div id="num_muertes_machosFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <div class="col-12 col-lg-12">
            <label for="observaciones"><span class="text-black">*</span> Observaciones</label>
            <textarea name="observaciones" id="observaciones" class='form-control' placeholder="Observaciones" style="height: 120px" required>Ninguna</textarea>
            <div id="observacionesFeedback" class="invalid-feedback">
                El campo es requerido.
            </div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert">      
                <div> 
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>      
                <button type="button" class="btn-close ms-4" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success btn-lg mb-2 mb-md-0 me-md-2">
                <i class="fas fa-save me-2"></i> Registrar Seguimiento
            </button>
            <a href="<?php echo getUrl("ActividadesSeguimiento","Actividades","listar")?>" class="btn btn-secondary btn-lg ms-2">
                <i class="fas fa-list me-2"></i> Ver Historial
            </a>
        </div>
    </div>

</form>