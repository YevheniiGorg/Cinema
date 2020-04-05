<?php

namespace app\models;

use yii\base\Model;

/**
 * BuyForm is the model behind the buy form.
 */
class BuyForm extends Model
{
    public $name;
    public $email;
    public $array_tickets;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['array_tickets','safe']
        ];
    }

}
