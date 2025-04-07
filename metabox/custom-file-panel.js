(function (wp) {
    'use strict';

    if (!wp.plugins || !wp.editPost || !wp.element || !wp.components || !wp.data || !wp.apiFetch) {
        console.error('Не все зависимости WordPress загружены');
        return;
    }

    var el = wp.element.createElement;
    var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
    var TextControl = wp.components.TextControl;
    var Button = wp.components.Button;
    var Spinner = wp.components.Spinner;
    var withSelect = wp.data.withSelect;
    var withDispatch = wp.data.withDispatch;
    var compose = wp.compose.compose;
    var useState = wp.element.useState;
    var useEffect = wp.element.useEffect;
    var apiFetch = wp.apiFetch;

    var CustomFilePanel = compose(
        withSelect(function (select) {
            return {
                fileId: select('core/editor').getEditedPostAttribute('meta')._custom_file_id || ''
            };
        }),
        withDispatch(function (dispatch) {
            return {
                setFileId: function (fileId) {
                    dispatch('core/editor').editPost({
                        meta: { _custom_file_id: fileId }
                    });
                }
            };
        })
    )(function (props) {
        var fileId = props.fileId;
        var setFileId = props.setFileId;
        var _useState = useState(null),
            fileData = _useState[0],
            setFileData = _useState[1];
        var _useState2 = useState(false),
            isLoading = _useState2[0],
            setIsLoading = _useState2[1];

        useEffect(function () {
            if (fileId) {
                setIsLoading(true);
                apiFetch({
                    path: '/wp/v2/media/' + fileId
                }).then(function (media) {
                    setFileData({
                        url: media.source_url,
                        name: media.title.rendered || media.slug,
                        type: media.mime_type
                    });
                    setIsLoading(false);
                }).catch(function (error) {
                    console.error('Ошибка загрузки медиафайла:', error);
                    setFileData(null);
                    setIsLoading(false);
                });
            } else {
                setFileData(null);
            }
        }, [fileId]);

        function openMediaLibrary() {
            var frame = wp.media({
                title: 'Выберите файл',
                library: {
                    type: window.customFilePanelSettings.allowedTypes
                },
                multiple: false
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                setFileId(attachment.id);
            });

            frame.open();
        }

        return el(
            PluginDocumentSettingPanel,
            {
                name: 'custom-file-panel',
                title: 'Прикрепленный файл',
                className: 'custom-file-panel'
            },
            isLoading ? el(
                'div',
                { style: { textAlign: 'center' } },
                el(Spinner, null)
            ) : el(
                wp.element.Fragment,
                null,
                fileData ? el(
                    'div',
                    { style: { marginBottom: '16px' } },
                    el(
                        'div',
                        {
                            style: {
                                display: 'flex',
                                alignItems: 'center',
                                marginBottom: '8px'
                            }
                        },
                        el(
                            'span',
                            {
                                style: {
                                    display: 'inline-block',
                                    width: '20px',
                                    marginRight: '8px'
                                }
                            },
                            fileData.type.includes('pdf') ? '📄' : '📝'
                        ),
                        el(
                            'a',
                            {
                                href: fileData.url,
                                target: '_blank',
                                rel: 'noopener noreferrer',
                                style: {
                                    flex: 1,
                                    whiteSpace: 'nowrap',
                                    overflow: 'hidden',
                                    textOverflow: 'ellipsis'
                                }
                            },
                            fileData.name
                        )
                    ),
                    el(
                        Button,
                        {
                            isDestructive: true,
                            isSmall: true,
                            style: {
                                padding: 0,
                            },
                            onClick: function () { return setFileId(''); }
                        },
                        'Удалить'
                    )
                ) : el(
                    Button,
                    {
                        isSecondary: true,
                        onClick: openMediaLibrary,
                        style: { marginBottom: '8px' }
                    },
                    'Выбрать файл'
                ),

            )
        );
    });

    wp.plugins.registerPlugin('custom-file-panel', {
        render: function () {
            return el(CustomFilePanel, null);
        },
        icon: 'media-document'
    });

})(window.wp);