export function showSetting(){
    const block = document.querySelector('.pre_post_new_post')
    document.getElementById('create_post_btn').addEventListener('click', () => {

        block.classList.add('show');

    });

    document.querySelector('.pre_post_new_post_controller:last-child').addEventListener('click', () => {
        block.classList.remove('show');
    });
}