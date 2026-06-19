// Código JavaScript del proyecto DWEC: eventos, Date, DOM, validaciones, JQuery, slideshow y AJAX.
document.addEventListener('DOMContentLoaded', function () {
    const fecha = new Date();
    const fechaFooter = document.getElementById('fechaActual');
    if (fechaFooter) {
        fechaFooter.textContent = 'Fecha actual: ' + fecha.toLocaleDateString('es-ES');
    }

    const info = document.getElementById('infoNavegador');
    if (info) {
        info.textContent = 'Navegador: ' + navigator.userAgent.substring(0, 60) + '... | Pantalla: ' + screen.width + 'x' + screen.height;
    }

    document.querySelectorAll('.btnComprar').forEach(function (boton) {
    boton.addEventListener('click', function () {
        const nombre = this.dataset.nombre;
        this.textContent = 'Añadiendo...';
    });
});

    validarFormulario('formRegistro');
    validarFormulario('formLogin');
    validarFormulario('formProducto');

    const contacto = document.getElementById('formContacto');
    if (contacto) {
        contacto.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('contactoEmail').value;
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(email)) {
                mostrarMensaje('mensajeContacto', 'El email no es válido', 'error');
                return;
            }
            mostrarMensaje('mensajeContacto', 'Mensaje enviado correctamente (simulado).', 'ok');
            contacto.reset();
        });
    }
});

function validarFormulario(id) {
    const form = document.getElementById(id);
    if (!form) return;
    form.addEventListener('submit', function (e) {
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        let correcto = true;
        inputs.forEach(function (input) {
            if (input.value.trim() === '') {
                correcto = false;
                input.classList.add('campo-error');
            } else {
                input.classList.remove('campo-error');
            }
        });
        const email = form.querySelector('input[type="email"]');
        if (email) {
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(email.value)) correcto = false;
        }
        if (!correcto) {
            e.preventDefault();
            alert('Revisa los campos del formulario.');
        }
    });
}

function mostrarMensaje(id, texto, clase) {
    const caja = document.getElementById(id);
    if (caja) caja.innerHTML = '<p class="' + clase + '">' + texto + '</p>';
}

$(document).ready(function () {
    $('#menuMovil').on('click', function () {
        $('#menuPrincipal').slideToggle();
    });

    $('.bot-card').hide().fadeIn(800);

    $('#cargarAjax').on('click', function () {
        $('#resultadoAjax').load('ajax/ofertas.php').hide().fadeIn(500);
    });

    let indice = 0;
    setInterval(function () {
        const slides = $('.slide');
        if (slides.length === 0) return;
        slides.eq(indice).fadeOut(500).removeClass('activa-slide');
        indice = (indice + 1) % slides.length;
        slides.eq(indice).fadeIn(500).addClass('activa-slide');
    }, 2500);
});
