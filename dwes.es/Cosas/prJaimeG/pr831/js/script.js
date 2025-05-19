{
    const datosFormulario = document.querySelectorAll("input, select, button");

    let objetoAlumno = {
        nif: '',
        nombre: '',
        apellidos: '',
        fecha_nacimiento: '',
        curso: '',
        grupo: ''
    }

    datosFormulario.forEach(elemento => {
        if (elemento.id == "dni"){
            elemento.addEventListener('blur', (e) => agregaDni(e))
        }else if (elemento.id == "nombre"){
            elemento.addEventListener('blur', (e) => agregarNombre(e))
        }else if (elemento.id == "apellidos"){
            elemento.addEventListener('blur', (e) => agregarApellidos(e))
        }else if(elemento.id == "fecha_nacimiento"){
            elemento.addEventListener('change', (e) => agregarFecha(e))
        }else if (elemento.id == "curso"){
            elemento.addEventListener('change', (e) => agregarCurso(e))
        }else if(elemento.id == "grupo"){
            elemento.addEventListener("change", (e) => agregaGrupo(e))
        }else if (elemento.id == "mandarPeticion"){
            elemento.addEventListener("click", (e) => agregarPeticion(e));
        }
    })

    function agregaDni(e){
        const regexp = new RegExp('^[0-9]{8}[aA-Zz]$');
        if (regexp.test(e.target.value)){
            objetoAlumno.nif = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.nif = '';
            console.log(e.target.value);
        }
    }

    function agregarNombre(e){
        if (e.target.value != ''){
            objetoAlumno.nombre = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.nombre = '';
        }
    }

    function agregarApellidos(e){
        if (e.target.value != ''){
            objetoAlumno.apellidos = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.apellidos = '';
        }
    }

    function agregarFecha(e){
        if (e.target.value != ''){
            objetoAlumno.fecha_nacimiento = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.fecha_nacimiento = '';
        }
    }

    function agregarCurso(e){
        if (e.target.value != ''){
            objetoAlumno.curso = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.curso = '';
        }
    }

    function agregaGrupo(e){
        if (e.target.value != ''){
            objetoAlumno.grupo = e.target.value;
            console.log(e.target.value);
        }else {
            objetoAlumno.grupo = '';
        }
    }

    function agregarPeticion(e){
        e.preventDefault();
        fetch('http://dwes.es:8080/pr831/alumnos', {
            method: 'POST',
            headers: {Accept: "application/json"},
            body: JSON.stringify(
                objetoAlumno
            )
        })
        .then(response => {
            if (response.ok){
                return response.json();
            }
        }
        )
        .then(data => {

            if (objetoAlumno.nif != '' && objetoAlumno.nombre != '' && objetoAlumno.apellidos != '' && objetoAlumno.fecha_nacimiento != '' && objetoAlumno.curso != '' && objetoAlumno.grupo != ''){
                if (document.getElementById('tabla') == null){
                    const muestraDatos = document.getElementById('tabla-datos-introducidos');
                    const table = document.createElement('table');
                    table.id = "tabla";
                    const thead = document.createElement('thead');
                    const tr = document.createElement('tr');
                    const th = document.createElement('th');
                    th.textContent = 'dni';
                    const th2 = document.createElement('th');
                    th2.textContent = 'nombre';
                    const th3 = document.createElement('th');
                    th3.textContent = 'apellidos';
                    const th4 = document.createElement('th');
                    th4.textContent = 'fecha_nacimiento';
                    const th5 = document.createElement('th');
                    th5.textContent = 'curso';
                    const th6 = document.createElement('th');
                    th6.textContent = 'grupo';
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
                    td.textContent = objetoAlumno.nif;
                    const td2 = document.createElement('td');
                    td2.textContent = objetoAlumno.nombre;
                    const td3 = document.createElement('td');
                    td3.textContent = objetoAlumno.apellidos;
                    const td4 = document.createElement('td');
                    td4.textContent = objetoAlumno.fecha_nacimiento;
                    const td5 = document.createElement('td');
                    td5.textContent = objetoAlumno.curso;
                    const td6 = document.createElement('td');
                    td6.textContent = objetoAlumno.grupo;
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
                    td.textContent = objetoAlumno.nif;
                    const td2 = document.createElement('td');
                    td2.textContent = objetoAlumno.nombre;
                    const td3 = document.createElement('td');
                    td3.textContent = objetoAlumno.apellidos;
                    const td4 = document.createElement('td');
                    td4.textContent = objetoAlumno.fecha_nacimiento;
                    const td5 = document.createElement('td');
                    td5.textContent = objetoAlumno.curso;
                    const td6 = document.createElement('td');
                    td6.textContent = objetoAlumno.grupo;
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
            

            document.getElementById('dni').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('apellidos').value = '';
            document.getElementById('fecha_nacimiento').value = '';
            document.getElementById('curso').value = '';
            document.getElementById('grupo').value = '';

            objetoAlumno.nif = '';
            objetoAlumno.nombre = '';
            objetoAlumno.apellidos = '';
            objetoAlumno.fecha_nacimiento = '';
            objetoAlumno.curso = '';
            objetoAlumno.grupo = '';
            
        })
        .catch(error => {
            console.log(error);
            return error;
        })
    }
}