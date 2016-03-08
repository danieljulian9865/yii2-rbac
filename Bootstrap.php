<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dsanchez98/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dsanchez98\rbac;

use dsanchez98\rbac\components\DbManager;
use dsanchez98\rbac\components\ManagerInterface;
use dsanchez98\user\Module as UserModule;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Bootstrap class registers translations and needed application components.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        // register translations
        if (!isset($app->get('i18n')->translations['rbac*'])) {
            $app->get('i18n')->translations['rbac*'] = [
                'class'    => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
            
        if ($this->checkRbacModuleInstalled($app)) {
            // register auth manager
            if (!$this->checkAuthManagerConfigured($app)) {
                $app->set('authManager', [
                    'class' => DbManager::className(),
                ]);
            }

            // if dsanchez98/user extension is installed, copy admin list from there
            if ($this->checkUserModuleInstalled($app)) {
                $app->getModule('rbac')->admins = $app->getModule('user')->admins;
            }   
        }
    }
    
    /**
     * Verifies that dsanchez98/yii2-rbac is installed and configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkRbacModuleInstalled(Application $app)
    {
        return $app->hasModule('rbac') && $app->getModule('rbac') instanceof Module;
    }
    
    /**
     * Verifies that dsanchez98/yii2-user is installed and configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkUserModuleInstalled(Application $app)
    {
        return $app->hasModule('user') && $app->getModule('user') instanceof UserModule;
    }
    
    /**
     * Verifies that authManager component is configured.
     * @param  Application $app
     * @return bool
     */
    protected function checkAuthManagerConfigured(Application $app)
    {
        return $app->authManager instanceof ManagerInterface;
    }
}
