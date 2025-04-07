(function (wp) {
    const { registerBlockType } = wp.blocks;
    const { createElement } = wp.element;
    const { useSelect, useDispatch } = wp.data;
    const { SelectControl, Button } = wp.components;

    registerBlockType('custom/interesting-post', {
        title: 'Вам будет интересно',
        icon: 'admin-links',
        category: 'widgets',
        attributes: {
            postId: { type: 'number' },
            postTitle: { type: 'string' },
            postImage: { type: 'string' },
            postUrl: { type: 'string' }
        },
        edit: ({ attributes, setAttributes, clientId }) => {
            const { postId, postTitle, postImage, postUrl } = attributes;
            const { removeBlock } = useDispatch('core/block-editor');  // Подключаем функцию для удаления блока

            const posts = useSelect((select) =>
                select('core').getEntityRecords('postType', 'post', { per_page: 10, _embed: true })
            );

            // Функция для удаления блока
            const handleRemoveBlock = () => {
                removeBlock(clientId);
            };

            return createElement(
                'div',
                { className: 'interesting-post' },
                createElement(SelectControl, {
                    label: 'Выберите статью',
                    value: postId,
                    options: [{ label: 'Выберите...', value: '' }].concat(
                        (posts || []).map((post) => ({
                            label: post.title.rendered,
                            value: post.id
                        }))
                    ),
                    onChange: (value) => {
                        const selectedPost = posts.find((post) => post.id == value);
                        const image = selectedPost._embedded?.['wp:featuredmedia']?.[0]?.media_details?.sizes;

                        setAttributes({
                            postId: selectedPost.id,
                            postTitle: selectedPost.title.rendered,
                            postImage: image?.thumbnail?.source_url || image?.medium?.source_url || selectedPost._embedded?.['wp:featuredmedia']?.[0]?.source_url || '',
                            postUrl: selectedPost.link
                        });
                    }
                }),
                postUrl &&
                createElement(
                    'a',
                    { href: postUrl, className: 'link_company link_wrap' },
                    createElement(
                        'div',
                        { className: 'cros_link cros_link_wrap' },
                        postImage &&
                        createElement('img', { src: postImage, alt: postTitle }),
                        createElement(
                            'div',
                            { className: 'cros_link_content' },
                            createElement('span', { className: 'cros_link_text' }, 'Вам будет интересно'),
                            createElement('span', { className: 'cros_link_title' }, postTitle)
                        )
                    )
                ),
                // Кнопка для удаления блока под контентом
                createElement(
                    'div',
                    { className: 'remove-block-button' },
                    createElement(
                        Button,
                        {
                            isSecondary: true,
                            isDestructive: true,
                            onClick: handleRemoveBlock,
                            style: { marginTop: '10px' }
                        },
                        'Удалить блок'
                    )
                )

            );
        },
        save: ({ attributes }) => {
            return attributes.postUrl
                ? createElement(
                    'a',
                    { href: attributes.postUrl, className: 'link_company' },
                    createElement(
                        'div',
                        { className: 'cros_link' },
                        attributes.postImage &&
                        createElement('img', { src: attributes.postImage, alt: attributes.postTitle }),
                        createElement(
                            'div',
                            { className: 'cros_link_content' },
                            createElement('span', { className: 'cros_link_text' }, 'Вам будет интересно'),
                            createElement('span', { className: 'cros_link_title' }, attributes.postTitle)
                        )
                    )
                )
                : null;
        }
    });
})(window.wp);
