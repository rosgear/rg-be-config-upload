<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Config\Upload\Model;

/**
 * Трейт формата параметров службы загрузчика.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Config\Upload\Model
 * @since 1.0
 */
trait OptionsTrait
{
    /**
     * Возвращает формат параметров.
     * 
     * @return array
     */
    protected function getOptionsFormat(): array
    {
        return  [
            // Правила загрузки файла
            ['checkFileExtension', 'type' => 'bool', 'default' => false], // проверять расширения файла
            ['checkMimeType', 'type' => 'bool', 'default' => false], // проверять MIME-тип
            ['allowedExtensions', 'type' => 'string', 'default' => ''], // проверяемые расширения файлов
            ['allowedRoles', 'type' => 'string', 'default' => ''], // без правил для ролей пользователей
            // Новое имя файла после его загрузки
            ['transliterateFilename', 'type' => 'bool', 'default' => false], // транслитерация имени файла
            ['uniqueFilename', 'type' => 'bool', 'default' => false], // формирование уникального имени файла
            ['escapeFilename', 'type' => 'bool', 'default' => false], // исключить спецсимволы
            ['lowercaseFilename', 'type' => 'bool', 'default' => false], // имя файла в нижнем регистре
            ['replaceFilenameChars', 'type' => 'string', 'default' => '-'], // заменить спецсимволы на символ
            ['maxFilenameLength', 'type' => 'int', 'default' => 255], // максимальная длина имени файла
            // Установка значений директивам PHP при каждой загрузке файла
            ['manuallySetDirectives', 'type' => 'bool', 'default' => false], // устанавливать значения директивам PHP
            ['maxFileSize', 'type' => 'int', 'default' => 0], // максимальный размер загружаемого файла
            ['maxFileUploads', 'type' => 'int', 'default' => 0], // максимальное количество загружаемых файлов
        ];
    }

    /**
     * Выполняет форматирование значений параметров в указанном формате.
     * 
     * @param array $format Формат параметров.
     * @param array $options Параметры в виде пар "ключ - значение".
     * 
     * @return array
     */
    protected function formatOptions(array $format, array $options): array
    {
        $result = [];
        foreach ($format as $param) {
            $name = $param[0];
            if (isset($options[$name])) {
                $value = $options[$name];
                $type  = $param['type'];
                if ($type === 'bool') {
                    $value = (int) $value;
                }
                settype($value, $type);
                $result[$name] = $value;
            } else
                $result[$name] = $param['default'];
        }
        return $result;
    }

    /**
     * Выполняет добавление параметров формата для указанного ключа.
     * 
     * @param array $format Формат параметров.
     * @param array $options Параметры в виде пар "ключ - значение".
     * 
     * @return void
     */
    protected function addOptionsFromFormat(array $format, array $options): void
    {
        foreach ($format as $option) {
            $name = $option[0];
            $value = $options[$name] ?? $option['default'];
            $this->attributes['options[' . $name . ']'] = $value;
        }
    }
}
