function modal() {
    const elModal = document.getElementById("modal");
    const elButtonCloseModal = document.getElementById("button-close-modal");
    const elButtonSubmitLangganan = document.getElementById("button-submit-langganan");
    const elButtonShowModal = document.getElementById("button-show-modal");

    function showModal() {
        elModal.style.display = "flex";
    }

    function hideModal() {
        elModal.style.display = "none";
    }

    function showNotificationPopUp() {
        const interval = 1000;
        const popUp = document.createElement("div");
        popUp.classList.add("pop-up");
        popUp.textContent = "Selamat kamu telah berlangganan di KoKode 😎";

        document.body.appendChild(popUp);

        const intervalId = setInterval(function () {
            popUp.remove();
            clearInterval(intervalId);
        }, interval);
    }

    elButtonShowModal.onclick = function (e) {
        e.preventDefault();
        showModal();
    }

    elButtonSubmitLangganan.onclick = function (e) {
        e.preventDefault();
        hideModal();
        showNotificationPopUp();
    }


    elButtonCloseModal.onclick = function () {
        console.log("closing the modal");
        hideModal();
    }
}