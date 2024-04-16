function cutWords(words, max) {
    const len = words.length;
    if (len > max) return words.substring(0, max) + "....";
    return words;
}

async function fetchArticlesAndAppendToElList() {
    const elListArticles = document.getElementById("list-articles");
    const maxList = 5;
    const maxWords = 200;

    try {
        const host = "https://raw.githubusercontent.com/2218115/kokode/main";
        const endpoint = host + "/datas/articles.json";
        const response = await fetch(endpoint, {
            method: 'GET',
        });
        if (response.status === 200) {
            const articles = await response.json();

            articles.map(function (article, index) {

                if (index > maxList) return;

                elListArticles.innerHTML +=
                    `
                    <li class="list-articles__item">
                        <h3>${article.title}</h3>
                        <p>${cutWords(article.content, maxWords)}</p>
                        <a href="kemana gitu">Baca lebih lanjut.</a>
                    </li>
                `;
            });
        } else {
            elListArticles.innerHTML = '<p>Gagal memuat artikel terbaru</p>';
        }

    } catch (e) {
        console.log(e);
    }
}