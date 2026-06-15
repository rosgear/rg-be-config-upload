<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Config\Upload\Widget;

/**
 * {@inheritdoc}
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Config\Upload\Widget
 * @since 1.0
 */
class ServiceWindow extends \Rg\Backend\Config\Widget\ServiceWindow
{
    /**
     * Роли пользователей выпадающего списка.
     * 
     * @var array
     */
    public array $roles = [];

    /**
     * {@inheritdoc}
     */
    public array $passParams = ['service', 'unified', 'roles'];

    /**
     * {@inheritdoc}
     */
    protected function init(): void
    {
        parent::init();

        // окно компонента (Ext.window.Window Sencha ExtJS)
        $this->autoHeight = true;
        $this->width = 630;
        $this->height = 700;
        $this->responsiveConfig = [
            'height < 700' => ['height' => '99%'],
        ];

        // панель формы (Ge.view.form.Panel GeJS)
        $this->form->autoScroll = true;
        $this->form->defaults = [
            'xtype'      => 'textfield',
            'anchor'     => '100%',
            'labelAlign' => 'right',
            'labelWidth' => 90
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function formItems(): array
    {
        /** @var array $sOptions Параметры загрузки ресурсов службы загрузчика */
        $sOptions = $this->service->getOptions();
        /** @var array $sOptions Параметры загрузки ресурсов службы загрузчика */
        $uOptions = $this->unified['options'] ?? [];

        return [
            [
                'xtype'       => 'fieldset',
                'title'       => '#File upload address',
                'collapsible' => true,
                'defaults'    => [
                    'labelAlign' => 'right',
                    'labelWidth' => 250
                ],
                'items' => [
                    [
                        'xtype'      => 'textfield',
                        'fieldLabel' => '#Local (base) folder path',
                        'name'       => 'localPath',
                        'anchor'     => '100%',
                        'allowBlank' => false,
                        'value'      => $this->unified['localPath'] ?? $this->service->localPath
                    ],
                    [
                        'xtype'      => 'textfield',
                        'fieldLabel' => '#Local (base) URL path',
                        'name'       => 'baseUrl',
                        'anchor'     => '100%',
                        'allowBlank' => false,
                        'value'      => $this->unified['baseUrl'] ?? $this->service->baseUrl
                    ]
                ]
            ],
            [
                'xtype'       => 'fieldset',
                'title'       => '#File upload rules',
                'collapsible' => true,
                'defaults'    => [
                    'labelAlign' => 'right',
                    'labelWidth' => 250
                ],
                'items' => [
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Check file extension',
                        'name'       => 'options[checkFileExtension]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['checkFileExtension'] ?? $sOptions['checkFileExtension'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Check MIME type of file contents',
                        'name'       => 'options[checkMimeType]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['checkMimeType'] ?? $sOptions['checkMimeType'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'tagfield',
                        'fieldLabel' => '#No rules for user roles',
                        'name'       => 'options[allowedRoles]',
                        'anchor'     => '100%',
                        'value'      => $uOptions['allowedRoles'] ?? implode(',', $sOptions['allowedRoles']),
                        'store'      => [
                            'fields' => ['id', 'name'],
                            'data'   => $this->roles
                        ],
                        'encodeSubmitValue' => true,
                        'displayField'     => 'name',
                        'valueField'       => 'id',
                        'createNewOnEnter' => false,
                        'createNewOnBlur'  => false,
                        'filterPickList'   => true,
                        'queryMode'        => 'local'
                    ],
                    [
                        'xtype'      => 'tagfield',
                        'fieldLabel' => '#Checked file extensions',
                        'name'       => 'options[allowedExtensions]',
                        'anchor'     => '100%',
                        'value'      => $uOptions['allowedExtensions'] ?? implode(',', $sOptions['allowedExtensions']),
                        'store'      => [
                            'fields' => ['mime', 'name'],
                            'data'   => $this->service->getMimes()->toList()
                        ],
                        'encodeSubmitValue' => true,
                        'displayField'     => 'name',
                        'valueField'       => 'mime',
                        'createNewOnEnter' => false,
                        'createNewOnBlur'  => false,
                        'filterPickList'   => true,
                        'queryMode'        => 'local'
                    ],
                ]
            ],
            [
                'xtype'       => 'fieldset',
                'title'       => '#New file name after downloading it',
                'collapsible' => true,
                'defaults'    => [
                    'labelAlign' => 'right',
                    'labelWidth' => 300
                ],
                'items' => [
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#File name transliteration',
                        'name'       => 'options[transliterateFilename]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['transliterateFilename'] ?? $sOptions['transliterateFilename'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Creating a unique file name',
                        'name'       => 'options[uniqueFilename]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['uniqueFilename'] ?? $sOptions['uniqueFilename'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Exclude special characters from file name',
                        'name'       => 'options[escapeFilename]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['escapeFilename'] ?? $sOptions['escapeFilename'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Lowercase file name',
                        'name'       => 'options[lowercaseFilename]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['lowercaseFilename'] ?? $sOptions['lowercaseFilename'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'textfield',
                        'fieldLabel' => '#Replace special characters with',
                        'name'       => 'options[replaceFilenameChars]',
                        'maxLength'  => 1,
                        'minLength'  => 1,
                        'width'      => 370,
                        'allowBlank' => false,
                        'value'      => $uOptions['replaceFilenameChars'] ?? $sOptions['replaceFilenameChars']
                    ],
                    [
                        'xtype'      => 'numberfield',
                        'fieldLabel' => '#Maximum file name length',
                        'name'       => 'options[maxFilenameLength]',
                        'minValue'   => 0,
                        'maxValue'   => 255,
                        'width'      => 370,
                        'allowBlank' => false,
                        'value'      => $uOptions['maxFilenameLength'] ?? $sOptions['maxFilenameLength']
                    ]
                ]
            ],
            [
                'xtype'       => 'fieldset',
                'title'       => '#Setting PHP directives each time a file is uploaded',
                'collapsible' => true,
                'defaults'    => [
                    'labelAlign' => 'right',
                    'labelWidth' => 300
                ],
                'items' => [
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Set PHP directives',
                        'name'       => 'options[manuallySetDirectives]',
                        'ui'         => 'switch',
                        'checked'    => $uOptions['manuallySetDirectives'] ?? $sOptions['manuallySetDirectives'],
                        'inputValue' => 1
                    ],
                    [
                        'xtype'      => 'textfield',
                        'fieldLabel' => '#Maximum upload file size',
                        'name'       => 'options[maxFileSize]',
                        'width'      => 370,
                        'value'      => $uOptions['maxFileSize'] ?? $sOptions['maxFileSize']
                    ],
                    [
                        'xtype'      => 'numberfield',
                        'fieldLabel' => '#Maximum number of downloads',
                        'name'       => 'options[maxFileUploads]',
                        'minValue'   => 0,
                        'maxValue'   => (int) ini_get('max_file_uploads'),
                        'width'      => 370,
                        'value'      => $uOptions['maxFileUploads'] ?? $sOptions['maxFileUploads']
                    ]
                ]
            ],
            [
                'xtype'       => 'fieldset',
                'title'       => '#PHP directives configuration to pass maximum data size',
                'collapsible' => true,
                'collapsed'   => true,
                'defaults'    => [
                    'labelAlign' => 'right',
                    'labelWidth' => 400
                ],
                'items' => [
                    [
                        'xtype'      => 'displayfield',
                        'fieldLabel' => '#Maximum size of data sent by the POST method',
                        'ui'         => 'parameter',
                        'readOnly'   => true,
                        'value'      => ini_get('post_max_size')
                    ],
                    [
                        'xtype'      => 'displayfield',
                        'fieldLabel' => '#Maximum upload file size',
                        'ui'         => 'parameter',
                        'readOnly'   => true,
                        'value'      => ini_get('upload_max_filesize')
                    ],
                    [
                        'xtype'      => 'displayfield',
                        'fieldLabel' => '#Maximum allowed number of simultaneously uploaded files',
                        'ui'         => 'parameter',
                        'readOnly'   => true,
                        'value'      => ini_get('max_file_uploads')
                    ],
                    [
                        'xtype'      => 'displayfield',
                        'fieldLabel' => '#Maximum memory size in bytes that the script can use',
                        'ui'         => 'parameter',
                        'readOnly'   => true,
                        'value'      => ini_get('memory_limit')
                    ],
                    [
                        'xtype'      => 'displayfield',
                        'fieldLabel' => '#Maximum time in seconds to load a script',
                        'ui'         => 'parameter',
                        'readOnly'   => true,
                        'value'      => ini_get('max_execution_time')
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Using the INTL module to translate file names',
                        'readOnly'   => true,
                        'ui'         => 'switch',
                        'checked'    => function_exists('transliterator_transliterate')
                    ],
                    [
                        'xtype'      => 'checkbox',
                        'fieldLabel' => '#Allowed to upload files on the server side',
                        'readOnly'   => true,
                        'ui'         => 'switch',
                        'checked'    => ini_get('file_uploads') > 0
                    ],
                ]
            ],
            [
                'xtype'  => 'toolbar',
                'dock'   => 'bottom',
                'border' => 0,
                'style'  => ['borderStyle' => 'none'],
                'items'  => [
                    [
                        'xtype'    => 'checkbox',
                        'boxLabel' => $this->creator->t('reset settings'),
                        'name'     => 'reset',
                        'ui'       => 'switch'
                    ]
                ]
            ]
        ];
    }
}
