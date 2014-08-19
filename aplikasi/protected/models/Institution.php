<?php

/**
 * This is the model class for table "institution".
 *
 * The followings are the available columns in table 'institution':
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $academic_level_id
 * @property string $attribute_1
 * @property string $attribute_2
 *
 * The followings are the available model relations:
 * @property Education[] $educations

 */
class Institution extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'institution';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, academic_level_id, attribute_1, attribute_2', 'length', 'max'=>255),
			array('info', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, info, academic_level_id, attribute_1, attribute_2', 'safe', 'on'=>'search'),
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
			'educations' => array(self::HAS_MANY, 'Education', 'institution_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'info' => 'Info',
			'academic_level_id' => 'Academic Level',
			'attribute_1' => 'Attribute 1',
			'attribute_2' => 'Attribute 2',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('academic_level_id',$this->academic_level_id,true);
		$criteria->compare('attribute_1',$this->attribute_1,true);
		$criteria->compare('attribute_2',$this->attribute_2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Institution the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
public function getInstitutionModel($institution_id)
{
//echo 'syaalala';
		$criteria=new CDbCriteria;


		$criteria->select='*';
		$criteria->condition='id="'.$institution_id.'"';

		return Institution::model()->find($criteria);

}
	
	
		

}
