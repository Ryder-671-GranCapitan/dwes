{

    let objetoDevolucion = {
        id_fe: '',
        descripcion: '',
        telefono: '',
        contacto: '',
        email: '',
        coste: ''
    }

    const valoresFormulario = document.querySelectorAll('input, button');

    valoresFormulario.forEach(elemento=>{
        if(elemento.id == 'id_fe') {
            elemento.addEventListener('blur', (e) => agregaId(e));
        }

        if(elemento.id == 'descripcion') {
            elemento.addEventListener('blur', (e) => agregaDescripcion(e));
        }

        if(elemento.id == 'telefono') {
            elemento.addEventListener('blur', (e) => agregaTelefono(e));
        }

        if(elemento.id == 'contacto') {
            elemento.addEventListener('blur', (e) => agregaContacto(e));
        }

        if(elemento.id == 'email') {
            elemento.addEventListener('blur', (e) => agregaEmail(e));
        }

        if(elemento.id == 'coste') {
            elemento.addEventListener('blur', (e) => agregaCoste(e));
        }

        if(elemento.id == 'operacion') {
            elemento.addEventListener('click', (e) => agregaPeticion(e));
        }
    });

    function agregaId(e) {
        const id = e.target.value;
        objetoDevolucion.id_fe = id;
    }

    function agregaDescripcion(e) {
        const descripcion = e.target.value;
        objetoDevolucion.descripcion = descripcion;
    }

    function agregaTelefono(e) {
        const telefono = e.target.value;
        objetoDevolucion.telefono = telefono;
    }

    function agregaContacto(e) {
        const contacto = e.target.value;
        objetoDevolucion.contacto = contacto;
    }

    function agregaEmail(e) {
        const email = e.target.value;
        objetoDevolucion.email = email;
    }

    function agregaCoste(e) {
        const coste = e.target.value;
        objetoDevolucion.coste = coste;
    }

    function agregaPeticion(e) {
        e.preventDefault();
        fetch('http://dwes.es:8080/pr807/forma_envio', {
            method: 'POST',
            headers: {
                Accept : 'application/json'
            },
            body: JSON.stringify(objetoDevolucion)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (objetoDevolucion.id_fe != '' && objetoDevolucion.descripcion != '' && objetoDevolucion.telefono != '' && objetoDevolucion.contacto != '' && objetoDevolucion.email != '' && objetoDevolucion.coste != ''){
                if (document.getElementById('tabla') == null){
                    const muestraDatos = document.getElementById('respuesta');
                    const table = document.createElement('table');
                    table.id = "tabla";
                    const thead = document.createElement('thead');
                    const tr = document.createElement('tr');
                    const th = document.createElement('th');
                    th.textContent = 'ID_FE';
                    const th2 = document.createElement('th');
                    th2.textContent = 'Descripcion';
                    const th3 = document.createElement('th');
                    th3.textContent = 'Telefono';
                    const th4 = document.createElement('th');
                    th4.textContent = 'Contacto';
                    const th5 = document.createElement('th');
                    th5.textContent = 'Email';
                    const th6 = document.createElement('th');
                    th6.textContent = 'Coste';
                    tr.appendChild(th);
                    tr.appendChild(th2);
                    tr.appendChild(th3);
                    tr.appendChild(th4);
                    tr.appendChild(th5);
                    tr.appendChild(th6);
                    thead.appendChild(tr);
                    const tbody = document.createElement('tbody');
                    const tr2 = document.createElement('tr');
                    const td = document.createElement('td');
                    td.textContent = objetoDevolucion.id_fe;
                    const td2 = document.createElement('td');
                    td2.textContent = objetoDevolucion.descripcion;
                    const td3 = document.createElement('td');
                    td3.textContent = objetoDevolucion.telefono;
                    const td4 = document.createElement('td');
                    td4.textContent = objetoDevolucion.contacto;
                    const td5 = document.createElement('td');
                    td5.textContent = objetoDevolucion.email;
                    const td6 = document.createElement('td');
                    td6.textContent = objetoDevolucion.coste;
                    tr2.appendChild(td);
                    tr2.appendChild(td2);
                    tr2.appendChild(td3);
                    tr2.appendChild(td4);
                    tr2.appendChild(td5);
                    tr2.appendChild(td6);
                    tbody.appendChild(tr2);
                    table.appendChild(thead);
                    table.appendChild(tbody);
                    muestraDatos.appendChild(table);
                }else {
                    const table = document.querySelector('tbody');
                    const tr2 = document.createElement('tr');
                    const td = document.createElement('td');
                    td.textContent = objetoDevolucion.id_fe;
                    td.setAttribute('data-label', 'ID');

                    const td2 = document.createElement('td');
                    td2.textContent = objetoDevolucion.descripcion;
                    td2.setAttribute('data-label', 'Descripción');

                    const td3 = document.createElement('td');
                    td3.textContent = objetoDevolucion.telefono;
                    td3.setAttribute('data-label', 'Teléfono');

                    const td4 = document.createElement('td');
                    td4.textContent = objetoDevolucion.contacto;
                    td4.setAttribute('data-label', 'Contacto');

                    const td5 = document.createElement('td');
                    td5.textContent = objetoDevolucion.email;
                    td5.setAttribute('data-label', 'Email');

                    const td6 = document.createElement('td');
                    td6.textContent = objetoDevolucion.coste;
                    td6.setAttribute('data-label', 'Coste');
                    tr2.appendChild(td);
                    tr2.appendChild(td2);
                    tr2.appendChild(td3);
                    tr2.appendChild(td4);
                    tr2.appendChild(td5);
                    tr2.appendChild(td6);
                    table.appendChild(tr2);
                }
            }else {
                console.log('Faltan datos');
            }
        }).catch((error) => {
            console.error('Error:', error);
        });
    }

}