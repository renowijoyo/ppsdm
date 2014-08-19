<?php

		if(isset($_GET['result'])) {

		
		$user_id = User::model()->find('username=:username', array(':username'=>$_GET['user']))->id;
		$profile_id = Profile::model()->getProfileid($user_id);

		$model = new Assessment;
		
		
		$criteria=new CDbCriteria;
		//.$criteria->select='title';  // only select the 'title' column
		$criteria->condition='profile_id=:profile_id AND assessment_item_id=:item_id AND assessment_status_id !=:status_id';

		$criteria->params=array(':profile_id'=>$profile_id,':item_id'=>$_GET['item'],':status_id'=>'finished');

				$model = Assessment::model()->find($criteria);
				
				if($model===null){
					//throw new CHttpException(404,'The requested page does not exist.');
					
					
														$this->redirect(array('index','error'=>'norecord'));		   			

					} else { //UPDATE THE RECORD

						   
						$model->assessment_status_id = 'finished';
						$model->result = $_GET['result'];
							date_default_timezone_set('Asia/Jakarta');
							$model->finish_time =  date('Y/m/d h:i:s a', time());
						$model->save();
									if($model->save()) {
								$this->redirect(array('assessment/index'));
								} else {
								echo 'error';
								//print_r($model->attributes);
								}

						//echo CHtml::button('continue', array('submit' => array('assessment/index')));

						
					}
} else {
$this->redirect(array('index','error'=>'unfinished'));					  
}

?>