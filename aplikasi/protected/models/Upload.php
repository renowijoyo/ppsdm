<?php

/**
 * This is the model class for table "upload".
 *
 * The followings are the available columns in table 'upload':
 * @property integer $id
 * @property integer $profile_id
 * @property string $filepath
 * @property string $filename
 * @property string $category
 *
 * The followings are the available model relations:
 * @property Profile $profile
 */
class Upload extends CActiveRecord
{

	//public $image;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'upload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profile_id', 'numerical', 'integerOnly'=>true),
			array('filepath, filename, category', 'length', 'max'=>255),
		//	array('image', 'file', 'types'=>'jpg, gif, png'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, filepath, filename, category', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'profile' => array(self::BELONGS_TO, 'Profile', 'profile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'profile_id' => 'Profile',
			'filepath' => 'Filepath',
			'filename' => 'Filename',
			'category' => 'Category',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('profile_id',$this->profile_id);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('category',$this->category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Upload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
