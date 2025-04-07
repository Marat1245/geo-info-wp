const { createElement, useEffect, useState } = wp.element;
const { PluginDocumentSettingPanel } = wp.editPost;
const { CheckboxControl } = wp.components;
const { useSelect, useDispatch } = wp.data;

wp.plugins.registerPlugin('custom-preprint-checkbox', {
    render: function () {
        const postId = wp.data.select('core/editor').getCurrentPostId();
        const tags = useSelect(select => select('core/editor').getEditedPostAttribute('tags') || []);
        const { editPost } = useDispatch('core/editor');

        // Получаем текущее состояние из метаполя (если оно есть)
        const preprintMeta = useSelect(select => select('core/editor').getEditedPostAttribute('meta')['_custom_preprint'] || false);

        // Используем состояние, если метаполе пустое
        const [checked, setChecked] = useState(preprintMeta);

        // При изменении состояния чекбокса обновляем метаполе
        useEffect(() => {
            if (checked) {
                // Сохраняем метаполе
                editPost({ meta: { '_custom_preprint': true } });
            } else {
                // Убираем метаполе
                editPost({ meta: { '_custom_preprint': false } });
            }
        }, [checked]);

        return createElement(
            PluginDocumentSettingPanel,
            { title: 'Препринт', initialOpen: true },
            createElement(CheckboxControl, {
                label: 'Отметить как препринт',
                checked: checked,
                onChange: (newValue) => setChecked(newValue)
            })
        );
    }
});
