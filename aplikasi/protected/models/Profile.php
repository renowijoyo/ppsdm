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
 * @property string $place_of_birth
 * @property string $gender_id
 * @property string $religion_id
 * @property string $nationality_id
 * @property string $ethnicity_id
 * @property string $marriage_status_id
 * @property integer $number_of_children
 *
 * The followings are the available model relations:
 * @property Education[] $educations
 * @property Family[] $families
 * @property User $user
 * @property Reference $religion
 * @property Reference $nationality
 * @property Reference $ethnicity
 * @property Reference $marriageStatus
 * @property Reference $gender
 * @property ProfileContact[] $profileContacts
 * @property Upload[] $uploads
 * @property Workhistory[] $workhistories
 */
class Profile extends CActiveRecord
{
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
			//array('user_id', 'required'),
						array('user_id, place_of_birth, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id', 'required'),
			array('user_id, number_of_children', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, place_of_birth, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id', 'length', 'max'=>255),
			//array('date_of_birth', 'date', 'allowEmpty' =>true),
			array('date_of_birth', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, first_name, last_name, date_of_birth, place_of_birth, gender_id, religion_id, nationality_id, ethnicity_id, marriage_status_id, number_of_children', 'safe', 'on'=>'search'),
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
			'educations' => array(self::HAS_MANY, 'Education', 'profile_id'),
			'families' => array(self::HAS_MANY, 'Family', 'profile_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'religion' => array(self::BELONGS_TO, 'Reference', 'religion_id'),
			'nationality' => array(self::BELONGS_TO, 'Reference', 'nationality_id'),
			'ethnicity' => array(self::BELONGS_TO, 'Reference', 'ethnicity_id'),
			'marriageStatus' => array(self::BELONGS_TO, 'Reference', 'marriage_status_id'),
			'gender' => array(self::BELONGS_TO, 'Reference', 'gender_id'),
			'profileContacts' => array(self::HAS_MANY, 'ProfileContact', 'profile_id'),
			'uploads' => array(self::HAS_MANY, 'Upload', 'profile_id'),
			'workhistories' => array(self::HAS_MANY, 'Workhistory', 'profile_id'),
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
			'first_name' => Yii::t('strings', 'First Name'),
			'last_name' => Yii::t('strings', 'Last Name'),
			'date_of_birth' => Yii::t('strings', 'Date Of Birth'),
			'place_of_birth' => Yii::t('strings', 'Place Of Birth'),
			'gender_id' => Yii::t('strings', 'Gender'),
			'religion_id' => Yii::t('strings', 'Religion'),
			'nationality_id' => Yii::t('strings', 'Nationality'),
			'ethnicity_id' => Yii::t('strings', 'Ethnicity'),
			'marriage_status_id' => Yii::t('strings', 'Marriage Status'),
			'number_of_children' => Yii::t('strings', 'Number Of Children'),
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
		$criteria->compare('place_of_birth',$this->place_of_birth,true);
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
	
  protected function afterFind ()
    {
	
	if (!empty($this->date_of_birth))
	{
            // convert to display format
        $this->date_of_birth = strtotime ($this->date_of_birth);
        $this->date_of_birth = date ('d/m/Y', $this->date_of_birth);
		}
		else {
		//$this->date_of_birth  = '01-02-1900';
		}

        parent::afterFind ();
    }

	
	
}
