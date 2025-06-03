$(function(){

	 //   $.toast("success", 'This is a  toast.');

	/* $.toast({
        type : "success",
        autoDismiss: false,
        message: 'This is a  toast.'
      });*/
	  
	  
	 


})


function stagechange(stageVal)
{
	if(stageVal=="")
	{
		callToast("error", "Please select Stages");
	}
}

function checkdateformat(dateVal, inputElement, rowIndex)
{
	//var dateReplace = dateVal.replace("/", "-");
	//alert(dateVal);
	if(dateVal=="")
	{
		return;
	}
	
	 var axtualVal = moment(dateVal, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' );
		//alert("axtualVal="+axtualVal);
		  $("#"+inputElement+rowIndex).attr("data-date",axtualVal);
	
		
		//alert("#"+inputElement+rowIndex);
	//$("#"+inputElement+rowIndex).val(axtualVal);
	var pattern =/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;
	if(!pattern.test(dateVal))
	{
		//$("#"+inputElement+rowIndex).val('');
		callToast("error", "Date format should be dd-mm-yyyy");
	}
	else if(inputElement == 'dynamicdatepickerstage')
	{
		 $.ajax({url: baseUrl+"checkdatelessthan/"+inputElement+"/"+rowIndex+"/"+axtualVal, success: function(result){
					
					if(result != "")
					{
						$("#"+inputElement+rowIndex).val('');
						$("#"+inputElement+rowIndex).attr("data-date",'');
						callToast("error", result);
					}
					
					}});
	}

	//$("#"+inputElementId+rowIndex).val("dsdsd");
}
function checknumber(inputVal)
{

	if(isNaN(inputVal))
	{
		callToast("error", "Please enter the numeric value");
	}

}
function callToast(type, message)
{
	$.toast({
        type : type,
        autoDismiss: true,
        autoDismissDelay: 3000,
        message: message
      });
}

function checkquoteprice(inputVal, inputElement, rowIndex)
{
	var quotedPriceWithGST =$("#quotedPriceWithGST").val();
	//alert(quotedPriceWithGST);
	if(quotedPriceWithGST =='' && quotedPriceWithGST==0)
	{
		callToast("error", "Quoted price (GST) is showing empty");
		return;
	}
	else
	{
		if(isNaN(inputVal))
		{
			$("#"+inputElement+rowIndex).val('');
			callToast("error", "Please enter the numeric value");
		}
		else if(parseInt(inputVal) > parseInt(quotedPriceWithGST))
		{
			$("#"+inputElement+rowIndex).val('');
			callToast("error", "Entered amount is greater than Contract price (GST)");
		}
		else
		{
			 $.ajax({url: baseUrl+"checkquotedpricewithgst/", success: function(result){
						
						var totalAmount = parseInt(result) + parseInt(inputVal);
						//alert("total result="+totalAmount);
						if(totalAmount >  quotedPriceWithGST )
						{
							$("#"+inputElement+rowIndex).val('');
							callToast("error", "Total entered amount is greater than Contract price (GST)");
						}
					}});
		}
	}
	
}


function checkquantity(inputVal, inputElement, rowIndex)
{
	var quantity =$("#quantity").val();

	if(quantity =='' && quantity==0)
	{
		callToast("error", "Quantity(No. of feeders / Sub Stations) is showing empty");
		return;
	}
	else
	{
		if(isNaN(inputVal))
		{
			$("#"+inputElement+rowIndex).val('');

			callToast("error", "Please enter the numeric value");
		}
		else if(parseInt(inputVal) > parseInt(quantity))
		{
			$("#"+inputElement+rowIndex).val('');
			callToast("error", "Entered quantity is greater than Quantity(No of feeders)");
		}
		else
		{
			 $.ajax({url: baseUrl+"checkquantity/", success: function(result){
						
						var totalAmount = parseInt(result) + parseInt(inputVal);
						//alert("total result="+totalAmount);
						if(totalAmount >  quantity )
						{
							$("#"+inputElement+rowIndex).val('');
							callToast("error", "Total entered quantity is greater than Quantity(No of feeders)");
						}
					}});
		}
	}
}



function checkquotepricewithoutgst(inputVal)
{
	var quotedPriceWithoutGST =$("#quotedPriceWithoutGST").val();
	//alert(quotedPriceWithGST);
	if(quotedPriceWithoutGST =='' && quotedPriceWithoutGST==0)
	{
		callToast("error", "Quoted price (without GST) is showing empty");
		return;
	}
	else
	{
		if(isNaN(inputVal))
		{
			callToast("error", "Please enter the numeric value");
		}
		else if(parseInt(inputVal) > parseInt(quotedPriceWithoutGST))
		{
			callToast("error", "Entered amount is greater than Contract price (without GST)");
		}
		else
		{
			 $.ajax({url: baseUrl+"checkquotedpricewithoutgst/", success: function(result){
						
						var totalAmount = parseInt(result) + parseInt(inputVal);
						//alert("total result="+totalAmount);
						if(totalAmount >  quotedPriceWithoutGST )
						{
										callToast("error", "Total entered amount is greater than Contract price (without GST)");
						}
					}});
		}
	}
	
}


function addContract()
{
	//alert("add cntract");
	$.ajax({url: baseUrl+"checkcontractstagecount/", success: function(result){
						
						if(result==0)
						{
							callToast("error", "Please add atlease one Stage");
							return;
						}
						else
						{
							$("#addContract").submit()
						}
					}});
}


function showboq(workId)
{

	 $.ajax({url: baseUrl+"typeofworkboq/"+workId, success: function(result){
						$("#boq-modal-text").text($("#typeOfWork option:selected").text());	
						$("#boqtoadd").html(result);
					}});
}

function showboqedit(workId, contractId)
{
	
	 $.ajax({url: baseUrl+"typeofworkboqedit/"+workId+"/"+contractId, success: function(result){
						$("#boq-modal-text").text($("#typeOfWork option:selected").text());	
						$("#boqtoadd").html(result);
					}});
}



function saveboq()
{
	var data = $('#boqform').serialize();
	 $.ajax({
         type: "POST",
         url: baseUrl+"saveboq",
         //data: {name: 'John'},
         data: data,
         success: function(data){
         console.log(data);
         callToast("success", "Boq's Added Successfully");
         $("#boq-modal").modal("hide");
         },
         error: function(xhr, status, error){
         console.error(xhr);
         }
        });
}


function saveboqedit()
{
	var data = $('#boqform').serialize();
	// console.log(data); return false;
	 $.ajax({
         type: "POST",
         url: baseUrl+"saveboqedit",
         //data: {name: 'John'},
         data: data,
         success: function(data){
         console.log(data);
         callToast("success", "Boq's Updated Successfully");
         $("#boq-modal").modal("hide");
         },
         error: function(xhr, status, error){
         console.error(xhr);
         }
        });
}


function addcontractprice()
{
	var installationServices = $("#installationServices").val();
	var supplyOfGoods = $("#supplyOfGoods").val();

	if(installationServices=="" || installationServices==0)
	{
		callToast("error", "Please enter Installation Services");	
		return;
	}


	if(installationServices.length > 12)
	{
		$("#installationServices").focus();
		callToast("error", "Entered characters length exceeded. Max limit is "+charLength+" characters");	
		return;

	}


	if(supplyOfGoods=="" || supplyOfGoods==0)
	{
		callToast("error", "Please enter Supply of Goods");	
		return;
	}
	
		var totalContractPriceWithoutGST = parseInt(installationServices) + parseInt(supplyOfGoods);
		$("#quotedPriceWithoutGST").val(totalContractPriceWithoutGST);

}


function addcontractpricewithgst()
{
	var gst = $("#gst").val();
	if(gst.length > 12)
	{
		$("#gst").focus();
		callToast("error", "Entered characters length exceeded. Max limit is "+charLength+" characters");	
		return;

	}

	var quotedPriceWithoutGST = $("#quotedPriceWithoutGST").val();
	var totalContractPriceWithGST = parseInt(gst) + parseInt(quotedPriceWithoutGST);
	$("#quotedPriceWithGST").val(totalContractPriceWithGST);
}


function showmodal(rowId, feeder_id)
{
	var workId = $("#typeOfWork").val();
	 $.ajax({url: baseUrl+"checkrowboq/"+rowId+"/"+workId+"/"+feeder_id, success: function(result){
	 	// console.log(result); return false;
						//$("#boq-modal-text").text($("#typeOfWork option:selected").text());	
	 	//alert(result)
	 				if(result != '')
	 				{
	 					$('#boq-modal').find('#feeder_id').val(feeder_id);
						$("#boqtoadd").html(result);
	 				}
	 				else
	 				{
	 					$(".addinputsboq").val('');
			           
	 				}
	 				 $("#boq-modal").modal("show");
					}});

	
}

function charlimit(elementId, charLength)
{
	
	var elementVal= $("#"+elementId).val();
	if(elementVal.length > charLength)
	{
		$("#"+elementId).focus();
		callToast("error", "Entered characters length exceeded. Max limit is "+charLength+" characters");	

	}
}

function ValidateEmail(mail) 
{
	
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
  {
	  
    return (true)
  }
  $("#email").val('');
   // alert("You have entered an invalid email address!")
    callToast("error", "You have entered an invalid email address!");	

}


function charlimitwithrow(inputVal, elementId, rowIndex, charLength)
{
	
	//var elementVal= $("#"+elementId+rowIndex).val();
	//alert(inputVal);
	if(inputVal.length > charLength)
	{
		$("#"+elementId+rowIndex).focus();
		callToast("error", "Entered characters length exceeded. Max limit is "+charLength+" characters");	

	}
}


function intOnly(elementId, inputValue)
{	

	if(inputValue=="")
	{
		$("#"+elementId).val('');
		callToast("error", "Only Integers value accepted");	
	}
	if(isNaN(inputValue))
	{
		$("#"+elementId).focus();
		callToast("error", "Only Integers value accepted");	

	}
}

function checkDate(elementId, inputValue)
{

	if(elementId=="effectiveDate")
	{
		var completionDate = $("#completionDate").val();
		var tenderAwardDate = $("#tenderAwardDate").val();
		var effectiveDateVal = new Date(changeFormat(inputValue));
		var completionDateVal = new Date(changeFormat(completionDate));
		var tenderAwardDateVal = new Date(changeFormat(tenderAwardDate));

		if(effectiveDateVal > completionDateVal)
		{
			$("#"+elementId).val('');
			callToast("error", "Effective Date is Greater than Completion Date");	
		}
		if(tenderAwardDateVal > effectiveDateVal)
		{
			$("#"+elementId).val('');
			callToast("error", "Contract Date is Greater than Effective Date");	
		}
	}

	if(elementId=="completionDate")
	{
		var effectiveDate = $("#effectiveDate").val();
		var completionDateVal = new Date(changeFormat(inputValue));
		var effectiveDateVal = new Date(changeFormat(effectiveDate));

		if(completionDateVal < effectiveDateVal)
		{
			$("#"+elementId).val('');
			callToast("error", "Completion Date is less than Effective Date");	
		}
	}
}

function changeFormat(formatDate)
{
	var explodeDate = formatDate.split("-");
	var newDate = explodeDate[2]+"-"+explodeDate[1]+"-"+explodeDate[0];
	return newDate;
}



function checkDateWithRow(elementIdwithout, inputValue, rowIndex)
{
	var elementId = elementIdwithout+rowIndex;
	if(elementIdwithout=="dynamicbgvaliddatebank")
	{
		var bgDate = $("#dynamicbgdatebank"+rowIndex).attr('data-date');

		var bgValidDate = $("#"+elementId).val();
		//var bgDateVal = new Date(changeFormat(bgDate));
		//var bgValidDateVal = new Date(changeFormat(bgValidDate));
		var bgDateVal = moment(bgDate, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' );
		var bgValidDateVal = moment(bgValidDate, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' );
		bgDateVal = bgDateVal.replace("-", "/");
		bgValidDateVal = bgValidDateVal.replace("-", "/");
		if(bgValidDateVal < bgDateVal)
		{
			$("#"+elementId).val('');
			$("#"+elementId).attr('data-date', 'DD-MM-YYYY');	
			callToast("error", "BG Till Date is less than BG Date");	
		}
		
	}

	if(elementIdwithout=="dynamicbgdatebank")
	{
		var bgValidDate = $("#dynamicbgvaliddatebank"+rowIndex).attr('data-date');
		
		var bgDate = $("#"+elementId).val();
		 var bgDateVal = moment(bgDate, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' );
		//var bgDateVal = new Date(changeFormat(bgDate));
				

	//	var bgValidDateVal = new Date(changeFormat(bgValidDate));
		var bgValidDateVal = moment(bgValidDate, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' );
		bgDateVal = bgDateVal.replace("-", "/");
		bgValidDateVal = bgValidDateVal.replace("-", "/");

		if(bgDateVal > bgValidDateVal)
		{
			$("#"+elementId).val('');
			$("#"+elementId).attr('data-date', 'DD-MM-YYYY');	
			callToast("error", "BG Date is greater than BG valid Date");	
		}
		
	}




}


function requiredvalid(validtype, fieldid, fieldValue, rowIndex, database_id = null)
{
	if(validtype=="stage")
	{
		//alert("fieldid="+fieldid+"fieldValue ="+fieldValue.trim());
		if(fieldid=="dynamicstages")
		{
			var stageType =fieldValue.trim();
			if(stageType == "" || stageType == "Select Stages")
			{
				callToast("error", "Please select stage");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicdatepickerstage")
		{
			var stageDate = fieldValue.trim();
			//alert("stageDate="+stageDate);
			if(stageDate=="" || stageDate=="DD-MM-YYYY")
			{
				callToast("error", "Please select Date");
				$("#"+fieldid+rowIndex).val();
				return false;	
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicqtystage")
		{
			var stageQty = fieldValue.trim();
			//alert("stageDate="+stageDate);
			if(stageQty=="")
			{
				callToast("error", "Please Enter Quantity");
				$("#"+fieldid+rowIndex).val();
				return false;	
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicamountstage")
		{
			var stageAmount = fieldValue.trim();
			//alert("stageDate="+stageDate);
			if(stageAmount=="")
			{
				callToast("error", "Please Enter Amount");
				$("#"+fieldid+rowIndex).val();
				return false;	
			}
			else
			{
				return true;
			}
		}		
	}
	
	if(validtype=="region")
	{
		if(fieldid=="dynamicregion")
		{
			var regionRegion =fieldValue.trim();
			if(regionRegion == "" || regionRegion == "Select Region")
			{
				callToast("error", "Please select Region");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamiccircleregion")
		{
			var regionCircle =fieldValue.trim();
			if(regionCircle == "" || regionCircle == "Select Circle")
			{
				callToast("error", "Please select Circle");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicdivisionregion")
		{
			var regionDivision =fieldValue.trim();
			if(regionDivision == "" || regionDivision == "Select Division")
			{
				callToast("error", "Please select Divisions");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamiclocationregion")
		{
			var regionLocation =fieldValue.trim();
			if(regionLocation == "")
			{
				callToast("error", "Please select Location");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicfeedernameregion")
		{
			var regionFeederName =fieldValue.trim();
			if(regionFeederName == "")
			{
				callToast("error", "Please select Feeder  Name");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}
		
		if(fieldid=="dynamicfeederidregion")
		{
			var regionFeederId = fieldValue.trim();

			if (regionFeederId != '') {
				duplicateFeederCheck(regionFeederId, database_id).done(function(response) {
					if (response.duplicacy_check) {
						callToast("error", "Feeder ID already exist");			
						return false;
					}
				});
			} else if (regionFeederId == "") {
				callToast("error", "Please select Feeder  ID");	
				$("#"+fieldid+rowIndex).val();
				return false;
			} else {
				return true;
			}
		}
		
		if(fieldid=="dynamicprojectidregion")
		{
			var regionProjectId =fieldValue.trim();
			if(regionProjectId == "")
			{
				callToast("error", "Please select Project ID");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}
		
		if(fieldid=="dynamicqtyregion")
		{
			var regionQuantity =fieldValue.trim();
			if(regionQuantity == "")
			{
				callToast("error", "Please select Quantity");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	if(validtype=="bank")
	{
		if(fieldid=="dynamictype")
		{
			var banktype =fieldValue.trim();
			if(banktype == "" || banktype == "Select Bank Type")
			{
				callToast("error", "Please select Bank Type");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicbgno")
		{
			var bgno =fieldValue.trim();
			if(bgno == "")
			{
				callToast("error", "Please enter BG Number");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicbgdate")
		{
			var bgdate =fieldValue.trim();
			if(bgdate == "" || bgdate=="DD-MM-YYYY")
			{
				callToast("error", "Please enter BG Date");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicbgamount")
		{
			var bgamount =fieldValue.trim();
			if(bgamount == "")
			{
				callToast("error", "Please enter BG Amount");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicbank")
		{
			var bank =fieldValue.trim();
			if(bank == "")
			{
				callToast("error", "Please enter Bank");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}

		if(fieldid=="dynamicvalidtill")
		{
			var validtill =fieldValue.trim();
			if(validtill == "" || validtill=="DD-MM-YYYY")
			{
				callToast("error", "Please enter BG Valid date");	
				$("#"+fieldid+rowIndex).val();
				return false;
			}
			else
			{
				return true;
			}
		}
	}
}

function duplicateFeederCheck(feederID, database_id) {
	// Ajax Call to check if feederID alredy exist
	return $.ajax({
		type: 'POST',
		url: baseUrl + 'check-feeder-duplicacy',
		dataType: 'json',
		data: {feeder_id:feederID, contract_location_id:database_id},
		success: function(response) {},
		error: function(xhr, status, error) {
			console.log(xhr);
		}
	});
}

