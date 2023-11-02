<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_gst_field_to_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'GST' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE,
				'after' => 'installation_other_services'
			)
		);

		$this->dbforge->add_column('contract', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract', 'GST');
	}
}
?>