<?php
$json_class = $app->load_module("JSON");
$obj_json = new $json_class(JSON_LOOSE_TYPE);
$html = '';
$MainWallet = $app->getGetVar("MainWallet");
$PromoWallet = $app->getGetVar("PromoWallet");
$_SESSION['promo_wallet_use'] = 0;
$_SESSION['wallet_use'] = 0;
$total1 = $_SESSION['sub_total'] + $_SESSION['collection_charge'] - $_SESSION['discount'];
if ($PromoWallet == 'Yes' && $total1 > 0) 
{
	if ($total1 > $_SESSION['MarwadiCust_promoWallet']) {
		$_SESSION['promo_wallet_use'] = $_SESSION['MarwadiCust_promoWallet'];
	} else {
		$_SESSION['promo_wallet_use'] = $total1;
	}
	$_SESSION['promo_wallet_check'] = 'Yes';
} 
else 
{
	$_SESSION['promo_wallet_check'] = 'No';
}
$total2 = $_SESSION['sub_total'] + $_SESSION['collection_charge'] - $_SESSION['discount'] - $_SESSION['promo_wallet_use'];
if ($MainWallet == 'Yes' && $total2 > 0) 
{
	if ($total2 > $_SESSION['MDRCCust_wallet']) {
		$_SESSION['wallet_use'] = $_SESSION['MDRCCust_wallet'];
	} else {
		$_SESSION['wallet_use'] = $total2;
	}
	$_SESSION['wallet_check'] = 'Yes';
} else {
	$_SESSION['wallet_check'] = 'No';
}
$_SESSION['total'] = $_SESSION['sub_total'] + $_SESSION['collection_charge'] - $_SESSION['discount'] - $_SESSION['promo_wallet_use'] - $_SESSION['wallet_use'];
$display_sub_total = $app->utility->moneyFormatIndia($_SESSION['sub_total']);
$display_collection_charge = $app->utility->moneyFormatIndia($_SESSION['collection_charge']);
$display_discount = $app->utility->moneyFormatIndia($_SESSION['discount']);
$display_promo_wallet_use = $app->utility->moneyFormatIndia($_SESSION['promo_wallet_use']);
$display_wallet_use = $app->utility->moneyFormatIndia($_SESSION['wallet_use']);
$display_total = $app->utility->moneyFormatIndia($_SESSION['total']);
$html = '';
$html .= '<table class="table">
			<tbody>';
$html .= '<tr>
			<th>Subtotal</th>
			<td><span class="prc">' . $display_sub_total . '</span></td>
		</tr>';
if ($_SESSION['homeCollection'] == 'Yes') {
	if ($_SESSION['collection_charge'] <= 0) {
		$display_collection_charge = 'FREE';
	}
	$html .= '<tr>
				<th>Sample collection charges</th>
				<td><span class="prc text-blue">' . $display_collection_charge . '</span></td>
			</tr>';
}
if ($_SESSION['discount'] > 0) {
	$html .= '<tr>
				<th>Discount</th>
				<td><span class="prc">-' . $display_discount . '</span></td>
			</tr>';
}
if ($_SESSION['wallet_use'] > 0) {
	$html .= '<tr>
				<th>Wallet</th>
				<td><span class="prc">-' . $display_wallet_use . '</span></td>
			</tr>';
}
$html .= '<tr class="tpayable">
			<th>Total Payable</th>
			<td><span class="prc">' . $display_total . '</span></td>
			<input type="hidden" id="total" value="'.$_SESSION['total'].'">
		</tr>';
	if(($_SESSION['payment_type'] == 'ONLINE' && $_SESSION['min_price_amount'] > 0)) 
	{
		$minDis='';
	}
	else
	{
		$minDis='display:none';
	}
	if($_SESSION['min_price_amount'] > 0) 
	{
		$html .= '<tr class="tpayable min_price_info" style="'.$minDis.'">
		<th>Advance Payment<br><span class="text-success"><sub>Minimum Amount '.$app->utility->moneyFormatIndia($_SESSION['min_price_amount']).'</sub></span><input type="hidden" id="default_min_price" value="'.$_SESSION['min_price_amount'].'"></th>
		<td><input type="number" class="form-control" min="'.$_SESSION['min_price_amount'].'" max="'.$_SESSION['total'].'" id="min_price" value="'.$_SESSION['min_price_amount'].'"></td>
		</tr>
		<tr class="tpayable min_price_info" style="'.$minDis.'">
			<th>Balance Due Before Test</th>
			<td><span class="prc" id="due_amount">'.$app->utility->moneyFormatIndia($_SESSION['total'] - $_SESSION['min_price_amount']).'</span></td>
		</tr>';
	}


$html .= '</tbody>
		</table>';
echo $obj_json->encode(array("RESULT" => $html));
