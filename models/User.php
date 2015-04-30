<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

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
class User extends ActiveRecord
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
            [['username', 'email', 'password', 'fio', 'photo'], 'required'],
            [['address'], 'string'],
            [['ref_id'], 'integer'],
            [['photo'], 'file'],
            [['username'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 128],
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
    public static function findByUsername($username)
    {
        $user = User::find()->where(['username' => $username])->one();

        return $user;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function CroppedThumbnail($imgSrc, $save_To, $thumbnail_width, $thumbnail_height) {
        list($width_orig, $height_orig, $type) = getimagesize($imgSrc);
        $types = array('','gif','jpeg','png');
        $ext = $types[$type];
        $func = 'imagecreatefrom'.$ext;
        $myImage = imagecreatefromjpeg($imgSrc);

        $ratio_orig = $width_orig/$height_orig;

        if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
            $new_height = $thumbnail_width/$ratio_orig;
            $new_width = $thumbnail_width;
        } else {
            $new_width = $thumbnail_height*$ratio_orig;
            $new_height = $thumbnail_height;
        }

        $x_mid = $new_width/2;
        $y_mid = $new_height/2;

        $process = imagecreatetruecolor(round($new_width), round($new_height));

        imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
        $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

        imagedestroy($process);
        imagedestroy($myImage);

        imagejpeg($thumb, $save_To);
    }
}
