{
    // Definir constantes
    const selectNivel = document.querySelector('#nivel');
    const campos = {
        nombre: '#nombre',
        descripcion: '#descripcion',
        nivel: '#nivel',
        cuota_mes: '#cuota_mes'
    };

    const niveles = {
        'S': 'Suave',
        'M': 'Moderado',
        'E': 'Exigente',
        'Q': 'Quemagrasas',
        'I': 'Ironman'
    };

    // Generar niveles
    const generarNiveles = () => {
        selectNivel.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Selecciona un nivel';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        selectNivel.appendChild(defaultOption);

        Object.entries(niveles).forEach(([value, text]) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = text;
            selectNivel.appendChild(option);
        });
    }

    generarNiveles();

    // Objeto para actividad
    let nuevaActividad = {
        nombre: '',
        descripcion: '',
        nivel: '',
        cuota_mes: ''
    };

    // Configurar listeners
    Object.entries(campos).forEach(([propiedad, selector]) => {
        const element = document.querySelector(selector);
        const eventType = selector === '#nivel' ? 'change' : 'input';

        element.addEventListener(eventType, (e) => {
            nuevaActividad[propiedad] = e.target.value;
        });
    });

    // Validación front End 
    const validarFormulario = () => {
        try {
            if (!nuevaActividad.nombre || !nuevaActividad.descripcion || !nuevaActividad.nivel) {
                throw new Error('Nombre, descripción y nivel son campos obligatorios');
            }

            if (typeof nuevaActividad.nombre !== 'string' || nuevaActividad.nombre.trim() === '') {
                throw new Error('El nombre debe ser un texto válido');
            }

            if (typeof nuevaActividad.descripcion !== 'string' || nuevaActividad.descripcion.trim() === '') {
                throw new Error('La descripción debe ser un texto válido');
            }

            if (!Object.keys(niveles).includes(nuevaActividad.nivel)) {
                throw new Error('El nivel seleccionado no es válido');
            }

            if (nuevaActividad.cuota_mes !== '') {
                const cuotaNumero = Number(nuevaActividad.cuota_mes);
                if (isNaN(cuotaNumero) || !Number.isInteger(cuotaNumero) || cuotaNumero <= 0) {
                    throw new Error('La cuota debe ser un número entero mayor que 0');
                }
                nuevaActividad.cuota_mes = cuotaNumero;
            } else {
                nuevaActividad.cuota_mes = '';
            }

            return true;
        } catch (error) {
            console.error('Error:', error.message);
            alert(error.message);
            return false;
        }
    };

    // Agregar actividad
    const agregarActividad = (e) => {
        try {
            e.preventDefault();
            fetch('http://dwes.es:8080/pr826/actividad', {
                method: 'POST',
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(nuevaActividad)
            })
            .then(response => {
                // if (!response.ok) throw new Error('Error en la respuesta del servidor');
                console.log(response);
                
                // return response.json();
            })
            .then(data => {
                const divRespuesta = document.getElementById('divRespuesta');
                divRespuesta.innerHTML = '';

                const tablaResumen = document.createElement('table');
                tablaResumen.className = 'tabla-resumen';

                const crearFila = (etiqueta, valor) => {
                    const tr = document.createElement('tr');
                    const th = document.createElement('th');
                    th.textContent = etiqueta;
                    tr.appendChild(th);
                    const td = document.createElement('td');
                    td.textContent = valor;
                    tr.appendChild(td);
                    return tr;
                };

                tablaResumen.appendChild(crearFila('Nombre:', nuevaActividad.nombre));
                tablaResumen.appendChild(crearFila('Descripción:', nuevaActividad.descripcion));
                tablaResumen.appendChild(crearFila('Nivel:', niveles[nuevaActividad.nivel]));
                tablaResumen.appendChild(crearFila('Cuota mensual:', nuevaActividad.cuota_mes));

                divRespuesta.appendChild(tablaResumen);

                // Limpiar formulario
                document.querySelector('#nombre').value = '';
                document.querySelector('#descripcion').value = '';
                document.querySelector('#nivel').value = '';
                document.querySelector('#cuota_mes').value = '';

                // Resetear objeto
                nuevaActividad = {
                    nombre: '',
                    descripcion: '',
                    nivel: '',
                    cuota_mes: ''
                };

                alert('Actividad creada exitosamente!');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('divRespuesta').innerHTML = 
                    `<p class="error">Error: ${error.message}</p>`;
            });
        } catch (error) {
            console.error('Error en agregarActividad:', error);
            alert('Error inesperado: ' + error.message);
        }
    }

    // Event listener
    document.querySelector('#operacion').addEventListener('click', (e) => {
        if (validarFormulario()) {
            agregarActividad(e);
        }
    });
}