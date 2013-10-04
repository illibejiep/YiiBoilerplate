<?

class PictureController extends CRUDController
{

    public function actionCropResize()
    {
        $id = $_POST['id'];
        $x = $_POST['cropImage_x'];
        $x2 = $_POST['cropImage_x2'];
        $y = $_POST['cropImage_y'];
        $y2 = $_POST['cropImage_y2'];
        $h = $_POST['cropImage_h'];
        $w = $_POST['cropImage_w'];

        $picture = $this->loadModel($id);

        if (!$picture OR !$picture->cropResize($x,$x2,$y,$y2,$w,$h)) {
            echo 'error';
            Yii::app()->end();
        }

        echo 'done';
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        if (Yii::app()->getRequest()->isAjaxRequest && $model) {
            echo json_encode($model);
            Yii::app()->end();
        }

        $resolutions = array();
        $dir = $model->getResizeDir();
        if (is_dir($dir))
            foreach (scandir($dir) as $file) {
                if (strpos($file,'.'.$model->type)) {
                    $resolution= str_replace('.'.$model->type,'',$file);
                    $widthHeight = explode('x',$resolution);
                    if (count($widthHeight) != 2) continue;
                    $resolutions[] = array('width'=>$widthHeight[0],'height'=>$widthHeight[1]);
                }
            }

        $this->render('view',array(
            'model' => $model,
            'resolutions' => $resolutions,
        ));
    }

    public function actionUnlink($id,$width,$height)
    {
        $model = $this->loadModel($id);

        unlink($model->getResizePath($width,$height));

        $this->redirect(array('view','id' => $id));
    }

    /**
     * @param null $id
     * @return Picture
     */
    public function loadModel($id = null)
    {
        return parent::loadModel($id);
    }


}