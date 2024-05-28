function index() {
    let isOpen = false;

    function frist() {
        const modalElement = document.createElement("div");
        modalElement.classList.add("big-modal");

        const buttonElement = document.createElement("button");
        buttonElement.textContent = "Masuk Dunia Kopi Dan Kode 🍵";

        modalElement.append(buttonElement);
        window.document.body.append(modalElement);

        buttonElement.addEventListener('click', () => {
            modalElement.removeEventListener('click', modalElement);
            buttonElement.removeEventListener('click', buttonElement);

            modalElement.remove();
            buttonElement.remove();

        });
    }

    frist();

    let indexGambarSekarang = 0;
    let generatePlaceholderStatus = false;
    let daftarGambar = [
        "./images/carousel_1.png",
        "./images/carousel_2.png",
        "./images/carousel_3.png",
    ];

    const intervalGanti = 2000; // dalam ms
    const carouselImageDom = document.getElementById("carousel-image");
    const carouselStatusDom = document.getElementById("carousel-status");

    function updateCaruouselStatus() {
        if (!generatePlaceholderStatus) {
            for (let i = 0; i < daftarGambar.length; ++i) {
                const divStatus = document.createElement("div");
                divStatus.classList.add("carousel__state");
                if (i == indexGambarSekarang) {
                    divStatus.classList.add("carousel__state--active");
                }
                carouselStatusDom.append(divStatus);
            }

            generatePlaceholderStatus = true;
        } else {
            const status = carouselStatusDom.children;
            let index = 0;
            for (const node of status) {
                if (index != indexGambarSekarang) {
                    node.classList.remove("carousel__state--active");
                } else {
                    node.classList.add("carousel__state--active");
                }
                index++;
            }
        }
    }

    updateCaruouselStatus();

    carouselImageDom.onload = () => {
        bookFlipSound.play();

        indexGambarSekarang++;
        if (indexGambarSekarang >= daftarGambar.length) {
            indexGambarSekarang = 0;
        }
    }

    function gantiGambar() {
        const gambarSekarang = daftarGambar[indexGambarSekarang];
        carouselImageDom.src = gambarSekarang;

        updateCaruouselStatus();
    }

    let intervalId = setInterval(gantiGambar, intervalGanti);

    const bookFlipSound = document.createElement("audio");
    bookFlipSound.src = "./sounds/card_hover.wav";
    carouselImageDom.onmouseover = () => {
        if (intervalId != undefined) {
            clearInterval(intervalId);
            intervalId = undefined;
        }
    }

    carouselImageDom.onmouseout = () => {
        if (intervalId == undefined) {
            intervalId = setInterval(gantiGambar, intervalGanti);
        }
    }

    // mainkan suara jika ada event click pada links dan button
    const clickSound = document.createElement("audio");
    clickSound.src = "./sounds/click.wav";

    const buttons = document.getElementsByTagName("button");
    const anchors = document.getElementsByTagName("a");

    for (const b of buttons) {
        b.onclick = (e) => {
            e.preventDefault();
            clickSound.play();
        }
    }

    for (const a of anchors) {
        a.onclick = (e) => {
            clickSound.play();
        }
    }
}