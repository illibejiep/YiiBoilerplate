<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
        Yii::app()->session->regenerateID(true);
        Yii::app()->request->cookies->remove('PHPSESSID',array('domain'=>Yii::app()->session->cookieParams['domain']));
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

    public function allowedActions()
    {
        return 'logout';
    }
}