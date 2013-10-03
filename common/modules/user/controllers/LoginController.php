<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

    public function actions()
    {
        return array(
            'oauth' => array(
              'class'=>'ext.hoauth.HOAuthAction',
            ),
            //'oauthadmin' => array(
            //  'class'=>'ext.hoauth.HOAuthAdminAction',
            //),
        );
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin($service = null)
	{
        if ($service && isset(Yii::app()->eauth)) {
            /** @var EAuth $eauth */
            $eauth = Yii::app()->eauth;
            $serviceIdentity = $eauth->getIdentity($service);
            $serviceIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $serviceIdentity->cancelUrl = $this->createAbsoluteUrl('/login');

            try {
                if ($serviceIdentity->authenticate() && $serviceIdentity->getIsAuthenticated()) {

                    if (Yii::app()->user->isGuest) {
                        $userOauth = UserOauth::model()->find('service = :service AND foreign_id = :id',array(
                            'service' => $service,
                            'id' => $serviceIdentity->getId(),
                        ));

                        if ($userOauth) {
                            /** @var User $user */
                            $user = $userOauth->user;
                            $userIdentity = new EAuthUserIdentity($serviceIdentity,$user);
                            Yii::app()->user->login($userIdentity);
                            $serviceIdentity->redirect();
                        } else {
                            $eauthSession = isset(Yii::app()->session['eauth'])?Yii::app()->session['eauth']:array();
                            $eauthSession[$service] = $serviceIdentity->getAttributes();
                            Yii::app()->session['eauth'] = $eauthSession;
                            $this->redirect(Yii::app()->getModule('user')->registrationUrl);
                        }
                    } else {
                        /** @var User $user */
                        $exists = false;
                        $user = User::model()->findByPk(Yii::app()->user->id);
                        foreach($user->userOauths as $userOauth)
                            if ($userOauth->service == $service && $userOauth->foreign_id == $serviceIdentity->getId())
                                $exists = true;
                        if (!$exists) {
                            $userOauth = new UserOauth();
                            $userOauth->service = $service;
                            $userOauth->foreign_id = $serviceIdentity->getId();
                            $userOauth->user_id = $user->id;
                            $userOauth->save();
                            $user->resetCache();
                        }
                    }
                }
                // Something went wrong, redirect to login page
                $this->redirect(array('/login'));
            }
            catch (EAuthException $e) {
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                $serviceIdentity->redirect($serviceIdentity->getCancelUrl());
            }
        }

		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$user = $this->lastViset();
                    if (Yii::app()->request->isAjaxRequest){
                        echo json_encode($user->getUserData);
                        exit();
                    }
					if (Yii::app()->user->returnUrl=='/index.php')
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = date('Y-m-d H:i:s');
		$lastVisit->save();
        return $lastVisit;
	}

    public function allowedActions()
    {
        return 'login';
    }
}