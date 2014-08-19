<?php

/**
 * This is the model class for table "assessment".
 *
 * The followings are the available columns in table 'assessment':
 * @property integer $id
 * @property integer $profile_id
 * @property string $tao_subject
 * @property string $assessment_item_id
 * @property string $tao_test
 * @property string $tao_test_label
 * @property string $tao_delivery_label
 * @property string $tao_delivery_result
 * @property string $tao_delivery_status
 * @property string $start_time
 * @property string $finish_time
 * @property string $note
 * @property string $result_url
 * @property string $download_url
 */
class Assessment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'assessment';
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
			array('tao_subject, assessment_item_id, tao_test, tao_test_label, tao_delivery_label, tao_delivery_result, tao_delivery_status, result_url, download_url', 'length', 'max'=>255),
			array('start_time, finish_time, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, profile_id, tao_subject, assessment_item_id, tao_test, tao_test_label, tao_delivery_label, tao_delivery_result, tao_delivery_status, start_time, finish_time, note, result_url, download_url', 'safe', 'on'=>'search'),
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
			'profile_id' => 'Profile',
			'tao_subject' => 'Tao Subject',
			'assessment_item_id' => 'Assessment Item',
			'tao_test' => 'Tao Test',
			'tao_test_label' => 'Tao Test Label',
			'tao_delivery_label' => 'Tao Delivery Label',
			'tao_delivery_result' => 'Tao Delivery Result',
			'tao_delivery_status' => 'Tao Delivery Status',
			'start_time' => 'Start Time',
			'finish_time' => 'Finish Time',
			'note' => 'Note',
			'result_url' => 'Result Url',
			'download_url' => 'Download Url',
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
		$criteria->compare('tao_subject',$this->tao_subject,true);
		$criteria->compare('assessment_item_id',$this->assessment_item_id,true);
		$criteria->compare('tao_test',$this->tao_test,true);
		$criteria->compare('tao_test_label',$this->tao_test_label,true);
		$criteria->compare('tao_delivery_label',$this->tao_delivery_label,true);
		$criteria->compare('tao_delivery_result',$this->tao_delivery_result,true);
		$criteria->compare('tao_delivery_status',$this->tao_delivery_status,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('finish_time',$this->finish_time,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('result_url',$this->result_url,true);
		$criteria->compare('download_url',$this->download_url,true);


		
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
	 * @return Assessment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getassessments($profile_id)
	{
	$criteria=new CDbCriteria;
	
	$criteria->condition='profile_id="'.$profile_id.'"'; //INI YANG MASIH ERROR
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
	}
	
}
