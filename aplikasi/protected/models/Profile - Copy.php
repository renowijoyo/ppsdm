<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $place_of_birth_id
 * @property string $gender_id
 * @property string $religion_id
 * @property string $nationality_id
 * @property string $ethnicity_id
 * @property string $marriage_status_id
 * @property integer $number_of_children
 *
 * The followings are the available model relations:
 * @property Reference $nationality
 * @property Reference $ethnicity
 * @property Reference $gender
 * @property Reference $marriageStatus
 * @property Reference $placeOfBirth
 * @property Reference $religion
 * @property User $user
 */
class Profile extends CActiveRecord
{

	//public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, place_of_birth_id, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id', 'required'),
			array('user_id, number_of_children', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, place_of_birth_id, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id', 'length', 'max'=>255),
			array('date_of_birth', 'safe'),
			//array('image','file','types'=>'jpg,gif,png'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, first_name, last_name, date_of_birth, place_of_birth_id, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id, number_of_children', 'safe', 'on'=>'search'),
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
			'nationality' => array(self::BELONGS_TO, 'Reference', 'nationality_id'),
			'ethnicity' => array(self::BELONGS_TO, 'Reference', 'ethnicity_id'),
			'gender' => array(self::BELONGS_TO, 'Reference', 'gender_id'),
			'marriageStatus' => array(self::BELONGS_TO, 'Reference', 'marriage_status_id'),
			'placeOfBirth' => array(self::BELONGS_TO, 'Reference', 'place_of_birth_id'),
			'religion' => array(self::BELONGS_TO, 'Reference', 'religion_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'date_of_birth' => 'Date Of Birth',
			'place_of_birth_id' => 'Place Of Birth',
			'gender_id' => 'Gender',
			'religion_id' => 'Religion',
			'nationality_id' => 'Nationality',
			'ethnicity_id' => 'Ethnicity',
			'marriage_status_id' => 'Marriage Status',
			'number_of_children' => 'Number Of Children',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('place_of_birth_id',$this->place_of_birth_id,true);
		$criteria->compare('gender_id',$this->gender_id,true);
		$criteria->compare('religion_id',$this->religion_id,true);
		$criteria->compare('nationality_id',$this->nationality_id,true);
		$criteria->compare('ethnicity_id',$this->ethnicity_id,true);
		$criteria->compare('marriage_status_id',$this->marriage_status_id,true);
		$criteria->compare('number_of_children',$this->number_of_children);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getProfileid($id)
	{	
		$criteria = new CDbCriteria;
		$profile_model = new Profile;
		$criteria->condition='user_id="'.$id.'"';
		$profile_model= Profile::model()->find($criteria);
		if (isset($profile_model))
			return $profile_model->id;
		else
			return false;;
	}
	
	public function beforeSave() {
	

	return parent::beforeSave();
	}
	



}
