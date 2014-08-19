<?php

/**
 * This is the model class for table "workhistory".
 *
 * The followings are the available columns in table 'workhistory':
 * @property integer $id
 * @property integer $profile_id
 * @property string $employer
 * @property string $industry_id
 * @property string $position
 * @property string $start_date
 * @property string $finish_date
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Reference $industry
 * @property Profile $profile
 */
class Workhistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workhistory';
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
			array('profile_id, industry_id, position, employer', 'required'),
			array('employer, industry_id, position', 'length', 'max'=>255),
			array('start_date, finish_date, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, employer, industry_id, position, start_date, finish_date, description', 'safe', 'on'=>'search'),
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
			'employer' => Yii::t('strings', 'Employer'),
			'industry_id' => Yii::t('strings', 'Industry'),
			'position' => Yii::t('strings', 'Position'),
			'start_date' => Yii::t('strings', 'Start Date'),
			'finish_date' => Yii::t('strings', 'Finish Date'),
			'description' => Yii::t('strings', 'Description'),
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
		$criteria->compare('employer',$this->employer,true);
		$criteria->compare('industry_id',$this->industry_id,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('finish_date',$this->finish_date,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workhistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
protected function beforeValidate() 
{

  if(empty($this->industry_id))
	$this->industry_id = NULL;

	return parent::beforeValidate();
}

  protected function afterFind ()
    {
            // convert to display format
        $this->start_date = strtotime ($this->start_date);
        $this->start_date = date ('d/m/Y', $this->start_date);
		
		
        $this->finish_date = strtotime ($this->finish_date);
        $this->finish_date = date ('d/m/Y', $this->finish_date);
		
		
        parent::afterFind ();
    }


}
