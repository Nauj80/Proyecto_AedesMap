// Manejador global para formularios AJAX con SweetAlert

document.addEventListener("DOMContentLoaded", function () {
  // Encontrar todos los formularios y agregar listener
  const formularios = document.querySelectorAll("form");

  formularios.forEach((formulario) => {
    formulario.addEventListener("submit", function (e) {
      e.preventDefault();
      enviarFormularioAjax(this);
    });
  });
});

function enviarFormularioAjax(formulario) {
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

        const data = await response.json();

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
