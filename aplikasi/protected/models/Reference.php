<?php

/**
 * This is the model class for table "reference".
 *
 * The followings are the available columns in table 'reference':
 * @property integer $id
 * @property string $context
 * @property string $category
 * @property string $reference_key
 * @property string $reference_value
 *
 * The followings are the available model relations:
 * @property Application[] $applications
 * @property Family[] $families
 * @property ProfileContact[] $profileContacts
 * @property ProfileContact[] $profileContacts1
 * @property User[] $users
 */
class Reference extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reference';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('context, category, reference_key, reference_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, context, category, reference_key, reference_value', 'safe', 'on'=>'search'),
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
			'applications' => array(self::HAS_MANY, 'Application', 'status_id'),
			'families' => array(self::HAS_MANY, 'Family', 'relation_type_id'),
			'profileContacts' => array(self::HAS_MANY, 'ProfileContact', 'primary_type_id'),
			'profileContacts1' => array(self::HAS_MANY, 'ProfileContact', 'secondary_type_id'),
			'users' => array(self::HAS_MANY, 'User', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'context' => 'Context',
			'category' => 'Category',
			'reference_key' => 'Reference Key',
			'reference_value' => 'Reference Value',
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
		$criteria->compare('context',$this->context,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('reference_key',$this->reference_key,true);
		$criteria->compare('reference_value',$this->reference_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reference the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function getAcademicLevelText($id)
	{
		return $id;
			if (isset($id))
		{

					$criteria1=new CDbCriteria;				
						$criteria1->condition='id="'.$id.'"';

				$criteria=new CDbCriteria;
			$criteria->compare('reference_key',Institution::model()->find($criteria1)->academic_level_id);
			$criteria->compare('category','academic_level');

			$model = $this->find($criteria);
			return $model->reference_value;
			} else
				return null;
	}
	
	public function getStudyText($id)
	{
	
			if (isset($id))
		{
				$criteria=new CDbCriteria;
			$criteria->compare('reference_key',$id);
			$criteria->compare('category','study');

			$model = $this->find($criteria);
			return $model->reference_value;
			
			} else {
				return null;
			}
	}
	
public function getLocalized($string)
{
    $string = Yii::t('strings', $string);
	return $string;
}

	public function getValueLocalized()
	{
		return Yii::t('strings', $this->reference_value);
	}
	

}
