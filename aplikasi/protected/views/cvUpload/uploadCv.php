<?php
 
return array(

    'attributes' => array(
        'enctype' => 'multipart/form-data',
    ),
 
    'elements' => array(
		'doc' => array(
			'type' => 'file',
		),
    ),
	
	
 
   'buttons' => array(
   
   //     'reset' => array(
     //       'type' => 'reset',
       //     'label' => 'Reset',
        //),
		
        'submit_cv' => array(
            'type' => 'submit',
			'label' => 'upload CV',

			
        ),

    ),
	
);

?>
