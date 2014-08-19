<?php

class CvUpload extends CFormModel
{
  //  public $image;
	public $doc;

    public function rules()
    {
        return array(
         //  array('image', 'file', 'allowEmpty' => false, 'safe'=>true,'types' => 'jpg, jpeg, gif, png'),
		  array('doc', 'file', 'allowEmpty' => false, 'safe'=>true,'types' => 'doc, xls, docx, xlsx,pdf'),
        );
    }


	}
	
	?>