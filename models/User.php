<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fio
 * @property string $address
 * @property string $photo
 * @property string $ref_link
 * @property integer $ref_id
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'fio', 'address', 'photo'], 'required'],
            [['address'], 'string'],
            [['ref_id'], 'integer'],
            [['username'], 'string', 'max' => 40],
            [['email', 'photo'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 32],
            [['fio'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'fio' => 'Fio',
            'address' => 'Address',
            'photo' => 'Photo',
            'ref_link' => 'Ref Link',
            'ref_id' => 'Ref ID',
        ];
    }
}
