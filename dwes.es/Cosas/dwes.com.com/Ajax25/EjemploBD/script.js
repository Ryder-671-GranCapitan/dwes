"use strict"
function mostrar() {
    const param=new FormData();

    if (this.id == "first"){
        param.append("perro", "111A")
    }else{
        param.append("perro", "");
    }   
    
    
    fetch("php/mostrar.php",{
        method:'GET',
        body: param 
    })
    .then((response) =>{
        if (response.status==200){
            return response.json();
         }else{
            throw ("Error en la comunicación")
         }
    }) 
    .then((data) => {
        let info = document.querySelector("tbody");
        info.innerHTML = "";
       console.log(data);
       data.forEach(ele => {
            info.innerHTML += `<tr><td>${ele.chip}</td><td>${ele.nombre}</td><td>${ele.raza}</td><td>${ele.fechaNac}</td></tr>`;
       });
     })
     .catch((error) => {
       console.log(error);
     });
}

document.getElementById("first").addEventListener("click", mostrar);
document.getElementById("all").addEventListener("click", mostrar);