let page = 1;
let maxLoads = 2;
let loadCount = 0;
document.addEventListener("DOMContentLoaded", function () {

    const moreBtn = document.getElementById("load-more-news");

    if (!moreBtn) return;
    // showListNews(moreBtn)
    moreBtn.addEventListener("click", function () {
        showListNews(moreBtn)
    });
})

function showListNews(moreBtn) {
    if (loadCount < maxLoads) {
        let container = document.getElementById("news-container");

        // Формируем параметры запроса
        const params = new URLSearchParams();
        params.append("action", "load_more_news");
        params.append("page", page);
        params.append('nonce', typeof geoInfoNews !== 'undefined' ? geoInfoNews.nonce : '');


        // Выполняем fetch-запрос
        fetch(geoInfoNews.ajaxurl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: params.toString(),
        })
            .then(response => {

                if (!response.ok) {
                    throw new Error("Сетевая ошибка: " + response.status);
                }
                return response.json(); // Парсим ответ как JSON
            })
            .then(responseData => {
                console.log(responseData)
                if (responseData.success) {
                    container.insertAdjacentHTML("beforeend", responseData.data);
                    page++;
                    loadCount++;

                    console.log(maxLoads, "=", loadCount);
                    if (loadCount === maxLoads) {
                        moreBtn.innerHTML = `<a href="/news" class="more_btn" id="load-more-news">
                            <span>Все новости</span>
                        </a>`;
                    }
                } else {
                    console.warn("⚠️ Сервер ответил ошибкой:", responseData.message);
                    moreBtn.innerText = responseData.message || "Больше нет новостей";
                    moreBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error("Ошибка при выполнении запроса:", error);
            });
    }
}
