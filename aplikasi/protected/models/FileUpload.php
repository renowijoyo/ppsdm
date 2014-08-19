<?php

class FileUpload extends CFormModel
{
    public $image;
	public $doc;

    public function rules()
    {
        return array(
           array('image', 'file', 'allowEmpty' => false, 'safe'=>true,'types' => 'jpg, jpeg, gif, png','maxSize'=>1024 * 1024 * 1, 'tooLarge'=>'File has to be smaller than 1MB'),
		 //  array('doc', 'file', 'allowEmpty' => false, 'safe'=>true,'types' => 'doc'),
        );
    }


	}
	
	?>