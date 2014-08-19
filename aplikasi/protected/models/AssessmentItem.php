<?php

/**
 * This is the model class for table "assessment_item".
 *
 * The followings are the available columns in table 'assessment_item':
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $group
 * @property string $description
 * @property string $owner
 * @property string $created
 * @property string $status
 * @property string $start_url
 * @property string $result_url
 */
class AssessmentItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'assessment_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, group, owner, status, start_url, result_url', 'length', 'max'=>255),
			array('description, created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type, group, description, owner, created, status, start_url, result_url', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'group' => 'Group',
			'description' => 'Description',
			'owner' => 'Owner',
			'created' => 'Created',
			'status' => 'Status',
			'start_url' => 'Start Url',
			'result_url' => 'Result Url',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('start_url',$this->start_url,true);
		$criteria->compare('result_url',$this->result_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			                'pagination'=>array(
                        'pageSize'=>10,
                ),
		));
		

	}
	
	public function searchActive()
	{
	
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('start_url',$this->start_url,true);
		$criteria->compare('result_url',$this->result_url,true);
		$criteria->condition = 'status = "active"';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			                'pagination'=>array(
                        'pageSize'=>10,
                ),
		));
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssessmentItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getItemname($itemID)
	{
			$criteria=new CDbCriteria;


		$criteria->select='*';
		$criteria->condition='id="'.$itemID.'"';

		return AssessmentItem::model()->find($criteria);
	}
}
