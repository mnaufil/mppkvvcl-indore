<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_reportedby_reporteddate_fields_from_physical_progress_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'reported_by' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'reported_date' => array(
				'type' => 'DATE',
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('physical_progress', $fields);
	}

	public function down()
	{
		$fields = array(
			'reported_by' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE
			),
			'reported_date' => array(
				'type' => 'DATE',
				'null' => FALSE
			)
		);

		$this->dbforge->modify_column('physical_progress', $fields);
	}
}


?>