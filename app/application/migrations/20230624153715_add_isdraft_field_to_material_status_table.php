<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_isdraft_field_to_material_status_table extends CI_Migration
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
				'after' => 'offer_letter_date' 
			)
		);

		$this->dbforge->add_column('material_status', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('material_status', 'is_draft');
	}
}
?>