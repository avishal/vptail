<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\SignupForm;
use backend\models\ResetPasswordForm;
use backend\models\PasswordResetRequestForm;
use yii\web\BadRequestHttpException;
use backend\models\PasswordForm;
use backend\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','request-password-reset','signup','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        //return $this->render('index');
    	return $this->redirect(['classes/index']);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(['classes/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionSignup()
    {
    	$model = new SignupForm();
    	if ($model->load(Yii::$app->request->post())) {
    		if ($user = $model->signup()) {
    			if (Yii::$app->getUser()->login($user)) {
    				return $this->goHome();
    			}
    		}
    	}
    
    	return $this->render('signup', [
    			'model' => $model,
    	]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
    	$model = new PasswordResetRequestForm();
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		if ($model->sendEmail()) {
    			Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
    
    			return $this->goHome();
    		} else {
    			Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
    		}
    	}
    
    	return $this->render('requestPasswordResetToken', [
    			'model' => $model,
    	]);
    }
    
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
    	try {
    		$model = new ResetPasswordForm($token);
    	} catch (InvalidParamException $e) {
    		throw new BadRequestHttpException($e->getMessage());
    	}
    
    	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    		Yii::$app->session->setFlash('success', 'New password was saved.');
    
    		return $this->goHome();
    	}
    
    	return $this->render('resetPassword', [
    			'model' => $model,
    	]);
    }
    
    public function actionChangePassword()
    {
    	$model = new PasswordForm();
    	/*
    	$modeluser = User::find()->where([
    			'username'=>Yii::$app->user->identity->username
    	])->one();
    	*/
    	$modeluser = User::findByUsername(Yii::$app->user->identity->username);
    	if($model->load(Yii::$app->request->post())){
    		if($model->validate()){
    			try{
    				$modeluser->password = $_POST['PasswordForm']['newpass'];
    				if($modeluser->save()){
    					Yii::$app->getSession()->setFlash(
    							'success','Password changed'
    							);
    					return $this->redirect(['index']);
    				}else{
    					Yii::$app->getSession()->setFlash(
    							'error','Password not changed'
    							);
    					return $this->redirect(['index']);
    				}
    			}catch(Exception $e){
    				Yii::$app->getSession()->setFlash(
    						'error',"{$e->getMessage()}"
    				);
    				return $this->render('changepassword',[
    						'model'=>$model
    				]);
    			}
    		}else{
    			return $this->render('changepassword',[
    					'model'=>$model
    			]);
    		}
    	}else{
    		return $this->render('changepassword',[
    				'model'=>$model
    		]);
    	}
    }
}
