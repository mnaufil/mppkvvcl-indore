<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Drop_srno_field_from_contract_mobilisation_log_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->drop_column('contract_mobilisation_log', 'sr_no');
	}

	public function down()
	{
		$fields = array(
			'sr_no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'after' => 'contract_id'
			)
		);

		$this->dbforge->add_column('contract_mobilisation_log', $fields);
	}
}


?>