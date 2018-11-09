<?php 

namespace App\Library;

// Server file
class PushNotification {
	// (Android)API access key from Google API's Console.
	private $API_ACCESS_KEY = 'AAAAMqAy60U:APA91bEpG0-bDWItb3Szl9FKcHm94bk6KDqI1fxuByW0bzrP9pWXlFn3esSeTZL4GloJt9nBzo6e80gJGTFO0D3kIgstc_T_nglrGISd-qN3Gd9Myin1MbZ42Cteqbx29bRCkqV0WIZa';
	
	// (iOS) Private key's passphrase.
	private $passphrase = 'joashp';
	
	// Change the above three vriables as per your app.
	public function __construct() {
		//exit('Init function is not allowed');
	}
	
        // Sends Push notification for Android users
	public function sendNotification($fcm_message, $reg_id) {
		$fcmFields = array(
		    'registration_ids' => is_array($reg_id) ? $reg_id : array($reg_id),
		    'priority' => 'high',
		    'notification' => $fcm_message
		);

		$headers = array(
		    'Authorization: key=' . $this->API_ACCESS_KEY,
		    'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fcmFields));
		
		$result = curl_exec($ch);

		print_r($result);

		curl_close($ch);
	}
	
    // Sends Push notification for iOS users
	public function iphone($data, $devicetoken) {
		$deviceToken = $devicetoken;
		$ctx = stream_context_create();
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => $data['mtitle'],
                'body' => $data['mdesc'],
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message successfully delivered' . PHP_EOL;
	}    
}