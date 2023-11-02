<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_isactive_field_from_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('physical_progress', 'is_active');
	}

	public function down()
	{
		$fields = array(
			'is_active' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'remark'
			)
		);

		$this->dbforge->add_column('physical_progress', $fields);
	}
}


?>