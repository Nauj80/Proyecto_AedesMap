<div class="mt-3 container">
    <div class="display-4 mb-4 border-bottom pb-2">
        Registro de Tipo de Actividades
    </div>
    
    <form class="form-validable" action="<?php echo getUrl("TipoActividades","TipoActividades","postCreate")?>" method="post">
        
        <div class="row g-4 justify-content-center"> 
            
            <div class="col-12 col-lg-8">  
                <div class="form-floating">
                    <input type="text" name="nombre" id="nombre" class='form-control' placeholder="Nombre de la actividad" required data-tipo="text" 
                    value="">
                    <label for="nombre"><span class="text-danger">*</span> Nombre de la actividad</label>
                    <div id="nombreFeedback" class="invalid-feedback">
                    El campo es requerido.
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="row mt-5">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save me-2"></i> Registrar Actividad
                </button>
                <a href="<?php echo getUrl("TipoActividades","TipoActividades","list")?>" class="btn btn-secondary btn-lg ms-2">
                    <i class="fas fa-list me-2"></i> Volver a la Lista
                </a>
            </div>
        </div>
        
    </form>
</div>