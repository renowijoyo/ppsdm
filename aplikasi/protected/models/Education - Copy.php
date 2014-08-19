<?php

/**
 * This is the model class for table "education".
 *
 * The followings are the available columns in table 'education':
 * @property integer $id
 * @property integer $profile_id
 * @property integer $institution_id
 * @property integer $start_year
 * @property integer $graduate_year
 * @property double $grade
 @property string $note
 *
 * The followings are the available model relations:
 * @property Profile $profile
 * @property Institution $institution
 */
class Education extends CActiveRecord
{

public $attribute_1;
public $attribute_2;
public $institution_name;
public $academic_level_id;



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'education';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('profile_id, institution_id, start_year, graduate_year', 'required','message'=>'Please enter a value for {attribute}.'),
			array('profile_id, institution_id, start_year, graduate_year', 'numerical', 'integerOnly'=>true),
			array('grade', 'numerical'),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, institution_id, start_year, graduate_year, grade, note', 'safe', 'on'=>'search'),
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
			'institution' => array(self::BELONGS_TO, 'Institution', 'institution_id'),
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
			'institution_id' => 'Nama institusi',
			'start_year' => 'Tahun mulai',
			'graduate_year' => 'Tahun lulus',
			'grade' => 'Nilai',
			'note' => 'Catatan',
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
		$criteria->compare('institution_id',$this->institution_id);
		$criteria->compare('start_year',$this->start_year);
		$criteria->compare('graduate_year',$this->graduate_year);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Education the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function beforeValidate()
	{
	

	$attribute_1_container='';
$attribute_2_container='';
$institution_name_container='';
$academic_level_id_container='';


	if(isset($_POST['Education']['attribute_1']))
		$attribute_1_container=$_POST['Education']['attribute_1'];
	if(isset($_POST['Education']['attribute_2']))
		$attribute_2_container=$_POST['Education']['attribute_2'];
	if(isset($_POST['Education']['institution_name']))
		$institution_name_container=$_POST['Education']['institution_name'];
	if(isset($_POST['Education']['academic_level_id']))
		$academic_level_id_container=$_POST['Education']['academic_level_id'];

		$institution = new Institution;

		$criteria = new CDbCriteria;
		$criteria->select='*';
		$criteria->condition='name="'.$institution_name_container.'" AND academic_level_id="'.$academic_level_id_container.'" AND attribute_1="'.$attribute_1_container.'" AND attribute_2 = "'.$attribute_2_container.'"';

		$institution = Institution::model()->find($criteria);
		if(isset($institution)){
			$this->institution_id = $institution->id;
				return parent::beforeValidate();
			} else {
			//return false;
			return parent::beforeValidate();
			}
		//$this->grade = $_POST['Education']['academic_level_id'];
	
	
	}
}
