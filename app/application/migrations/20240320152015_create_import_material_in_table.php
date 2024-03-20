<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_import_material_in_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'import_material_in_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'null' => FALSE
			),
			'import_hdr_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'lot_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			),
			'circle' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE
			),
			'material_description' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => FALSE
			),
			'unit' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE
			),
			'name_of_vendor' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'di_no' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE
			),
			'di_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'di_quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
			),
			'received_quantity' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => FALSE
			),
			'received_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			),
			'error_message' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'is_valid' => array(
				'type' => 'BIT',
				'null' => TRUE
			),
			'is_active' => array(
				'type' => 'BIT',
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

		$this->dbforge->add_key('import_material_in_id', TRUE);

		$result = $this->dbforge->create_table('import_material_in', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('import_material_in', TRUE);
	}
}

?>