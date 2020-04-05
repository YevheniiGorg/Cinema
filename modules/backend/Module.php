<?php

namespace app\modules\backend;

use app\models\User;
use Yii;

/**
 * article module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\backend\controllers';

    public function beforeAction($action){

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->can(User::ROLE_ADMINISTRATOR)){
            return true;
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

    }



}
