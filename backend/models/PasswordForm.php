<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class PasswordForm extends Model {
	public $oldpass;
	public $newpass;
	public $repeatnewpass;
	public function rules() {
		return [ 
				[ 
						[ 
								'oldpass',
								'newpass',
								'repeatnewpass' 
						],
						'required' 
				],
				[ 
						'oldpass',
						'findPasswords' 
				],
				[ 
						'repeatnewpass',
						'compare',
						'compareAttribute' => 'newpass' 
				] 
		];
	}
	public function findPasswords($attribute, $params) {
		$user = User::findByUsername ( Yii::$app->user->identity->username );
		/*
		 * $user = User::find()->where([
		 * 'username'=>Yii::$app->user->identity->username
		 * ])->one();
		 */
		// echo "<pre>"; print_r($user);exit;
		$password = $user->auth_key;
		$password_hash = $user->password_hash;
		// echo $password_hash."<br>";
		// print_r(!$user->validatePassword($this->oldpass));
		// echo Yii::$app->security->generatePasswordHash($this->oldpass);
		// exit;
		// if(Yii::$app->security->validatePassword($password, $password_hash))
		// if($password_hash!=!$user->validatePassword($this->oldpass))
		if (! $user->validatePassword ( $this->oldpass ))
			$this->addError ( $attribute, 'Old password is incorrect' );
	}
	public function attributeLabels() {
		return [ 
				'oldpass' => 'Old Password',
				'newpass' => 'New Password',
				'repeatnewpass' => 'Repeat New Password' 
		];
	}
}