<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Config\Upload\Model;

use Ge;
use Rg\Backend\Config\Model\ServiceForm;

/**
 * Модель данных конфигурации службы "Загрузка".
 * 
 * Cлужба {@see \Ge\Upload\Upload}.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Config\Upload\Model
 * @since 1.0
 */
class Form extends ServiceForm
{
    use OptionsTrait;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this->unifiedName = Ge::$app->uploader->getObjectName();
    }

    /**
     * {@inheritdoc}
     */
    public function maskedAttributes(): array
    {
        return [
            'localPath' => 'localPath', // локальный путь к папке
            'baseUrl'   => 'baseUrl', // локальный URL-путь к папке
            'options'   => 'options' // параметры загрузки ресурсов

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatterRules(): array
    {
        return [
            [['localPath', 'baseUrl'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function validationRules(): array
    {
        return [
            [
                ['localPath', 'baseUrl'], 'notEmpty'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'localPath' => $this->t('Local (base) folder path'),
            'baseUrl'   => $this->t('Local (base) URL path')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeLoad(array &$data): void
    {
        /** @var array $format Формат параметров */
        $format = $this->getOptionsFormat();
        // параметры
        $data['options'] = $this->formatOptions($format, $data['options'] ?? []);
    }

    /**
     * Возращает значение для сохранения в поле "options".
     * 
     * @return array
     */
    public function unOptions(): array
    {
        $options = $this->options;
        // проверяемые расширения файлов
        if (empty($options['allowedExtensions']))
            $options['allowedExtensions'] = [];
        else
            $options['allowedExtensions'] = json_decode($options['allowedExtensions']);
        // без правил для ролей пользователей
        if (empty($options['allowedRoles']))
            $options['allowedRoles'] = [];
        else
            $options['allowedRoles'] = json_decode($options['allowedRoles']);
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function processing(): void
    {
        parent::processing();

        if ($this->options) {
            $this->addOptionsFromFormat($this->getOptionsFormat(), $this->options);
        }
    }
}
