<?php
	session_start();
?>

<?php
	$code = $_GET['code'];

	if($code == ""){
		header('Location: http://localhost/PBKwSI');
		exit;
	}

	$clientId = "e7c717a2e4b9c8d9d1d1";
	$clientSecretKey = "a576f94bf24b27bfa949b7686cb57ab82992a4ee";
	$url = "https://github.com/login/oauth/access_token";

	$postParams = [
		'client_id' => $clientId,
		'client_secret' => $clientSecretKey,
		'code' => $code
	];


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept: application/json'));

	$response = curl_exec($ch);

	curl_close($ch);
	$data = json_decode($response, true);

	if($data['access_token'] != ""){
		session_start();
		$_SESSION['accessToken'] = $data['access_token'];
		header('Location: http://localhost/PBKwSI');
		exit;
	}

?>