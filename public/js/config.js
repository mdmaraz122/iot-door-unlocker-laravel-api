function showLoader() {
    document.getElementById('loader').classList.remove('d-none')
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none')
}

// after loading website hide loader
window.onload = function() {
    hideLoader();
}

function successToast(msg) {
    document.getElementById('notifi').play();
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "green",
        }
    }).showToast();
}

function errorToast(msg) {
    document.getElementById('notifi').play();
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "red",
        }
    }).showToast();
}

// unauthorized
function unauthorized(){
    setTimeout(() => {
        window.location.href = "/secure-control";
    }, 2000);
}

function formatDate(dateString){
    const date = new Date(dateString);

    const day   = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year  = date.getFullYear();

    let hours = date.getHours();
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // 0 => 12
    hours = String(hours).padStart(2, '0');

    return `${day}-${month}-${year} | ${hours}:${minutes} ${ampm}`;
}
