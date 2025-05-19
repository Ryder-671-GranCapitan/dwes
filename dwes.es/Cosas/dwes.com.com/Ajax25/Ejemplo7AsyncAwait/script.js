"use strict"
window.addEventListener("DOMContentLoaded", ()=>{
    mostrarProv();
})

const mostrarProv=async() =>{
    try{
        const response= await fetch("https://raw.githubusercontent.com/IagoLast/pselect/master/data/provincias.json")
        const data=await response.json();
        data.sort((a, b) => {
            return a.nm.localeCompare(b.nm)
        })
        //cargar en el select
        // $(data).each((ind, ele) => {
        //     $("#provincias").append("<option id=" + ele.id + ">" + ele.nm + "</option>")
        // })

        // Iterar sobre cada elemento en el array de datos
        data.forEach((ele) => {
            // Crear un nuevo elemento option
            const option = document.createElement('option');
            // Establecer el id del elemento option al id del dato
            option.id = ele.id;
            // Establecer el contenido de texto del elemento option al nombre del dato
            option.textContent = ele.nm;
            // Añadir el elemento option al elemento select con id 'provincias'
            document.getElementById('provincias').appendChild(option);
        });

        //evento change
        // $("#provincias").on("change", function () {
        //     Swal.fire("El Id es " + $("#provincias option:selected").attr("id"))
        // })

        // Selecciona el elemento con el id 'provincias' y añade un evento 'change'.
        // Este evento se dispara cada vez que se selecciona una opción diferente en el elemento.
        document.getElementById('provincias').addEventListener('change', function () {
        // Obtiene la opción seleccionada actualmente en el elemento 'provincias'.
        const selectedOption = this.options[this.selectedIndex];
        // Muestra una alerta utilizando SweetAlert2 con el id de la opción seleccionada.
        Swal.fire("El Id es " + selectedOption.id);
        });        
    }catch(error){
        console.error(error);
    };
}
