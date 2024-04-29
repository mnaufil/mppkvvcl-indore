<?php 	defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Migration_Update_fields_of_integration_staging_RDSS_invoice_detail_table extends CI_Migration
{
	function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$fields = array(
			'INVOICE_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'INVOICE_NUM' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'INVOICE_DATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'CREATION_DATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'INVOICE_AMOUNT' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'AMOUNT_PAID' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'INVOICE_CATEGEORY' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'INVOICE_TYPE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'ORG_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'OU_NAME' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'VENDOR_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'VENDOR_CODE' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'VENDOR_NAME' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'VENDOR_SITE_CODE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'VOUCHER' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'INVOICE_DESCRIPTION' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'GL_DATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'PAYMENT_TERMS' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'PAYMENT_STATUS_FLAG' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'PAYMENT_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'VALIDATION_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'ACCOUNTED_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'APPROVAL_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'TERM_DATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'SOURCE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'BALANCE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'LAST_PAYMENT_DATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'ATTRIBUTE_CATEGORY' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'CONTRACT_NUMBER' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'SCHEME_CODE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'GST_TAX' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'LIN_TAX' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'TDS_GST_AMT' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'TDS_IT_AMT' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'CONTRACT_DESCRIPTION' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'BG_ADVANCE_TYPE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'CREDIT_INVOICE_NUM' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'CREDIT_INVOICE_AMT' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'PO_HEADER_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'PROJECT_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'SYSDATE' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'integration_datetime' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'processed_datetime' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('integration_staging_RDSS_invoice_detail', $fields);
	}

	public function down()
	{
		$fields = array(
			'INVOICE_ID' => array(
				'type' => 'varchar',
				'constraint' => 45,
				'null' => TRUE
			),
			'INVOICE_NUM' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => TRUE
			),
			'INVOICE_DATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'CREATION_DATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'INVOICE_AMOUNT' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'AMOUNT_PAID' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'INVOICE_CATEGEORY' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'INVOICE_TYPE' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'ORG_ID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'OU_NAME' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'VENDOR_ID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'VENDOR_CODE' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE
			),
			'VENDOR_NAME' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'VENDOR_SITE_CODE' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'VOUCHER' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE
			),
			'INVOICE_DESCRIPTION' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'GL_DATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'PAYMENT_TERMS' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'PAYMENT_STATUS_FLAG' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'PAYMENT_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'VALIDATION_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'ACCOUNTED_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'APPROVAL_STATUS' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'TERM_DATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'SOURCE' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'BALANCE' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'LAST_PAYMENT_DATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'ATTRIBUTE_CATEGORY' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'CONTRACT_NUMBER' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'SCHEME_CODE' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'GST_TAX' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'LIN_TAX' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'TDS_GST_AMT' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'TDS_IT_AMT' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'CONTRACT_DESCRIPTION' => array(
				'type' => 'VARCHAR',
				'constraint' => 1000,
				'null' => TRUE
			),
			'BG_ADVANCE_TYPE' => array(
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE
			),
			'CREDIT_INVOICE_NUM' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'CREDIT_INVOICE_AMT' => array(
				'type' => 'DECIMAL',
				'constraint' => '12,2',
				'null' => TRUE
			),
			'PO_HEADER_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'PROJECT_ID' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			),
			'SYSDATE' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'integration_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'processed_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => TRUE
			)
		);

		$this->dbforge->modify_column('integration_staging_RDSS_invoice_detail', $fields);
	}
}

?>