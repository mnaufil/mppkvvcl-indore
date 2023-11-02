<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Add_bgbank_field_to_contract_bg_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'bg_bank' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'after' => 'bg_amount'
			)
		);

		$this->dbforge->add_column('contract_bg', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('contract_bg', 'bg_bank');
	}
}
?>