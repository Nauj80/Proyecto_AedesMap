const expresionesRegulares = {
    text: /^[a-zA-ZñÑ\s]+$/,
    email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/,
    password: /^[a-zA-Z0-9]{8,20}$/,
    tel: /^[0-9]{10,11}$/,
    number: /^[0-9]+$/,
    float: /^\d*(\.\d+)?$/,
    date: /.+/, 
    select: /.+/,
}

const errores = {
    text: 'EL campo debe contener solo letras y espacios',
    email: 'El campo debe contener un correo electrónico válido',
    password: 'La contraseña debe tener entre 8 y 20 caracteres alfanuméricos',
    tel:'El campo debe contener un número telefónico válido',
    date: 'Debe seleccionar una fecha válida.',
    select: 'Debe seleccionar una opción válida.',
}


const estadosValidacion = {}; 

const validarCampo = (input, msjElement) => {
    
    const tipoValidacion = input.getAttribute('data-tipo');
    const valor = input.value.trim();
    
    
    if (!tipoValidacion || input.disabled) return true; 

    const expresion = expresionesRegulares[tipoValidacion];
    const mensajeError = errores[tipoValidacion];

    
    if (valor === '') {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        msjElement.textContent = 'El campo es requerido';
        return false;
    }

    if (expresion.test(valor)) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        msjElement.textContent = ''; 
        return true;
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        msjElement.textContent = mensajeError;
        return false;
    }
}


document.addEventListener('DOMContentLoaded', () => {
    
    const forms = document.querySelectorAll('.form-validable');
    
    forms.forEach(form => {
        
        estadosValidacion[form.id] = {}; 
        
        const inputs = form.querySelectorAll('input');

        
        inputs.forEach(input => {
            
            
            const manejarValidacion = (e) => {
                const msj = document.querySelector(`#${e.target.id}Feedback`);
                const esValido = validarCampo(e.target, msj);
                
                
                estadosValidacion[form.id][input.id] = esValido; 
            };
            
            input.addEventListener('keyup', manejarValidacion);
            input.addEventListener('blur', manejarValidacion);
        });

        
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            let formularioCompletoValido = true;
            let primerError = null;

            
            inputs.forEach(input => {
                const msj = document.querySelector(`#${input.id}Feedback`);
                const esValido = validarCampo(input, msj);
                
                if (!esValido) {
                    formularioCompletoValido = false;
                    if (!primerError) {
                        primerError = input; 
                    }
                }
            });

            if (formularioCompletoValido) {

                form.submit();
            } else {
                
                if (primerError) {
                    primerError.focus();
                }
                alert('Por favor, corrige los errores del formulario antes de continuar.');
            }
        });
    });
});