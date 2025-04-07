const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;
const { select, dispatch } = wp.data;

registerBlockType('custom/annotation-block', {
    title: 'Аннотация',
    icon: 'edit',
    category: 'common',
    attributes: {
        content: {
            type: 'string',
            default: 'Это аннотация, которую нельзя редактировать.'
        }
    },

    // Редактирование блока
    edit: ({ attributes, setAttributes, isSelected }) => {
        const { content } = attributes;

        return wp.element.createElement('div', {},
            wp.element.createElement('div', { style: { padding: '20px', backgroundColor: '#f0f0f0', border: '1px solid #ccc', marginBottom: '20px' } },
                wp.element.createElement('p', { style: { fontWeight: 'bold' } }, 'Аннотация:'),
                wp.element.createElement(RichText, {
                    tagName: 'p',
                    value: content,
                    onChange: (newContent) => setAttributes({ content: newContent }),
                    placeholder: 'Введите текст аннотации...',
                    disabled: !isSelected, // блок редактируемый только если выбран
                })
            )
        );
    },

    // Сохранение блока
    save: ({ attributes }) => {
        return wp.element.createElement('div', { style: { padding: '20px', backgroundColor: '#f0f0f0', border: '1px solid #ccc', marginBottom: '20px' } },
            wp.element.createElement('p', { style: { fontWeight: 'bold' } }, 'Аннотация:'),
            wp.element.createElement('p', {}, attributes.content)
        );
    },

    // Блокируем удаление и перемещение
    supports: {
        removable: false, // Запрещаем удаление
        moveable: false,  // Запрещаем перемещение
        inserter: true,   // Можно вставить, но не удалить
        reusable: false,  // Блок нельзя сохранять как reusable
    }
});

// Добавляем блок в редактор после загрузки
wp.domReady(() => {
    const blocks = select('core/editor').getBlocks();
    const isAnnotationBlockPresent = blocks.some(block => block.name === 'custom/annotation-block');

    if (!isAnnotationBlockPresent) {
        const firstBlock = select('core/editor').getBlocks()[0]; // Первый блок

        // Вставляем аннотацию в самое начало, если она еще не существует
        dispatch('core/editor').insertBlocks(wp.blocks.createBlock('custom/annotation-block'), 0);
    }
});
