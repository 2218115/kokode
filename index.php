<?php
    session_start();

    include './db_connection.php';
    include './base.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KoKode</title>

    <link rel="stylesheet" href="./styles/base.css">
    <link rel="stylesheet" href="./styles/home.css">
    <script defer src="./scripts/index.js"></script>
    <script defer src="./scripts/modal.js"></script>
    <script defer src="./scripts/articles_api.js"></script>
    <script defer src="./scripts/base.js"></script>
</head>

<body>
    <div class="modal-container" id="modal">
        <div class="modal card">
            <div class="modal__btn-close" id="button-close-modal">x</div>
            <form action="">
                <div class="form__group">
                    <h1>Berlangganan ke dalam KoKode</h1>
                </div>
                <div class="form__group">
                    <label for="email">Masukkan Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan Email" class="input">
                </div>
                <div class="form__group">
                    <label for="email">Pilih kategori konten</label>
                    <select name="kategori" id="" class="input">
                        <option class="input" value="" selected>Semua Kategori</option>
                        <option class="input" value="">Koding Santai</option>
                        <option class="input" value="">Info Kopi</option>
                        <option class="input" value="">Programmer dan Kopi</option>
                    </select>
                </div>
                <div class="form__group">
                    <button class="button button--primary" id="button-submit-langganan">Berlangganan</button>
                </div>
            </form>
        </div>
    </div>

    <header class="container header">
        <div>
            <a href="/">
                <h1 class="header__title">Kopi Kode</h1>
            </a>
        </div>
        <nav class="header__nav">
            <ul class="header__links">
                <li>
                    <a href="#langganan" class="link">Langganan</a>
                </li>
                <li>
                    <a href="#tentang">Tentang</a>
                </li>
                    <?php
                        if (isset($_SESSION["email"]) && isset($_SESSION["userId"])) {
                            $loggedEmail = $_SESSION["email"];
                            echo "<li><p> <b>{$loggedEmail} </b></p></li>";
                            echo '<li><form action="auth_process.php" method="post"> <input type="submit" name="logout" value="keluar" class="button"></form></li>';
                        } else {
                            echo '<li><a href="login.php" class="button">Masuk</a></li>';
                        }
                    ?>
            </ul>
        </nav>
    </header>

    <main class="container main">


        <div class="carousel">
            <img src="./images/carousel_1.png" id="carousel-image" alt="carousel image" class="carousel__image">
            <div class="carousel__shadow"></div>
        </div>

        <div id="carousel-status">
        </div>

        <div class="articles">
            <h2>Artikel Terbaru</h2>
            <ul class="list-articles">                
                <?php 
                $statement = $conn->prepare("SELECT ar.id as 'id', au.email as 'author_email', c.name as 'category', ar.title as 'title', ar.content as 'content' FROM tb_artikel as ar INNER JOIN tb_pengguna as au ON au.id = ar.id_pengguna INNER JOIN tb_kategori as c ON c.id = ar.id_category");
                $statement->execute();
                $result = $statement->get_result();
                $articles = $result->fetch_all(MYSQLI_ASSOC);
                
                foreach ($articles as $article) {
                    echo '<li class="list-articles__item">
                            <h3>'. $article["title"] .'</h3>
                            <p> Oleh: ' . $article["author_email"] . ' </p>
                            <p> Kategori: ' . $article["category"] . ' </p> 
                            <p>' . cutSentence($article["content"], 200) .' </p>
                            <a href="kemana gitu">Baca lebih lanjut.</a>
                        </li>';
                    }
                    ?>
            </ul>
        </div>


        <div class="divider"></div>


        <article class="main__article">
            <aside class="main__aside">
                <h2>Info Kopi🍵</h2>
                <div class="card">
                    <h3 class="card__title">Kopi Jawa</h3>
                    <div class="card__content">
                        <img src=" ./images/kopi_jawa.jpg" alt="gambar kopi jawa" class="card__image">
                        <p>Kopi jawa (Java coffee) adalah kopi yang berasal dari Pulau Jawa di Indonesia. Kopi ini
                            sangatlah terkenal sehingga nama Jawa menjadi nama identitas untuk kopi. Kopi Jawa
                            Indonesia
                            tidak memiliki bentuk yang sama dengan kopi asal Sumatra dan Sulawesi, cita rasa juga
                            tidak
                            terlalu kaya sebagaimana kopi dari Sumatra atau Sulawesi karena sebagian besar kopi jawa
                            diproses secara basah (wet process). Meskipun begitu, sebagian kopi Jawa mengeluarkan
                            aroma
                            tipis rempah yang khas. Kopi Jawa memiliki keasaman yang rendah dikombinasikan dengan
                            kondisi tanah, suhu udara, cuaca, serta kelembaban udara.</p>
                        <cite>https://id.wikipedia.org/wiki/Kopi_jawa</cite>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card__title">Kopi Luwak</h3>
                    <div class="card__content">
                        <img src="./images/kopi_luwak.jpeg" alt="gambar kopi jawa" class="card__image">
                        <p>Kopi luwak adalah seduhan kopi menggunakan biji kopi yang diambil dari sisa kotoran
                            luwak/musang kelapa. Biji kopi ini diyakini memiliki rasa yang berbeda setelah dimakan
                            dan
                            melewati saluran pencernaan luwak. Kemasyhuran kopi ini di kawasan Asia Tenggara telah
                            lama
                            diketahui, tetapi baru menjadi terkenal luas di peminat kopi gourmet setelah publikasi
                            pada
                            tahun 1980-an. Biji kopi luwak adalah yang termahal di dunia mencapai USD100 per 450
                            gram.
                        </p>
                        <cite>https://id.wikipedia.org/wiki/Kopi_luwak</cite>
                    </div>
                </div>
            </aside>

            <div class="main__rightside">
                <h2>Programmer 🧑‍💻 Dan Kopi 🍵</h2>
                <p>
                    Kopi bukan hanya sekadar minuman bagi sebagian besar programmer; itu adalah sumber energi,
                    katalisator
                    kreativitas, dan teman setia yang menemani perjalanan kode. Dalam dunia yang penuh dengan
                    sintaks,
                    algoritma, dan tumpukan kode, kopi menjadi semacam ritual spiritual bagi para pengembang
                    perangkat
                    lunak. Mari kita telusuri lebih dalam tentang hubungan unik antara programmer dan kopi, dan
                    bagaimana
                    minuman ini tidak hanya memenuhi kebutuhan kafein, tetapi juga meresapi budaya pengkodean.
                </p>

                <h2>Ritual Awal Hari: Menghidupkan Kembali Kode dengan Kopi</h2>
                <p>
                    Bagi sebagian besar programmer, hari dimulai dengan secangkir kopi yang harum. Ritual minum kopi
                    ini
                    bukan
                    hanya masalah kebiasaan pagi; itu adalah kuncinya untuk membuka pintu kreativitas. Ketika aroma
                    kopi
                    menyelinap ke ruangan kerja, pikiran programmer mulai bersiap untuk mengeksplorasi kode dan
                    menemukan
                    solusi
                    untuk masalah yang kompleks.
                </p>

                <h2> Efek Kafein: Mempercepat Proses Berpikir</h2>
                <p>
                    Kafein dalam kopi tidak hanya memberikan dorongan energi, tetapi juga mempercepat proses
                    berpikir.
                    Programmer sering menemukan bahwa secangkir kopi dapat meningkatkan fokus dan konsentrasi,
                    membantu
                    mereka
                    menyelesaikan tugas-tugas dengan lebih efisien. Dalam dunia di mana setiap baris kode memiliki
                    arti
                    dan
                    tujuan, kopi berfungsi sebagai nafas segar yang merangsang otak untuk mencapai potensi penuh.
                </p>

                <h2>Kopi sebagai Teman Setia: Menemani Larutnya Malam</h2>
                <p>
                    Pada saat hari berganti malam, kopi menjadi teman setia para programmer yang berjuang melawan
                    tenggat
                    waktu.
                    Saat kelelahan mulai mengintai, secangkir kopi hangat adalah penyemangat yang diperlukan untuk
                    terus
                    maju.
                    Programmer sering menemukan inspirasi dalam gelas kopi mereka saat menyusun algoritma atau
                    memecahkan
                    bug
                    yang sulit.
                </p>


                <h2>Kopi sebagai Pembuka Pintu Kreativitas: Meeting of the Minds</h2>
                <p>
                    Banyak ide brilian lahir dalam pertemuan atau sesi brainstorming, dan kopi seringkali menjadi
                    bagian
                    tak
                    terpisahkan dari momen-momen ini. Minuman ini menciptakan atmosfer santai di sekitar meja rapat,
                    mempromosikan interaksi antar tim, dan membuka pintu bagi pertukaran ide. Dalam komunitas
                    pengembang
                    perangkat lunak, kopi sering kali menjadi katalisator bagi kreativitas kolaboratif.

                </p>

                <h2>Kopi dan Komunitas: Menghubungkan Programmer di Seluruh Dunia</h2>
                <p>


                    Kopi bukan hanya minuman pekerja keras di satu kantor; itu adalah ikatan yang menghubungkan
                    programmer
                    di
                    seluruh dunia. Komunitas pengembang sering berkumpul di kafe atau konferensi, berbagi
                    pengalaman,
                    dan
                    mendiskusikan tren terbaru dalam dunia teknologi. Kopi menjadi medium yang merangkul perbedaan
                    dan
                    menyatukan orang dengan hasrat yang sama untuk menciptakan perangkat lunak yang luar biasa.
                </p>

                <h2> Penutup: Mempersembahkan Secangkir untuk Kode yang Hebat</h2>
                <p>
                    Dalam dunia pengkodean, programmer dan kopi adalah pasangan tak terpisahkan. Kopi bukan hanya
                    minuman
                    untuk
                    tetap terjaga; itu adalah ritual yang merayakan kreativitas, ketekunan, dan semangat kolaborasi.
                    Sambil
                    menyeruput kopi, para pengembang melibatkan diri dalam dunia pemrograman, memecahkan teka-teki,
                    dan
                    menciptakan solusi yang inovatif. Jadi, sambil menyerahkan gelas kopi untuk teman-teman
                    pengembang
                    di
                    seluruh dunia, mari kita terus mengukir kode yang luar biasa dan menyusuri jalur inovasi dalam
                    setiap
                    tetes
                    kopi yang nikmat.
                </p>

                <h2>Sumber Artikel</h2>
                <p>
                    Artikel ini di generate oleh Chat GPT: <cite>https://chat.openai.com/</cite> dengan perintah
                    <strong>&quot;buatkan saya artikel panjang tentang programmer dan kopi&quot;</strong>
                </p>
            </div>
        </article>

        <div class="divider"></div>

        <section>
            <div></div>
            <h2 id="tentang">Tentang Kopi Kode</h2>
            <p>
                Website "Kopi Kode" adalah suatu platform yang menggabungkan dua dunia yang unik: dunia pengembangan
                perangkat lunak dan budaya kopi. Dengan penuh semangat, situs ini menawarkan berbagai artikel
                informatif
                dan
                inspiratif yang membahas tentang peran kopi dalam kehidupan sehari-hari para pengembang dan
                bagaimana
                minuman ini telah menjadi bagian integral dari proses kreatif dalam dunia pemrograman.
            </p>
            <cite>Chat Open AI</cite>
        </section>

        <section>
            <div></div>
            <h2 id="langganan">Berlangganan Kopi Kode</h2>
            <p>
                Jadilah Bagian dari Komunitas "Kopi Kode": Berlangganan untuk Petualangan Pemrograman dan Rasa Kopi
                yang
                Tak Terlupakan!

                Selamat datang di "Kopi Kode", tempat di mana kecintaan pada kopi bertemu dengan keajaiban
                pemrograman.
                Apakah Anda seorang pengembang berpengalaman atau penikmat kopi yang ingin mendalami koneksi unik
                antara
                kode dan secangkir kopi, berlanggananlah sekarang untuk menikmati manfaat eksklusif berikut:

                1. Artikel Eksklusif Setiap Minggu
                Dapatkan akses ke artikel panjang dan mendalam setiap minggu, yang membahas aspek menarik dan
                inspiratif
                tentang hubungan antara dunia pemrograman dan kopi.
                2. Rahasia Ritual Kopi Pengembang
                Pelajari rahasia ritual kopi para pengembang sukses, dari bagaimana mereka memulai pagi hingga cara
                mereka tetap fokus dalam sesi coding larut malam.
                3. Panduan Kode dan Resep Kopi Eksklusif
                Terima panduan pemrograman terbaru dan resep kopi eksklusif yang akan memberikan nuansa baru pada
                pengalaman minum kopi Anda.
                4. Galeri Gambar Penuh Inspirasi
                Jelajahi galeri gambar yang memukau, membawa Anda ke dalam dunia kopi Jawa yang eksotis dan suasana
                kerja yang dipenuhi semangat pengkodean.
                5. Komunitas Pengembang dan Pencinta Kopi
                Bergabunglah dengan komunitas eksklusif "Kopi Kode", di mana Anda dapat berbagi pengalaman, bertukar
                ide, dan terhubung dengan sesama pengembang dan pecinta kopi di seluruh dunia.
                6. Diskon dan Penawaran Spesial
                Nikmati diskon eksklusif dan penawaran khusus untuk produk-produk kopi terbaik dan barang-barang
                terkait
                pemrograman.
                7. Pemberitahuan Pertama tentang Konten Baru
                Jadilah yang pertama mengetahui artikel, panduan, dan konten eksklusif lainnya yang akan memperkaya
                pengetahuan Anda dalam dunia kopi dan kode.

                Berlangganan sekarang untuk mendapatkan tiket eksklusif ke dalam dunia "Kopi Kode" dan bergabunglah
                dalam perjalanan unik yang menggabungkan cita rasa kopi yang luar biasa dengan keindahan
                pemrograman.
            </p>
            <cite>Chat Open AI</cite>
        </section>

    </main>
    <footer class="footer container">
        <div class="footer__content">
            <div>
                <p>Kopi Kode mempersembahkan cerita karangan dari Chat GPT, tentang aktifitas pemrograman secara
                    santai
                    😃
                </p>

                <p>Copyright Artikel <a href="http://chatt.openai.com"><b>Chat Open AI</b></a></p>
            </div>

            <div class="dividerv"></div>

            <div>
                <h2>Berlangganan Cerita Kopi Kode</h2>
                <form class="footer__form">
                    <button class="button button--primary" id="button-show-modal">Berlangganan</button>
                </form>
            </div>
        </div>

        <p>
            Copyright Website @makrusali
        </p>
    </footer>
</body>

</html>