<?php

use yii\db\Migration;
use app\models\User;


/**
 * Class m200401_154610_init_permissions
 */
class m200401_154610_init_permissions extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;
        $administratorRole = $authManager->getRole(User::ROLE_ADMINISTRATOR);

        $loginToBackend = $authManager->createPermission('loginToBackend');
        $authManager->add($loginToBackend);

        $authManager->addChild($administratorRole, $loginToBackend);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;
        $authManager->remove($authManager->getPermission('loginToBackend'));
    }
}
