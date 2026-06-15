<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Config\Upload\Controller;

use Ge;
use Rg\Backend\Config\Controller\ServiceForm;
use Rg\Backend\Config\Upload\Widget\ServiceWindow;

/**
 * Контроллер конфигурации службы "Загрузка".
 * 
 * Cлужба {@see \Ge\Upload\Upload}.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Config\Upload\Controller
 * @since 1.0
 */
class Form extends ServiceForm
{
    /**
     * {@inheritdoc}
     */
    public function createWidget(): ServiceWindow
    {
        /** @var \Rg\Backend\UserRoles\Model\Role $role */
        $role = Ge::getMModel('Role', 'rg.be.user_roles');
        return new ServiceWindow([
            'service' => Ge::$app->uploader,
            'unified' => Ge::getUnified(Ge::$app->uploader),
            'roles'   => $role->fetchCombo()
        ]);
    }
}
