<?php

/**
 * This is the model class for table "profile_contact".
 *
 * The followings are the available columns in table 'profile_contact':
 * @property integer $id
 * @property integer $profile_id
 * @property string $primary_no
 * @property string $primary_type_id
 * @property string $secondary_no
 * @property string $secondary_type_id
 *
 * The followings are the available model relations:
 * @property Profile $profile
 * @property Reference $primaryType
 * @property Reference $secondaryType
 */
class ProfileContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile_contact';
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
			array('primary_no, primary_type_id, secondary_no, secondary_type_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, primary_no, primary_type_id, secondary_no, secondary_type_id', 'safe', 'on'=>'search'),
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
			'primaryType' => array(self::BELONGS_TO, 'Reference', 'primary_type_id'),
			'secondaryType' => array(self::BELONGS_TO, 'Reference', 'secondary_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'profile_id' => Yii::t('strings', 'Profile'),
			'primary_no' => Yii::t('strings', 'Primary No'),
			'primary_type_id' => Yii::t('strings', 'Type'),
			'secondary_no' => Yii::t('strings', 'Secondary No'),
			'secondary_type_id' => Yii::t('strings', 'Type'),
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
		$criteria->compare('primary_no',$this->primary_no,true);
		$criteria->compare('primary_type_id',$this->primary_type_id,true);
		$criteria->compare('secondary_no',$this->secondary_no,true);
		$criteria->compare('secondary_type_id',$this->secondary_type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfileContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function loadModel($id)
	{
		//$model=Profile::model()->findByPk($id);
		// $id is user ID. must convert to profile id
		
	$criteria = new CDbCriteria;  
	$criteria->condition='profile_id="'.$id.'"';
	
		$model = $this->find($criteria);
		return $model;
		
	}
protected function beforeValidate() 
{

  if(empty($this->primary_type_id))
	$this->primary_type_id = NULL;
  if(empty($this->secondary_type_id))
	$this->secondary_type_id = NULL;
	return parent::beforeValidate();
}
	
}
