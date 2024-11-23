// Funcionamiento del seleccionador de materiales
let temporalMaterials = [];

let checked = document.getElementsByClassName("checked");
let selectedM = [];
for (let i = 0; i < checked.length; i++) {
   selectedM.push(checked[i].id); // o .value, según lo que necesites
}
console.log(selectedM);


// Función que añade nuevos materiales temporalmente
function addM() {
   // Material introducido
   let newMaterial = document.getElementById("add-material-text").value;
   newMaterial = newMaterial.charAt(0).toUpperCase() + newMaterial.slice(1).toLowerCase();


   if (!isUnique(newMaterial)) {
      document.getElementById("material-error").textContent = "Ya existe ese material."
      return false;
   }
   if (newMaterial.length == 0) {
      return false;
   }
   if (!isNaN(parseFloat(newMaterial.trim()))) {
      document.getElementById("material-error").textContent = "Por favor, introduzca un material válido."
      return false;
   }
   else {
      document.getElementById("add-material-text").value = "";
      addMdom(newMaterial)
      return true;
   }
}
// Comprueba si el material ya existe en la base de datos o en la temporal
function isUnique(newMaterial) {
   let checkboxes = document.querySelectorAll('.material-checkbox');
   let materialNames = [];
   checkboxes.forEach(checkbox => {
      materialNames.push(checkbox.id);
   });

   let isUniqueFlag = true;
   materialNames.forEach(material => {
      if (material == newMaterial) {
         isUniqueFlag = false
      }
   });
   return isUniqueFlag;
}
// Creación del dom de los materiales
function addMdom(newMaterial) {
   // Guardamos el nuevo material para luego
   temporalMaterials.unshift(newMaterial);
   let materialId = newMaterial.toLowerCase();

   // Creamos el checkbox y el label
   let checkbox = document.createElement("input");
   checkbox.type = "checkbox"
   checkbox.id = materialId;
   checkbox.className = "material-checkbox";
   checkbox.checked = true;

   let label = document.createElement("label");
   label.htmlFor = newMaterial;
   label.textContent = newMaterial;

   // Creamos un div para el checkbox y el label
   let div = document.createElement("div");
   div.className = "material-checkbox-div";
   div.appendChild(checkbox)
   div.appendChild(label)

   // Añadimos el div del material al documento
   document.getElementById("temporalM").appendChild(div);

   // Le añadimos el listener al checkbox y activamos el evento
   listener(checkbox);
   // Creamos un evento "change"
   const event = new Event('change');
   // Disparamos el evento en el checkbox
   checkbox.dispatchEvent(event);
}



// Función que agrega el eventlistener
function listener(checkbox) {
   checkbox.addEventListener('change', function (event) {
      if (event.target.checked) {
         selectedM.push(event.target.id.replace('_',' '));
      }
      if (!event.target.checked) {
         // Elimina el material del array
         let i = selectedM.indexOf(event.target.id);
         selectedM.splice(i, 1);
         console.log(selectedM);
      }
   });
}

// Una vez que se cierra el modal, se envian los materiales nuevos para guardarlos en la base de datos
function saveMaterials() {
   if (temporalMaterials.length > 0) {
      const temporalM = { temporalMaterials: temporalMaterials };

      // Enviar los materiales temporales
      fetch('/materials/new', {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify(temporalM) // Convierte el objeto a JSON
      })
         .then(response => {
            if (!response.ok) {
               // Si la respuesta no es "ok", lanza un error
               throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
            }
            // limpia el array de materiales porque ya han sido guardados
            temporalMaterials = [];
            return response.json(); // Si la respuesta es correcta, convierte a JSON
         })
         .then(data => {
            console.log('Materiales guardados correctamente:', data);
         })
         .catch(error => {
            console.log(temporalMaterials);
            console.error('Hubo un problema con la solicitud:', error);
            alert('Hubo un problema al guardar los materiales. Por favor, inténtalo de nuevo.');
         });
   }

   // Si se ha seleccionado algún material, se añade al formulario de pieza
   if (selectedM.length > 0) {
      const selectedMaterials = JSON.stringify(selectedM);
      console.log(selectedMaterials);
      // Crear un input oculto para añadir los datos
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'selectedMaterials';  // El nombre con el que se recibirá en el controlador
      hiddenInput.value = selectedMaterials

      // Añadirlo al formulario
      const form = document.querySelector('#form');
      form.appendChild(hiddenInput);

      // Imprimirlo en el dom
      let domSM = document.getElementById("SMstr");
      domSM.value = ""
      domSM.value = format(selectedM);
   }
   document.getElementById("add-material-text").value = "";
}

function format(arr) {
   if (arr.length === 0) return "";

    // Eliminamos los guiones bajos y convertimos todos los elementos a minúsculas
    const formattedArray = arr.map(item =>
        item.replace(/_/g, " ").toLowerCase()
    );

    // Capitalizamos la primera letra del primer elemento
    formattedArray[0] = formattedArray[0][0].toUpperCase() + formattedArray[0].slice(1);

    // Si solo hay un elemento, lo devolvemos tal cual
    if (formattedArray.length === 1) return formattedArray[0];

    // Si hay dos elementos, los unimos con " y "
    if (formattedArray.length === 2) return formattedArray.join(" y ");

    // Para más de dos elementos, unimos todos excepto el último con ", " y el último con " y "
    const allButLast = formattedArray.slice(0, -1).join(", ");
    const last = formattedArray[formattedArray.length - 1];
    return `${allButLast} y ${last}`;
}

// Funcionamiento del modal de materiales
const checkboxes = document.querySelectorAll('.material-checkbox');
// Asignar un evento 'change' a cada checkbox
checkboxes.forEach(function (checkbox) {
   listener(checkbox);
});

// Funcionamiento de la vista de las imagenes
// document.getElementById('piece_Images').addEventListener('change', function (event) {
//    const files = event.target.files;
//    const imageContainer = document.getElementById('modalimages');

//    if (files) {
//       for (let i = 0; i < files.length; i++) {
//          const file = files[i];
//          if (file.type.match('image.*')) {
//             const reader = new FileReader();
//             reader.onload = function (e) {
//                const imageElement = document.createElement('img');
//                imageElement.style.maxHeight = '150px';
//                imageElement.src = e.target.result;
//                imageContainer.appendChild(imageElement);
//             };
//             reader.readAsDataURL(file);
//          }
//       }
//    }
// });

// document.getElementById("imageModalAcceptBtn").addEventListener("click", function() {
//    // Encuentra el formulario (el que tiene id 'form')
//    var form = document.getElementById("form");

//    // Envía el formulario
//    form.submit();
// });