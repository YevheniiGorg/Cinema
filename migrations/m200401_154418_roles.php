<?php


use yii\db\Migration;
use app\models\User;

/**
 * Class m200401_154418_roles
 */
class m200401_154418_roles extends Migration
{

    public function up()
    {
        $authManager = Yii::$app->authManager;

        $authManager->removeAll();

        $user = $authManager->createRole(User::ROLE_USER);
        $authManager->add($user);

        $admin = $authManager->createRole(User::ROLE_ADMINISTRATOR);
        $authManager->add($admin);

        $authManager->addChild($admin, $user);

        $authManager->assign($admin, 1);
        $authManager->assign($user, 2);
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getRole(User::ROLE_ADMINISTRATOR));
        $authManager->remove($authManager->getRole(User::ROLE_USER));
    }
}
