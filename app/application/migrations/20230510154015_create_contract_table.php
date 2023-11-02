<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_contract_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'contract_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'contractor_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'tender_award_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE
			),
			'tender_award_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'package_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE
			),
			'typeofwork_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'effective_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'completion_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'etender_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE
			),
			'bid_opening_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'price_bid_opening_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'estimated_cost_with_gst' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
 			),
 			'estimated_cost_without_gst' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => FALSE
 			),
 			'quoted_price_with_gst' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => FALSE
 			),
 			'quoted_price_without_gst' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => FALSE
 			),
 			'supply_of_goods' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => FALSE
 			),
 			'installation_other_services' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => FALSE
 			),
 			'quantity' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '7,2',
 				'null' => FALSE
 			),
 			'mobilisation_advance' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => TRUE
 			),
 			'invoice_no' => array(
 				'type' => 'VARCHAR',
 				'constraint' => 50,
 				'null' => TRUE
 			),
 			'invoice_date' => array(
 				'type' => 'DATE',
 				'null' => TRUE
 			),
 			'mobilisation_advance_adjusted' => array(
 				'type' => 'DECIMAL',
 				'constraint' => '12,2',
 				'null' => TRUE
 			),
 			'is_individual_tracking_required' => array(
 				'type' => 'BIT',
 				'null' => TRUE
 			),
 			'status_id' => array(
 				'type' => 'INT',
 				'constraint' => 11,
 				'null' => FALSE
 			),
 			'createdby' => array(
 				'type' => 'INT',
 				'constraint' => 11,
 				'null' => FALSE
 			),
 			'createddate' => array(
 				'type' => 'DATETIME',
 				'null' => FALSE
 			),
 			'modifiedby' => array(
 				'type' => 'INT',
 				'constraint' => 11,
 				'null' => TRUE
 			),
 			'modifieddate' => array(
 				'type' => 'DATETIME',
 				'null' => TRUE
 			),
 			'deletedby' => array(
 				'type' => 'INT',
 				'constraint' => 11,
 				'null' => TRUE
 			),
 			'deleteddate' => array(
 				'type' => 'DATETIME',
 				'null' => TRUE
 			)
		);

		$this->dbforge->add_field($fields);

		$this->dbforge->add_key('contract_id', TRUE);

		$this->dbforge->create_table('contract', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('contract', TRUE);
	}
}

?> 