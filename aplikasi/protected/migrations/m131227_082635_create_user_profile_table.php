<?php

class m131227_082635_create_user_profile_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', array (

		`id` int(255) NOT NULL AUTO_INCREMENT,

`username` varchar(255) NOT NULL,

`password` varchar(255) NOT NULL,

`validation_code` varchar(10) NULL,

`status` varchar(255) NOT NULL COMMENT 'Inactive statuses:\r\nUNVALIDATED\r\nUNVALIDATED_REMOVED\r\nVALIDATED_REMOVED\r\nVALIDATED_DISABLED\r\n\r\nActive statuses:\r\nVALIDATED_INCOMPLETE : aktif tapi data registrasi belum komplit\r\nVALIDATED : status aktif biasa\r\nVALIDATED_PENDING : aktif namun masih menunggu sesuatu',

`created` date NULL,

PRIMARY KEY (`id`) ,

UNIQUE INDEX `username,id,status` (`username`, `id`, `status`)
		), 'ENGINE=InnoDB');
	}

	public function down()
	{
		echo "m131227_082635_create_user_profile_table does not support migration down.\n";

		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}