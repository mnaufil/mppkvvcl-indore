<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isdraft_field_to_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'is_draft' => array(
				'type' => 'BIT',
				'null' => FALSE,
				'after' => 'remark' 
			)
		);

		$this->dbforge->add_column('physical_progress', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('physical_progress', 'is_draft');
	}
}
?>