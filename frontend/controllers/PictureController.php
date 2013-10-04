<?php

class PictureController extends Controller
{
	public function actionResize($id1,$id2,$width,$height,$type) {
        $id = $id1*1000+$id2;
        /** @var Picture $picture */
        $picture = Picture::model()->findByPk($id);
        if (!$picture)
            throw new CHttpException(404,'The requested page does not exist.');

        if ($picture->resize($width,$height) !== null) {
            header("Content-type: ".$picture->getType()->getMime());
            echo file_get_contents($picture->getResizePath($width,$height));
            exit();
        }

        throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}