function showToast(message) {
    var toastEl = document.getElementById('cart-toast');
    var toast = new bootstrap.Toast(toastEl);

    // Cambiar el mensaje del toast
    var toastBody = toastEl.querySelector('.toast-body');
    toastBody.textContent = message;

    // Mostrar el toast
    toast.show();
}