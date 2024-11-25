const selectCarteraInput = document.querySelector('#cartera');
const errorInput = document.querySelector('#hasError');
const divMessageError = document.querySelector('.invalid-feedback');
let submitButton = document.querySelector('#submitButton');
submitButton.disabled = false;
let btnTxt = document.querySelector("#btn-txt");
let btnSpin = document.querySelector("#btn-spin");

submitButton.addEventListener('click', (event) => {
    //btnTxt.textContent = "Cruzando datos";
    divMessageError.innerText = "Nota: Este proceso puede demorar muchos minutos...";
    errorInput.classList.add('is-invalid')
    //submitButton.disabled = true;
    //btnSpin.classList.remove('d-none');
});