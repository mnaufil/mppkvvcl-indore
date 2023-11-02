<?php   defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_material_status_detail_table extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'material_status_detail_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE
            ), 
            'material_status_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ), 
            'material_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => FALSE
            ), 
            'offer_letter_quantity' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => FALSE
            ), 
            'date_of_readiness' => array(
                'type' => 'DATE',
                'null' => TRUE
            ), 
            'pdi_letter_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ), 
            'pdi_letter_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ), 
            'inspection_letter_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ), 
            'inspection_letter_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ), 
            'inspecting_agency_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ), 
            'date_of_inspection' => array(
                'type' => 'DATE',
                'null' => TRUE
            ), 
            'material_serial_nos' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ), 
            'di_material_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ), 
            'di_material_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ), 
            'di_quantity' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => TRUE
            ), 
            'mrc_generated_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ), 
            'mrc_generated_date' => array(
                'type' => 'DATE',
                'null' => FALSE
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

        $this->dbforge->add_key('material_status_detail_id', TRUE);

        $this->dbforge->create_table('material_status_detail', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('material_status_detail', TRUE);
    }
}



?>