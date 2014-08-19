<?php
 
return array(

    'attributes' => array(
        'enctype' => 'multipart/form-data',
    ),
 
    'elements' => array(
        'image' => array(
            'type' => 'file',
        ),
    ),
	
	
 
   'buttons' => array(
   
   //     'reset' => array(
     //       'type' => 'reset',
       //     'label' => 'Reset',
        //),
		
        'submit_profile_photo' => array(
            'type' => 'submit',
			'label' => 'Rubah gambar',

			
        ),

    ),
	
);

?>
