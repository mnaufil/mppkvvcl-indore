<?php   defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Create_mst_sampling_lab_table extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'sampling_lab_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE
            ), 
            'lab_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
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

        $this->dbforge->add_key('sampling_lab_id', TRUE);

        $this->dbforge->create_table('mst_sampling_lab', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('mst_sampling_lab', TRUE);
    }
}



?>