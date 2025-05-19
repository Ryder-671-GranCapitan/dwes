function mostrar() {
    const param = new FormData();

    if (this.id == "first") {
        param.append("perro", "111A");
    } else {
        param.append("perro", "");
    }

    fetch("php/mostrar.php", {
        method: "POST",
        body: param,
    })
        .then((response) => {
            if (response.status === 200) {
                return response.json();
            } else {
                console.log(response);
                throw new Error("Error en la comunicación");
            }
        })
        .then((data) => {
            let info = document.querySelector("tbody");
            info.innerHTML = "";
            console.log(data);

            // Asegurar que data es un objeto y contiene la propiedad 'data'
            if (data && Array.isArray(data.data)) {
                data.data.forEach((ele) => {
                    info.innerHTML += `<tr>
                        <td>${ele.chip}</td>
                        <td>${ele.nombre}</td>
                        <td>${ele.raza}</td>
                        <td>${ele.fechaNac}</td>
                    </tr>`;
                });
            } else {
                console.error("La respuesta del servidor no tiene el formato esperado", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

document.getElementById("first").addEventListener("click", mostrar);
document.getElementById("all").addEventListener("click", mostrar);
