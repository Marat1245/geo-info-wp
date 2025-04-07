// document.addEventListener("DOMContentLoaded", function () {
//     const listContainer = document.querySelector('.upload_list'); // Контейнер постов

//     if (!listContainer) return;

//     console.log("✅ Контейнер .upload_list найден!");

//     // Массив для сохранения порядка постов
//     let postsOrder = [];
    
//     // 1. Создаём IntersectionObserver
//     const observer = new IntersectionObserver((entries) => {
//         entries.forEach(entry => {
//             const post = entry.target;

//             if (entry.isIntersecting) {
//                 // Если пост видим, восстанавливаем его в DOM
//                 if (!listContainer.contains(post)) {
//                     listContainer.appendChild(post);
//                 }
//             } else {
//                 // Если пост не видим, убираем его из DOM
//                 if (listContainer.contains(post)) {
//                     listContainer.removeChild(post);
//                     // Сохраняем информацию о посте в массив
//                     postsOrder.push(post);
//                 }
//             }
//         });
//     }, { root: null, threshold: 0.2 }); // 0.2 = элемент виден хотя бы на 20%

//     // 2. Функция для наблюдения за постами
//     function observePosts() {
//         document.querySelectorAll('.post_item').forEach(post => {
//             if (!post.dataset.observed) {
//                 observer.observe(post);
//                 post.dataset.observed = "true"; // Отмечаем, что пост уже в Observer
//             }
//         });
//     }

//     // 3. Следим за новыми постами (MutationObserver)
//     const mutationObserver = new MutationObserver(() => {
//         observePosts(); // Подключаем новые посты
//     });

//     mutationObserver.observe(listContainer, { childList: true, subtree: true });

//     // 4. Подключаем уже загруженные посты
//     observePosts();

//     // 5. Восстановление порядка постов, когда они возвращаются в DOM
//     function restorePostOrder() {
//         postsOrder.forEach(post => {
//             listContainer.appendChild(post); // Вставляем каждый пост в его исходное положение
//         });
//         postsOrder = []; // Очищаем массив после восстановления порядка
//     }

//     // Можно вызывать restorePostOrder при необходимости, например, при загрузке новых данных
// });
