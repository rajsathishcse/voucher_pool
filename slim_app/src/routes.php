<?php
/*
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
*/


//Get the Voucher List
$app->get('/vouchers_list', function ($request, $response, $args) {
	 $sth = $this->db->prepare("SELECT v.*, o.percentage  FROM vouchers AS v 
									LEFT JOIN offers AS o ON o.offer_id = v.offer_id ORDER BY v.id");
	$sth->execute();
	$todos = $sth->fetchAll();
	return $this->response->withJson($todos);
});

// Create Dynamic Voucher Coder
$app->post('/create_voucher_code', function ($request, $response) {
	$input = $request->getParsedBody();
	$sql = "INSERT INTO vouchers SET code = '".substr(md5(rand()), 0, 8)."', created_at=NOW()";
	 $sth = $this->db->prepare($sql);
	$sth->execute();
	$input['id'] = $this->db->lastInsertId();
	return $this->response->withJson($input);
});

//Get the Voucher List
$app->get('/offers_list', function ($request, $response, $args) {
	 $sth = $this->db->prepare("SELECT * FROM offers ORDER BY offer_id");
	$sth->execute();
	$todos = $sth->fetchAll();
	return $this->response->withJson($todos);
});

// send the vouchers to users email and update DB
$app->post('/send_voucher_code', function ($request, $response) {
	$input = $request->getParsedBody();
	$id= $input['id'];
	$offer_id = $input['offer_id'];
	$user_email = $input['user_email'];
	$dt = date("Y-m-d");
	$expired_at = date("Y-m-d", strtotime( "$dt +7 day" ) );
	$voucher_url = "localhost/slim_app/public/use_voucher_code/".$input['code'];
	$sql = "UPDATE vouchers SET offer_id = $offer_id, user_email = '".$user_email."',expired_at = '".$expired_at."', voucher_url = '".$voucher_url."' WHERE id=$id";
	 $sth = $this->db->prepare($sql);
	 $output = array();
	if($sth->execute()){
		$output['result'] = "success";
	} else{	
		$output['result'] = "error";
	}
	return $this->response->withJson($output);
});
	
// send the vouchers to users email and update DB
$app->get('/use_voucher_code/[{code}]', function ($request, $response,$args) {
	$input = $request->getParsedBody();
	$code= $args['code'];
	$sql = "UPDATE vouchers SET is_used = 1, date_used = NOW() WHERE code=:code AND is_used= 0 AND expired_at >= DATE(NOW())";
	 $sth = $this->db->prepare($sql);
	 $sth->bindParam("code", $code);
	 $sth->execute();
	$sth = $this->db->prepare("SELECT * FROM vouchers WHERE code=:code AND expired_at >= DATE(NOW())");
	$sth->bindParam("code", $code);
	$sth->execute();
	$result = $sth->fetchObject();
	return $this->response->withJson($result);
});
	
