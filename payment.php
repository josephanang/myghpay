<?php session_start();
if(isset($_REQUEST['payamount'])) {

        $payamount=$_REQUEST['payamount'];     
		$shopname="aviance";
        $myghpayamount= $payamount;		
		$myghpayitemname= $_REQUEST['myghpayitemname'];
		$myghpayclientref=uniqid("av");		  
		$myghpayclientsecret="7675de07-c446-407a-80fa-a455c4274df5";  
		$myghpayclientid="8612aeef-d00d-6084-9a1c-429e4784d285";     
		//$myghpaybaseurl="https://196.216.228.23/myghpayclient/"; 
    $myghpaybaseurl="https://myghpay.com/myghpayclient/"; 
		$myghpayreturnurl="https://localhost/response.php";    
		$myghpaysecurehash="21dede66190431ae3c53a6b091f9b582";
		 
        $txnid = $myghpayclientref.'_'.date("ymds");
        $_SESSION['txnid'] = $txnid;       

        $productinfo = $myghpayitemname;		
		$redirect_url =$myghpayreturnurl;
		
		$str = $myghpayclientsecret.$myghpayclientref.$myghpayclientid;
        $hash = hash('sha512', $str);
		
		$redirect_url = $redirect_url ."?txnid=".$txnid."&orderkey=".$hash; 

    $raw_string=$myghpayamount.'&'.$productinfo.'&'.$myghpayclientref.'&'.$myghpayclientsecret.'&'.$myghpayclientid;

    $secure_hash=hash_hmac('sha256', $raw_string,$myghpaysecurehash);    

        $myghpay_args = array(
          'amount' => $myghpayamount,
          'itemname' => $productinfo,
          'clientref' => $myghpayclientref,
          'clientsecret' => $myghpayclientsecret,
          'clientid' => $myghpayclientid,
          'returnurl' => $redirect_url,
          'securehash'=>$secure_hash
          );
		  
        $myghpay_args_array = array();
        foreach($myghpay_args as $key => $value){
          $myghpay_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
        }
        echo '<form action="'.$myghpaybaseurl.'" method="post" id="myghpay_payment_form">
            ' . implode('', $myghpay_args_array) . '
            <input type="submit" class="button-alt" id="submit_myghpay_payment_form" value="Submit" type="hidden"/>
            </form>';
} 

	
?>

<!DOCTYPE html>
<html>
<head>
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

input#submit_myghpay_payment_form {
    display: none !important;
}
</style>
</head>
<body>
<center style="margin-top:5%;">
     

<div class="loader"></div>
<p>Thank you for your order, redirecting...please wait.</p>
    
</center>
 

<script type="text/javascript">
    document.getElementById('myghpay_payment_form').submit();
</script>
</body>
</html>
