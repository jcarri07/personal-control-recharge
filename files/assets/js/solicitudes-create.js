console.log("Hola");
const tiposol = document.getElementById('tipo_sol');

// console.log(tiposol);
        
tiposol.addEventListener("change", (event) => {
            console.log('otro eje')
            var cod = document.getElementById("tipo_sol").value;

            if (cod == "Reposo") {
                div = document.getElementById('form_reposo');
                div.style.display = '';
                div = document.getElementById('form_vacaciones');
                div.style.display = 'none';
            //  alert(cod);
            }
    
            if (cod == "Constancia") {
                div = document.getElementById('form_reposo');
                div.style.display = 'none';
                div = document.getElementById('form_vacaciones');
                div.style.display = 'none';
            }

            if (cod == "Vacaciones") {
                div = document.getElementById('form_reposo');
                div.style.display = 'none';
                div = document.getElementById('form_vacaciones');
                div.style.display = '';
            }
                
});


