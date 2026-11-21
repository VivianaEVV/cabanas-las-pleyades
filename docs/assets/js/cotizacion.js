/**
 * Las Pleyades: formulario de cotizacion.
 * Archivo solo en ASCII (los acentos van como \uXXXX) para que no se
 * danen al descargarlo o copiarlo.
 * Valida los datos y abre WhatsApp con el mensaje armado.
 * No envia ni guarda nada en ningun servidor.
 */
(() => {
    'use strict';

    const form = document.querySelector('[data-quote-form]');
    if (!form) {
        return;
    }

    const phone = (form.dataset.whatsapp || '').replace(/\D/g, '');
    const nameInput = form.querySelector('#q-nombre');
    const nameError = form.querySelector('#q-nombre-error');
    const arrival = form.querySelector('#q-llegada');
    const departure = form.querySelector('#q-salida');
    const datesError = form.querySelector('#q-fechas-error');
    const nightsOut = form.querySelector('[data-quote-nights]');

    // ---------- Fechas ----------
    const toISO = (date) => {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    };

    const parseISO = (value) => {
        const [y, m, d] = value.split('-').map(Number);
        return new Date(y, m - 1, d);
    };

    const formatDate = (value) =>
        parseISO(value).toLocaleDateString('es-CL', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });

    const nights = () => {
        if (!arrival.value || !departure.value) {
            return 0;
        }
        return Math.round((parseISO(departure.value) - parseISO(arrival.value)) / 86400000);
    };

    // No se puede elegir una fecha pasada.
    const today = toISO(new Date());
    arrival.min = today;
    departure.min = today;

    function updateDates() {
        if (arrival.value) {
            const next = parseISO(arrival.value);
            next.setDate(next.getDate() + 1);
            departure.min = toISO(next);

            // Si la salida quedo antes de la llegada, se limpia.
            if (departure.value && departure.value <= arrival.value) {
                departure.value = '';
            }
        }

        const n = nights();
        nightsOut.textContent = n > 0 ? `${n} ${n === 1 ? 'noche' : 'noches'}` : '';
        if (n > 0) {
            showError(datesError, null, [arrival, departure]);
        }
    }

    arrival.addEventListener('change', updateDates);
    departure.addEventListener('change', updateDates);

    // ---------- Errores ----------
    function showError(element, message, inputs) {
        const hasError = Boolean(message);
        element.hidden = !hasError;
        if (hasError) {
            element.textContent = message;
        }
        inputs.forEach((input) => {
            input.setAttribute('aria-invalid', String(hasError));
            if (hasError) {
                input.setAttribute('aria-describedby', element.id);
            } else {
                input.removeAttribute('aria-describedby');
            }
        });
    }

    nameInput.addEventListener('input', () => {
        if (nameInput.value.trim()) {
            showError(nameError, null, [nameInput]);
        }
    });

    function validate() {
        let firstInvalid = null;

        if (!nameInput.value.trim()) {
            showError(nameError, 'Escribe tu nombre.', [nameInput]);
            firstInvalid = nameInput;
        }

        if (!arrival.value || !departure.value) {
            showError(datesError, 'Elige la fecha de llegada y de salida.', [arrival, departure]);
            firstInvalid = firstInvalid || (!arrival.value ? arrival : departure);
        } else if (arrival.value < today) {
            showError(datesError, 'La fecha de llegada ya pas\u00f3.', [arrival, departure]);
            firstInvalid = firstInvalid || arrival;
        } else if (nights() < 1) {
            showError(datesError, 'La salida debe ser al menos un d\u00eda despu\u00e9s de la llegada.', [arrival, departure]);
            firstInvalid = firstInvalid || departure;
        }

        if (firstInvalid) {
            firstInvalid.focus();
            return false;
        }
        return true;
    }

    // ---------- Envio ----------
    // Limpia el texto: sin saltos de linea extra ni caracteres de control.
    const clean = (value, max) =>
        value.replace(/[\u0000-\u0009\u000B-\u001F\u007F]/g, '').replace(/\n{3,}/g, '\n\n').trim().slice(0, max);

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!validate() || !phone) {
            return;
        }

        const data = new FormData(form);
        const n = nights();
        const comment = clean(String(data.get('comentario') || ''), 500);

        const lines = [
            'Hola, quisiera cotizar una estad\u00eda en Caba\u00f1as Las Pleyades:',
            '',
            `*Nombre:* ${clean(String(data.get('nombre')), 60)}`,
            `*Caba\u00f1a:* ${data.get('cabana')}`,
            `*Llegada:* ${formatDate(arrival.value)}`,
            `*Salida:* ${formatDate(departure.value)} (${n} ${n === 1 ? 'noche' : 'noches'})`,
            `*Personas:* ${data.get('personas')}`,
        ];

        if (comment) {
            lines.push('', `*Comentario:* ${comment}`);
        }

        const url = `https://wa.me/${phone}?text=${encodeURIComponent(lines.join('\n'))}`;

        // Si el navegador bloquea la ventana nueva, se abre en la misma pestana.
        // (con 'noopener' window.open siempre devuelve null, por eso se corta a mano).
        const opened = window.open(url, '_blank');
        if (opened) {
            opened.opener = null;
        } else {
            window.location.href = url;
        }
    });
})();