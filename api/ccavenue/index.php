<?php 

require_once "config.php";

?>

<style>

body {

    max-width: 620px;

    margin: 20px auto;

    font-size: 0.95em;

    font-family: Arial;

}

.form-field {

    padding: 10px;

    width: 250px;

    border: #c1c0c0 1px solid;

    border-radius: 3px;

    margin: 0px 20px 20px 0px;

    background-color: white;

}

#ccav-payment-form {

    border: #c1c0c0 1px solid;

    padding: 30px;

}

.btn-payment {

    background: #009614;

    border: #038214 1px solid;

    padding: 8px 30px;

    border-radius: 3px;

    color: #FFF;

    cursor: pointer;

}

</style>

<h1>CCAvenue Payment Gateway Intgration</h1>

<div id="ccav-payment-form">

<form name="frmPayment" action="ccavRequestHandler.php" method="POST">

    <input type="hidden" name="merchant_id" value="<?php echo CCA_MERCHANT_ID; ?>"> 

    <input type="hidden" name="language" value="EN"> 

    <input type="hidden" name="amount" value="5">

    <input type="hidden" name="currency" value="INR"> 

    <input type="hidden" name="redirect_url" value="https://www.evoq.app/MDRC/ccavenue/payment-response.php"> 

    <input type="hidden" name="cancel_url" value="https://www.evoq.app/MDRC/ccavenue/payment-cancel.php"> 

    

    <div>

    <input type="text" name="billing_name"  class="form-field" Placeholder="Billing Name" value="Virag"> 

    <input type="text" name="billing_address"  class="form-field" Placeholder="Billing Address" value="Siddhivinyak Towers">

    </div>

    <div>

    <input type="text" name="billing_state"  class="form-field" Placeholder="State" value="Gujarat"> 

    <input type="text" name="billing_zip"  class="form-field" Placeholder="Zipcode" value="382350">

    </div>

    <div>

    <input type="text" name="billing_country"  class="form-field" Placeholder="Country" value="India">

    <input type="text" name="billing_tel"  class="form-field" Placeholder="Phone" value="7874806162">

    </div> 

    <div>

    <input type="text" name="billing_email"  class="form-field" Placeholder="Email" value="thedezineuser@gmail.com">

    </div>

    <div>

    <button class="btn-payment" type="submit">Pay Now</button>

    </div>

</form>

</div>