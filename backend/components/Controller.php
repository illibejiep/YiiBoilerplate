<?php
/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
class Controller extends RController {

	public $breadcrumbs = array();
	public $menu = array();
    public $layout='//main';

    public function filters()
    {
        return array('rights');
    }
}
