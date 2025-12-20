// Manejador global para formularios AJAX con SweetAlert

// Wrapper global para openEnableModal (evita ReferenceError si se invoca antes de definir la implementación)
window.openEnableModal = window.openEnableModal || function(id) {
  if (typeof window._realOpenEnableModal === 'function') {
    try { return window._realOpenEnableModal(id); } catch (e) { console.error('Error calling _realOpenEnableModal (wrapper):', e); }
  }
  window.__pendingEnableCalls = window.__pendingEnableCalls || [];
  window.__pendingEnableCalls.push(id);
};

document.addEventListener("DOMContentLoaded", function () {
  // Encontrar todos los formularios y agregar listener
  const formularios = document.querySelectorAll("form");

  formularios.forEach((formulario) => {
    formulario.addEventListener("submit", function (e) {
      e.preventDefault();
      enviarFormularioAjax(this);
    });
  });

  // Attach numeric-only handlers to inputs with class 'numeric'
  attachNumericHandlers();

  // Attach handlers for edit/disable buttons in user list
  attachUserListHandlers();

  // Fallback: attach direct click handlers to any existing enable buttons (evita depender solo de delegación)
  const enableBtns = document.querySelectorAll('.btn-enable');
  enableBtns.forEach(function(btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      const id = this.dataset.id;
      if (!id) return Swal.fire('Error', 'ID de usuario no encontrado', 'error');
      if (typeof window.openEnableModal === 'function') {
        try { window.openEnableModal(id); } catch (err) { console.error('Error calling openEnableModal from direct handler', err); Swal.fire('Error', 'Ocurrió un error', 'error'); }
      } else {
        console.error('openEnableModal not defined at click time (direct handler)');
        Swal.fire('Error', 'Función de habilitar no disponible (ver consola)', 'error');
      }
    });
  });

});

/* Handlers to show edit modal and confirm-disable modal for user list */
function attachUserListHandlers() {
  // Delegate clicks for edit buttons (use capture phase to preempt other handlers)
  document.addEventListener('click', function (e) {
    try {
      const editBtn = e.target.closest('.btn-edit');
      if (editBtn) {
        console.log('user-list: edit button clicked', editBtn.dataset);
        e.preventDefault();
        e.stopImmediatePropagation();
        const href = editBtn.getAttribute('href') || editBtn.dataset.href || '';
        const id = editBtn.dataset.id || getQueryParam(href, 'id');
        if (!id) {
          console.warn('No id found for edit button', editBtn);
          return Swal.fire('Error', 'ID de usuario no encontrado', 'error');
        }
        try {
          openEditModal(id);
        } catch (err) {
          console.error('openEditModal error', err);
          Swal.fire('Error', 'No se pudo abrir el modal de edición', 'error');
        }
      }

      const disableBtn = e.target.closest('.btn-disable');
      if (disableBtn) {
        console.log('user-list: disable button clicked', disableBtn.dataset);
        e.preventDefault();
        e.stopImmediatePropagation();
        const href = disableBtn.getAttribute('href') || disableBtn.dataset.href || '';
        const id = disableBtn.dataset.id || getQueryParam(href, 'id');
        if (!id) {
          console.warn('No id found for disable button', disableBtn);
          return Swal.fire('Error', 'ID de usuario no encontrado', 'error');
        }
        try {
          openDisableModal(id);
        } catch (err) {
          console.error('openDisableModal error', err);
          Swal.fire('Error', 'No se pudo abrir el modal de confirmación', 'error');
        }
      }

      const enableBtn = e.target.closest('.btn-enable');
      if (enableBtn) {
        console.log('user-list: enable button clicked', enableBtn.dataset);
        e.preventDefault();
        e.stopImmediatePropagation();
        const href = enableBtn.getAttribute('href') || enableBtn.dataset.href || '';
        const id = enableBtn.dataset.id || getQueryParam(href, 'id');
        if (!id) {
          console.warn('No id found for enable button', enableBtn);
          return Swal.fire('Error', 'ID de usuario no encontrado', 'error');
        }
        try {
          openEnableModal(id);
        } catch (err) {
          console.error('openEnableModal error', err);
          Swal.fire('Error', 'No se pudo abrir el modal de habilitación', 'error');
        }
      }
    } catch (err) {
      console.error('user-list click handler error', err);
    }
  }, true);
}

function getQueryParam(url, name) {
  try {
    const u = new URL(url, window.location.origin);
    return u.searchParams.get(name);
  } catch (err) {
    return null;
  }
}

async function openEditModal(id) {
  const modalEl = document.getElementById('modalEditUser');
  if (!modalEl) {
    console.error('Modal #modalEditUser not found');
    return Swal.fire('Error', 'El modal de edición no está disponible', 'error');
  }
  const modalBody = document.getElementById('modalEditBody');
  modalBody.innerHTML = 'Cargando...';
  let modal;
  try {
    modal = new bootstrap.Modal(modalEl);
    modal.show();
  } catch (err) {
    console.error('Bootstrap modal show error', err);
    return Swal.fire('Error', 'No se pudo mostrar el modal (Bootstrap no disponible o error)', 'error');
  }

  try {
    console.log('Fetching user data for id', id);

    const fd = new FormData();
    fd.append('id', id);

    const res = await fetch(`index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=getData`, {
      method: 'POST',
      body: fd,
    });

    // Comprobar que la respuesta sea JSON antes de parsear
    const contentType = res.headers.get('content-type') || '';
    if (!res.ok) {
      const text = await res.text();
      console.error('Server returned non-OK status', res.status, text);
      Swal.fire('Error', 'Error del servidor al solicitar los datos (ver consola)');
      modal.hide();
      return;
    }

    if (!contentType.includes('application/json')) {
      const text = await res.text();
      console.error('Respuesta no es JSON:', text);
      Swal.fire('Error', 'Respuesta inválida del servidor (ver consola)');
      modal.hide();
      return;
    }

    let data;
    try {
      data = await res.json();
    } catch (parseErr) {
      let text = '<no body>';
      try { text = await res.clone().text(); } catch (e) { /* ignore */ }
      console.error('Error parseando JSON:', parseErr, text);
      Swal.fire('Error', 'No se pudo parsear la respuesta del servidor (ver consola)');
      modal.hide();
      return;
    }

    const u = data.data.user;
    const rolesHtml = data.data.roles || '';
    const estadosHtml = data.data.estados || '';

    // Build the form HTML (simple and matching server-side expectations)
    const formHtml = `
      <form id="modalEditForm" action="index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postUpdate" method="post" novalidate>
        <input type="hidden" name="id" value="${u.id_usuario}">
        <div class="mb-3 row">
          <label for="id_documento" class="col-sm-3 col-form-label required">Documento</label>
          <div class="col-sm-9"><input id="id_documento" name="documento" class="form-control numeric" inputmode="numeric" pattern="\\d*" value="${u.documento}" autocomplete="off" required></div>
        </div>
        <div class="mb-3 row">
          <label for="id_nombre" class="col-sm-3 col-form-label required">Nombre</label>
          <div class="col-sm-9"><input id="id_nombre" name="nombre" class="form-control" value="${u.nombre}" autocomplete="name" required></div>
        </div>
        <div class="mb-3 row">
          <label for="id_apellido" class="col-sm-3 col-form-label required">Apellido</label>
          <div class="col-sm-9"><input id="id_apellido" name="apellido" class="form-control" value="${u.apellido}" autocomplete="family-name" required></div>
        </div>
        <div class="mb-3 row">
          <label for="id_telefono" class="col-sm-3 col-form-label required">Teléfono</label>
          <div class="col-sm-9"><input id="id_telefono" name="telefono" class="form-control numeric" inputmode="numeric" pattern="\\d*" value="${u.telefono}" autocomplete="tel" required></div>
        </div>
        <div class="mb-3 row">
          <label for="id_correo" class="col-sm-3 col-form-label required">Correo</label>
          <div class="col-sm-9"><input id="id_correo" name="correo" type="email" class="form-control" value="${u.correo}" autocomplete="email" required></div>
        </div>
        <div class="mb-3 row">
          <label for="id_rol_select" class="col-sm-3 col-form-label required">Rol</label>
          <div class="col-sm-9"><select id="id_rol_select" name="id_rol" class="form-control" required>${rolesHtml}</select></div>
        </div>
        <div class="mb-3 row">
          <label for="id_estado_select" class="col-sm-3 col-form-label required">Estado</label>
          <div class="col-sm-9"><select id="id_estado_select" name="id_estado_usuario" class="form-control" required>${estadosHtml}</select></div>
        </div>
        <div class="mb-3 row">
          <label for="id_password" class="col-sm-3 col-form-label">Nueva contraseña</label>
          <div class="col-sm-9"><input id="id_password" name="password" type="password" class="form-control" placeholder="Dejar en blanco para no cambiar" autocomplete="new-password"></div>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    `;

    modalBody.innerHTML = formHtml;

    // Attach numeric handlers to new inputs
    attachNumericHandlers();

    const modalForm = document.getElementById('modalEditForm');
    modalForm.addEventListener('submit', function (e) {
      e.preventDefault();
      // Use existing enviarFormularioAjax to handle validation & submission
      enviarFormularioAjax(this);
    });
  } catch (err) {
    console.error(err);
    Swal.fire('Error', 'Ocurrió un error al cargar el formulario', 'error');
    modal.hide();
  }
}

function openDisableModal(id) {
  const modalEl = document.getElementById('modalConfirmDisable');
  const modal = new bootstrap.Modal(modalEl);
  modal.show();

  const confirmBtn = document.getElementById('confirmDisableBtn');
  const handler = async function () {
    confirmBtn.disabled = true;
    try {
      const fd = new FormData();
      fd.append('id', id);
      const res = await fetch('index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postDelete', {
        method: 'POST',
        body: fd,
      });

      // Manejo seguro de la respuesta
      if (!res.ok) {
        const text = await res.text();
        console.error('Server returned non-OK status (postDelete)', res.status, text);
        Swal.fire('Error', 'Error del servidor al inhabilitar (ver consola)', 'error');
        return;
      }

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        const text = await res.text();
        console.error('Respuesta postDelete no es JSON:', text);
        Swal.fire('Error', 'Respuesta inválida del servidor al inhabilitar (ver consola)', 'error');
        return;
      }

      const data = await res.json();
      if (data.success) {
        Swal.fire({ icon: 'success', title: '¡Éxito!', text: data.message, timer: 1500, showConfirmButton: false }).then(() => location.reload());
      } else {
        Swal.fire('Error', data.message || 'No se pudo inhabilitar', 'error');
      }
    } catch (err) {
      console.error(err);
      Swal.fire('Error', 'Ocurrió un error', 'error');
    } finally {
      confirmBtn.disabled = false;
      modal.hide();
      confirmBtn.onclick = null;
    }
  };

  
  confirmBtn.onclick = handler;
}

window._realOpenEnableModal = async function(id) {
  console.log('openEnableModal called for id', id);
  const modalEl = document.getElementById('modalConfirmEnable');
  if (!modalEl) {
    console.error('Modal #modalConfirmEnable not found');
    return Swal.fire('Error', 'El modal de habilitación no está disponible', 'error');
  }
  const modal = new bootstrap.Modal(modalEl);
  modal.show();

  const confirmBtn = document.getElementById('confirmEnableBtn');
  if (!confirmBtn) {
    console.error('Botón #confirmEnableBtn no encontrado');
    modal.hide();
    return Swal.fire('Error', 'El botón de confirmación no está disponible', 'error');
  }

  const handler = async function () {
    confirmBtn.disabled = true;
    try {
      const fd = new FormData();
      fd.append('id', id);
      const res = await fetch('index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postEnable', {
        method: 'POST',
        body: fd,
      });

      // Manejo seguro de la respuesta
      if (!res.ok) {
        const text = await res.text();
        console.error('Server returned non-OK status (postEnable)', res.status, text);
        Swal.fire('Error', 'Error del servidor al habilitar (ver consola)', 'error');
        return;
      }

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        const text = await res.text();
        console.error('Respuesta postEnable no es JSON:', text);
        Swal.fire('Error', 'Respuesta inválida del servidor al habilitar (ver consola)', 'error');
        return;
      }

      const data = await res.json();
      if (data.success) {
        Swal.fire({ icon: 'success', title: '¡Éxito!', text: data.message, timer: 1500, showConfirmButton: false }).then(() => location.reload());
      } else {
        Swal.fire('Error', data.message || 'No se pudo habilitar', 'error');
      }
    } catch (err) {
      console.error(err);
      Swal.fire('Error', 'Ocurrió un error', 'error');
    } finally {
      confirmBtn.disabled = false;
      modal.hide();
      confirmBtn.onclick = null;
    }
  };

  // Replace previous click handler to avoid duplication
  confirmBtn.onclick = handler;
};

// Si hubo llamadas pendientes mientras el archivo se cargaba, procesarlas
if (window.__pendingEnableCalls && window.__pendingEnableCalls.length && typeof window._realOpenEnableModal === 'function') {
  window.__pendingEnableCalls.forEach(function(id){
    try { window._realOpenEnableModal(id); } catch(e){ console.error('Error processing pending openEnableModal call', e); }
  });
  delete window.__pendingEnableCalls;
}

// Exponer la función real como la función pública
window.openEnableModal = window._realOpenEnableModal;

function enviarFormularioAjax(formulario) {
  // Client-side validation: clear previous errors and validate required fields
  clearValidation(formulario);
  if (!validateForm(formulario)) {
    return; // abort submit if validation fails
  }

  const formData = new FormData(formulario);
  const action = formulario.getAttribute("action");

  // Mostrar loader
  Swal.fire({
    title: "Procesando...",
    html: "Por favor espere",
    didOpen: async () => {
      Swal.showLoading();

      try {
        const response = await fetch(action, {
          method: "POST",
          body: formData,
        });

        // Intentar parsear JSON de forma segura
        let data;
        const ct = response.headers.get('content-type') || '';
        if (!response.ok) {
          let text = '<no body>';
          try { text = await response.clone().text(); } catch (e) { /* ignore */ }
          console.error('Server returned non-OK status', response.status, text);
          Swal.fire('Error', 'Error del servidor (ver consola)', 'error');
          return;
        }

        if (!ct.includes('application/json')) {
          let text = '<no body>';
          try { text = await response.clone().text(); } catch (e) { /* ignore */ }
          console.error('Respuesta del servidor no es JSON:', text);
          Swal.fire('Error', 'Respuesta inválida del servidor (ver consola)', 'error');
          return;
        }

        try {
          data = await response.json();
        } catch (err) {
          let text = '<no body>';
          try { text = await response.clone().text(); } catch (e) { /* ignore */ }
          console.error('Error parseando JSON:', err, text);
          Swal.fire('Error', 'No se pudo procesar la respuesta del servidor (ver consola)', 'error');
          return;
        }

        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: data.message,
            showConfirmButton: false,
            timer: 2000,
            didClose: () => {
              if (data.data && data.data.redirect) {
                window.location.href = data.data.redirect;
              } else {
                location.reload();
              }
            },
          });
        } else {
          // Log full server response for debugging (includes db_error if provided)
          console.error('Server error response:', data);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
            confirmButtonText: "OK",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Ocurrió un error en la solicitud",
          confirmButtonText: "OK",
        });
        console.error("Error:", error);
      }
    },
  });
}

function clearValidation(form) {
  const invalids = form.querySelectorAll('.is-invalid');
  invalids.forEach((el) => el.classList.remove('is-invalid'));
  const feedbacks = form.querySelectorAll('.invalid-feedback');
  feedbacks.forEach((el) => el.remove());
}

function validateForm(form) {
  let valid = true;
  let firstInvalid = null;

  const requiredFields = form.querySelectorAll('[required]');
  requiredFields.forEach((field) => {
    // For checkboxes/radios, check checked state
    let value = field.value;
    if (field.type === 'checkbox' || field.type === 'radio') {
      if (!field.checked) value = '';
    }

    if (!value || value.toString().trim() === '') {
      markInvalid(field, 'Este campo es obligatorio');
      valid = false;
      if (!firstInvalid) firstInvalid = field;
      return;
    }

    // Email validation
    if (field.type === 'email') {
      const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/i;
      if (!re.test(value)) {
        markInvalid(field, 'Ingrese un correo válido');
        valid = false;
        if (!firstInvalid) firstInvalid = field;
        return;
      }
    }
    // Documento must be digits only
    if (field.name === 'documento') {
      if (!/^\d+$/.test(value)) {
        markInvalid(field, 'Este campo sólo admite números');
        valid = false;
        if (!firstInvalid) firstInvalid = field;
        return;
      }
    }

    // Telefono: digits only (enforce numeric input requirement)
    if (field.name === 'telefono') {
      if (!/^\d+$/.test(value)) {
        markInvalid(field, 'El teléfono solo debe contener números');
        valid = false;
        if (!firstInvalid) firstInvalid = field;
        return;
      }
    }
  });

  if (!valid) {
    if (firstInvalid) firstInvalid.focus();
    Swal.fire({ icon: 'error', title: 'Datos incompletos', text: 'Por favor corrija los campos marcados en rojo' });
  }

  return valid;
}

function markInvalid(field, message) {
  field.classList.add('is-invalid');
  const feedback = document.createElement('div');
  feedback.className = 'invalid-feedback';
  feedback.innerText = message;
  if (field.nextSibling) {
    field.parentNode.insertBefore(feedback, field.nextSibling);
  } else {
    field.parentNode.appendChild(feedback);
  }
}

function attachNumericHandlers() {
  const numericFields = document.querySelectorAll('input.numeric');
  numericFields.forEach((input) => {
    // Prevent non-digit characters on input (works with paste)
    input.addEventListener('input', (e) => {
      const old = input.value;
      const cleaned = old.replace(/\D+/g, '');
      if (old !== cleaned) input.value = cleaned;
    });

    // Prevent typing non-digit characters (extra UX)
    input.addEventListener('keypress', (e) => {
      const ch = String.fromCharCode(e.which);
      if (!/[0-9]/.test(ch)) {
        e.preventDefault();
      }
    });
  });
}

