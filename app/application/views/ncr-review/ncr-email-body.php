<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title><?php echo $title; ?></title>
      <style type="text/css">
      <!--
        .headingBlack {
	        font-family: Calibri;
	        font-weight: bold;
	        font-size:16px;
        }
        .bodybold {
	        font-family: Calibri;
	        font-weight: 500;
	        font-size:16px;
        }
        .bodytext {
	        font-family: Calibri;
	        font-weight: 100;
	        font-size:16px;
        }
      -->
      </style>
    </head>


    <body bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0">
      <table width="1000" border="0" cellspacing="0" cellpadding="5">

        <tr id=header>
          <!-- <td ><img src="images/email_header.jpg" alt="Header Image" width="1000" height="83" /></td> -->
          <td ><img src="<?php echo base_url('assets/images/ncr-review-email/email_header.jpg'); ?>" alt="Header Image" width="1000" height="83" /></td>
        </tr>
        <tr id=body>
          <td class="bodytext" >
	          <p style="text-align:right">Date: <?php echo $date; ?> </p>

            <p>Dear Sir,</p>
            <p>Please find the enclosed herewith Non  Conformance Report(NCR).</p>
            <p>Kindly rectify and submit the Compliance  Report within seven working days.</p>
            <p>
              Thanks &amp; regards,<br />
              <strong>SGS India Pvt. Ltd.</strong><br />
              PMA-RDSS<br />
              MPPKVVCL, Jabalpur
            </p>
          </td>
        </tr>
        <tr id=footer>
          <!-- <td ><img src="images/email_footer.jpg" alt="Footer Image" width="1000" height="74" /></td> -->
          <td ><img src="<?php echo base_url('assets/images/ncr-review-email/email_footer.jpg'); ?>" alt="Footer Image" width="1000" height="74" /></td>
        </tr>
      </table>
    </body>
  </html>
