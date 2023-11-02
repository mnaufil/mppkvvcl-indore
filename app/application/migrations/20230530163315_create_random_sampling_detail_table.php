<?php   defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_random_sampling_detail_table extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'random_sampling_detail_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE
            ), 
            'material_status_detail_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ), 
            'circle_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
            'sampling_quantity' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => FALSE
            ),
            'sampling_serial_nos' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ), 
            'sampling_date' => array(
                'type' => 'DATE',
                'null' => FALSE
            ), 
            'sampling_letter_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ), 
            'sampling_lab_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ), 
            'accepted_report_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ), 
            'accepted_report_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'accepted_quantity' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
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

        $this->dbforge->add_key('random_sampling_detail_id', TRUE);

        $this->dbforge->create_table('random_sampling_detail', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('random_sampling_detail', TRUE);
    }
}



?>