const csvUploadForm = document.querySelector('#csv-upload-form');
const csvFileInput = document.querySelector('#fileInput');
const errorInput = document.querySelector('#hasError');
const divMessageError = document.querySelector('.invalid-feedback');
let submitButton = document.querySelector('#submitButton');
submitButton.disabled = true;
let btnTxt = document.querySelector("#btn-txt");
let btnSpin = document.querySelector("#btn-spin");


csvFileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const fileSize = file.size / 1024 / 1024; // Convertir a MB
    let hasError = false;
    let errorMessages = "";
    btnTxt.textContent = "Cargando y validando...";
    btnSpin.classList.remove('d-none');

    if (!file.name.endsWith('.csv')) {
        //alert('El archivo debe ser un CSV');
        errorMessages += "El archivo debe ser un CSV\n";
        hasError = true;
        csvFileInput.value = '';
    }
    if (fileSize < 150 || fileSize > 250) {
        //alert('El archivo no debe pesar entre 150MB y 225MB');
        errorMessages += "El archivo debe pesar entre 150MB y 250MB\n";
        hasError = true;
        csvFileInput.value = '';
    }

    // Validar número de columnas del archivo
    const maxColumns = 12; // Número máximo de columnas permitido
    const fileReader = new FileReader();
    fileReader.onload = function () {
        let contents = fileReader.result;
        contents = contents.replace(/,\s*$/, '');
        const lines = contents.split('\n');
        const numColumns = lines[0].split(',').length;
        if (numColumns != maxColumns) {
            errorMessages += "El archivo debe contener " + maxColumns + " columnas\n";
            console.log("Numero columnas: " + numColumns);
            hasError = true;
            csvFileInput.value = '';
        }
        // Si no hay errores, quitar la clase 'is-invalid' del div
        if (!hasError) {
            divMessageError.innerText = '';
            errorInput.classList.remove('is-invalid');
            submitButton.disabled = false;
            btnTxt.textContent = "Procesar";
            btnSpin.classList.add('d-none');
        } else {
            divMessageError.innerText = errorMessages.trim();
            errorInput.classList.add('is-invalid')
            csvFileInput.value = '';
            submitButton.disabled = true;
            btnTxt.textContent = "Cargar";
            btnSpin.classList.add('d-none');
        }
    }
    fileReader.readAsText(file);
});
submitButton.addEventListener('click', (event) => {
    btnTxt.textContent = "Procesando";
    divMessageError.innerText = "Este proceso puede demorar muchos minutos...";
    errorInput.classList.add('is-invalid')
    submitButton.disabled = true;
    btnSpin.classList.remove('d-none');
});