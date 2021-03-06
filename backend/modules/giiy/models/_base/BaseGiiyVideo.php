<?php

/**
 * This is the model base class for the table "video".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giiy.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Video".
 *
 * Columns in table "video" available as properties of the model,
 * followed by relations of table "video" available as properties of the model.
 *
 * @property integer $id
 * @property integer $type_enum
 * @property string $name
 * @property integer $width
 * @property integer $height
 * @property integer $picture_id
 * @property string $created
 * @property string $modified
 * @property double $duration
 * @property integer $bit_rate
 * @property string $codec
 * @property string $description
 *
 * @property GiiyPicture $picture
 *
 * @property GiiyVideoTypeEnum $type
 */
abstract class BaseGiiyVideo extends GiiyActiveRecord implements ITypeEnumerable {
    /** @var GiiyVideoTypeEnum */
    protected $_type;

    public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return Yii::app()->getModule('giiy')->tablePrefix.'giiy_video';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Video|Videos', $n);
	}

	public function rules() {
		return array(
			array('created, modified', 'required'),
			array('type_enum, width, height, picture_id, bit_rate', 'numerical', 'integerOnly'=>true),
			array('duration', 'numerical'),
			array('name, codec', 'length', 'max'=>1024),
			array('description', 'safe'),
			array('type_enum, name, width, height, picture_id, duration, bit_rate, codec, description', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, type_enum, name, width, height, picture_id, created, modified, duration, bit_rate, codec, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'picture' => array(self::BELONGS_TO, 'GiiyPicture', 'picture_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'type_enum' => Yii::t('app', 'Type Enum'),
			'name' => Yii::t('app', 'Name'),
			'width' => Yii::t('app', 'Width'),
			'height' => Yii::t('app', 'Height'),
			'picture_id' => null,
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'duration' => Yii::t('app', 'Duration'),
			'bit_rate' => Yii::t('app', 'Bit Rate'),
			'codec' => Yii::t('app', 'Codec'),
			'description' => Yii::t('app', 'Description'),
			'picture' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->getAttribute('id'));
		$criteria->compare('t.type_enum', $this->getAttribute('type_enum'));
		$criteria->compare('t.name', $this->getAttribute('name'), true);
		$criteria->compare('t.width', $this->getAttribute('width'));
		$criteria->compare('t.height', $this->getAttribute('height'));
		$criteria->compare('t.picture_id', $this->getAttribute('picture_id'));
		$criteria->compare('t.created', $this->getAttribute('created'), true);
		$criteria->compare('t.modified', $this->getAttribute('modified'), true);
		$criteria->compare('t.duration', $this->getAttribute('duration'));
		$criteria->compare('t.bit_rate', $this->getAttribute('bit_rate'));
		$criteria->compare('t.codec', $this->getAttribute('codec'), true);
		$criteria->compare('t.description', $this->getAttribute('description'), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

    public function getType() {
        if ($this->getAttribute('type_enum') === null)
            return null;

        if ($this->_type === null)
            $this->_type = new GiiyVideoTypeEnum($this->getAttribute('type_enum'));

        return $this->_type;
    }

    public function setType($value) {
        if ($value instanceof GiiyVideoTypeEnum) {
            $this->_type = $value;
            $this->setAttribute('type_enum', $value->id);
        } elseif (is_numeric($value)) {
            $this->_type = new GiiyVideoTypeEnum($value);
            $this->setAttribute('type_enum', $value);
        } else {
            throw new CExeption('Wrong enum value for Video.type');
        }

        return $this;
    }
    
    public function getTypesFields()
    {
        $typesFields = array();
        foreach (GiiyVideoTypeEnum::$names as $id => $name) {
            $typesFields[$id] = array(
                'type',
                'name',
                'width',
                'height',
                'duration',
                'bit_rate',
                'codec',
                'description',
                'picture',
            );
        }

        return $typesFields;
    }

    }