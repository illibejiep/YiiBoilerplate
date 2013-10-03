<?php
/**
 * @author Bryan Jayson Tan <admin@bryantan.info>.
 * @link http://bryantan.info
 * @link http://snapshop.ph
 * @date 11/27/12
 * @time 1:03 PM
 */
class Jwplayer extends CWidget
{
    /**
     * the ID of the JW player
     * @var string
     */
    public $id=null;

    /**
     * the file of the player, if null we use demo file of jwplayer
     * @var string
     */
    public $file=null;

    /**
     * the thumbnail image of the player, if null we use demo image of jwplayer
     * @var string
     */
    public $image=null;

    public $flashplayer=null;

    /**
     * @var int
     */
    public $width=550;

    /**
     * @var int
     */
    public $height=400;

    /**
     * options of the jw player
     * @var array
     */
    public $options=array();

    public $tag='div';

    private $_assetsUrl=null;

    /**
     * init widget
     */
    public function init(){
        $this->registerAssets();
        if ($this->id===null){
            $this->id=$this->getId();
        }
        if ($this->file===null){
            $this->options['file']=$this->_assetsUrl.'/video.mp4';
        }
        if ($this->file===null && $this->image===null){
            $this->options['image']=$this->_assetsUrl.'/preview.jpg';
        }
        if ($this->flashplayer===null){
            $this->options['flashplayer']=$this->_assetsUrl.'/player.swf';
        }
        $this->options['width']=$this->width;
        $this->options['height']=$this->height;
        Yii::app()->getClientScript()->registerScriptFile($this->_assetsUrl.'/jwplayer.js');
    }

    public function run(){
        echo CHtml::tag($this->tag,array('id'=>$this->id));
        echo CHtml::closeTag($this->tag);

        $options = CJavaScript::encode($this->options);
        Yii::app()->getClientScript()->registerScript('jwplayer'.$this->id, "jwplayer('{$this->id}').setup({$options})");
    }

    /**
     * register assets
     * @return mixed
     */
    public function registerAssets(){
        if ($this->_assetsUrl===null){
            $assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets');
            return $this->_assetsUrl = $assetsUrl;
        }
    }
}
