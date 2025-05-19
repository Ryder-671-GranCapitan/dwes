"use strict"
window.addEventListener("DOMContentLoaded", () => {
  mostrarProv();
})

const mostrarProv = () => {
  fetch("https://raw.githubusercontent.com/IagoLast/pselect/master/data/provincias.json")
    .then((response) => {
      if (response.status == 200) {
        return response.json();
      } else {
        throw ("Error en la comunicación")
      }
    })

    .then((data) => {
      //ordenar ascedente

      data.sort((a, b) => {
        return a.nm.localeCompare(b.nm)
      })
      //cargar en el select
      // $(data).each((ind, ele) => {
      //     $("#provincias").append("<option id=" + ele.id + ">" + ele.nm + "</option>")
      // })

      // Itera sobre cada elemento en el array 'data'
      data.forEach((ele) => {
        // Crea un nuevo elemento 'option' para el menú desplegable
        const option = document.createElement('option');
        // Asigna el id del elemento actual al atributo 'id' del 'option'
        option.id = ele.id;
        // Asigna el nombre del elemento actual al contenido de texto del 'option'
        option.textContent = ele.nm;
        // Añade el 'option' creado al elemento con id 'provincias' en el documento
        document.getElementById('provincias').appendChild(option);
      });

      //evento change
      // $("#provincias").on("change", function () {
      //     Swal.fire("El Id es " + $("#provincias option:selected").attr("id"))
      // })

      // Selecciona el elemento con el id 'provincias' y añade un evento 'change'
      document.getElementById('provincias').addEventListener('change', function () {
        // Obtiene la opción seleccionada del elemento 'provincias'
        const selectedOption = this.options[this.selectedIndex];
        // Muestra una alerta con el id de la opción seleccionada usando SweetAlert2
        Swal.fire("El Id es " + selectedOption.id);
      });
    })
    .catch((error) => {
      console.log(error);
    });

}
