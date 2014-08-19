<?php

/**
 * This is the model class for table "family".
 *
 * The followings are the available columns in table 'family':
 * @property integer $id
 * @property integer $profile_id
 * @property string $name
 * @property string $relation_type_id
 *
 * The followings are the available model relations:
 * @property Profile $profile
 * @property Reference $relationType
 */
class Family extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'family';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('profile_id, relation_type_id, name', 'required','message'=>'Please enter a value for {attribute}.'),
			array('profile_id', 'numerical', 'integerOnly'=>true),
			array('name, relation_type_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, name, relation_type_id', 'safe', 'on'=>'search'),
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
			'relationType' => array(self::BELONGS_TO, 'Reference', 'relation_type_id'),
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
			'name' => Yii::t('strings', 'Name'),
			'relation_type_id' => Yii::t('strings', 'Relation Type'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('relation_type_id',$this->relation_type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Family the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

}
