<?php

class UnsubscribeController extends Controller
{

	public function actionIndex($email, $spam_id, $key)
	{
        /** @var User $user */
        $user = User::model()->findByAttributes(array('email' => $email));
        /** @var Spam $spam */
        $spam = Spam::model()->findByPk($spam_id);

        if (!$user || !$spam || $key != $spam->getUnsubscribeHash($user))
            throw new CHttpException(404,'The requested page does not exist.');

        $unsubscribed = false;
        $spam_type_id = $spam->type_enum;

        foreach ($user->userUnsubscribes as $unsubscribe)
            if ($unsubscribe->spam_type_id == $spam_type_id)
                $unsubscribed = true;

        if (!$unsubscribed) {
            $userUnsubscribe = new UserUnsubscribe();
            $userUnsubscribe->spam_type_id = $spam_type_id;
            $userUnsubscribe->user_id = $user->id;
            if ($userUnsubscribe->save())
                $unsubscribed = true;
            else
                throw new CException('unsubscribe error:'.var_export($userUnsubscribe->errors,true));
        }

        $this->render('/user/unsubscribe',array('user'=>$user,'spam'=>$spam,'unsubscribed' => $unsubscribed));
	}
}