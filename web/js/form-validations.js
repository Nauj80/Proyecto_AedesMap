(function (window) {
  "use strict";

  function initFormValidation(formSelector) {
    let form =
      typeof formSelector === "string"
        ? document.getElementById(formSelector)
        : formSelector;
    if (!form) return;

    const expresiones = {
      text: /^[a-zA-ZñÑ'\s]+$/,
      integer: /^\d+$/,
      float: /^\d+(\.\d+)?$/,
    };

    const inputs = Array.from(form.querySelectorAll("input, select"));

    function setInvalid(el, msg) {
      el.classList.remove("is-valid");
      el.classList.add("is-invalid");
      const fb = el.nextElementSibling;
      if (fb && fb.classList.contains("invalid-feedback"))
        fb.textContent = msg || "";
    }

    function setValid(el) {
      el.classList.remove("is-invalid");
      el.classList.add("is-valid");
      const fb = el.nextElementSibling;
      if (fb && fb.classList.contains("invalid-feedback")) fb.textContent = "";
    }

    inputs.forEach(function (input) {
      // Ignorar campos hidden
      if (input.type === "hidden") return;

      let tag = input.tagName.toLowerCase();
      if (tag === "select") {
        input.addEventListener("change", function (e) {
          validarElemento(e.target);
        });
      } else {
        input.addEventListener("keyup", function (e) {
          validarElemento(e.target);
        });
        input.addEventListener("blur", function (e) {
          validarElemento(e.target);
        });
      }
    });

    function validarElemento(el) {
      // Ignorar campos hidden
      if (el.type === "hidden") return true;

      const inp = el.classList || "";
      const val = (el.value || "").toString().trim();

      const tag = el.tagName.toLowerCase();
      // Universal required check: no empty values allowed
      if (val === "") {
        if (tag === "select") setInvalid(el, "Seleccione una opción.");
        else setInvalid(el, "El campo es requerido");
        return false;
      }

      if (inp.contains("t")) {
        if (!expresiones.text.test(val)) {
          setInvalid(el, "Ingrese un nombre válido (solo letras)");
          return false;
        }
        setValid(el);
        return true;
      }
      if (inp.contains("n")) {
        if (!expresiones.integer.test(val)) {
          setInvalid(el, "Ingrese solo números enteros");
          return false;
        }
        setValid(el);
        return true;
      }

      if (inp.contains("f")) {
        if (!val) {
          setInvalid(el, "El campo es requerido");
          return false;
        }
        if (!expresiones.float.test(val)) {
          setInvalid(el, "Ingrese número válido (use punto para decimales)");
          return false;
        }
        setValid(el);
        return true;
      }

      // default: for other input types just mark valid (value already checked)
      setValid(el);
      return true;
    }

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      e.stopPropagation();

      let ok = true;
      inputs.forEach(function (input) {
        // Ignorar campos hidden en la validación
        if (input.type !== "hidden") {
          if (!validarElemento(input)) ok = false;
        }
      });

      // SI HAY ERRORES, DETENER COMPLETAMENTE EL ENVÍO
      if (!ok) {
        Swal.fire({
          icon: "error",
          title: "Formulario con errores",
          text: "Por favor corrija los campos marcados en rojo.",
        });
        return false;
      }

      // Solo si todo está OK, proceder con el envío
      const action = form.action || window.location.href;
      const method = (form.method || "POST").toUpperCase();
      const fd = new FormData(form);

      fetch(action, {
        method: method,
        body: fd,
        credentials: "same-origin",
      })
        .then(function (response) {
          const ct = response.headers.get("content-type") || "";
          if (ct.indexOf("application/json") !== -1) {
            return response.json().then(function (json) {
              return { json: json };
            });
          }
          return response.text().then(function (text) {
            return { text: text };
          });
        })
        .then(function (res) {
          if (res.json) {
            const json = res.json;
            if (json && json.success && json.data && json.data.redirect) {
              Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: json.message || "Operación realizada correctamente.",
                timer: 1800,
                showConfirmButton: false,
              }).then(() => {
                window.location.href = json.data.redirect;
              });
              return;
            }
            // Si hay un mensaje de error del servidor, mostrarlo
            if (json && !json.success && json.message) {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: json.message,
              });
            }
          }
          if (res.text) {
            const text = res.text;
            if (/</.test(text)) {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "Respuesta inesperada del servidor.",
              });
              document.open();
              document.write(text);
              document.close();
              return;
            }
          }
        })
        .catch(function (error) {
          console.error("Error en el envío:", error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error al procesar la solicitud",
          });
          return false;
        });
    });
  }

  window.initFormValidation = initFormValidation;
})(window);
