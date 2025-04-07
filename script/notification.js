
export function showNotification() {
    const notification = document.querySelector('.notification');
    notification.classList.add('active');

    setTimeout(() => {
        notification.classList.remove('active');
    }, 1500);
}