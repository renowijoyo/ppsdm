<?php

/**
 * This is the model class for table "profile_address".
 *
 * The followings are the available columns in table 'profile_address':
 * @property integer $id
 * @property integer $profile_id
 * @property string $country_id
 * @property string $province_id
 * @property string $city_id
 * @property string $street_address
 * @property string $postal_code
 *
 * The followings are the available model relations:
 * @property Profile $profile
 */
class ProfileAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, profile_id', 'numerical', 'integerOnly'=>true),
			array('country_id, province_id, city_id, street_address, postal_code', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, country_id, province_id, city_id, street_address, postal_code', 'safe', 'on'=>'search'),
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
			'profile_id' => Yii::t('strings', 'Profile'),
			'country_id' => Yii::t('strings', 'Country'),
			'province_id' => Yii::t('strings', 'Province'),
			'city_id' => Yii::t('strings', 'City'),
			'street_address' => Yii::t('strings', 'Street Address'),
			'postal_code' => Yii::t('strings', 'Postal Code'),
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
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('street_address',$this->street_address,true);
		$criteria->compare('postal_code',$this->postal_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfileAddress the static model class
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
}
