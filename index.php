<?php
session_start();
//ini_set("display_errors", 0);
$indexPage = new IndexPage();
$indexPage->drawFacebookInit();
$indexPage->drawMain();

class IndexPage {
	// Facebook
	public $facebook;
	public $uid;
	public $u_name;
	public $accessToken;
	public $userProfile;

	function IndexPage() {
	}
	
	function drawFacebookInit() {
		// Initialization
		require_once("facebook.php");
	
		$config = array();
		$config['appId'] = '209110992586136';
		$config['secret'] = '931867bb52f7efac546c391e2c7d314b';
		//$config['fileUpload'] = false;								// optional
	
		$this->facebook = new Facebook($config);
		$this->accessToken = $this->facebook->getAccessToken();
		
		// Get User Id
		$this->uid = $this->facebook->getUser();
		$this->userProfile = $this->facebook->api('/me', 'GET');
	
		// Get User Name
		$this->u_name = $this->getUserNameById($this->uid);
		//echo 'facebook name = '.$this->u_name;
	
		// Check Like Button
		//$signedRequest = $this->facebook->getSignedRequest();
	
		echo $this->uid.' - '.$this->utf8_to_cp1251($this->u_name).'<br/>';
		
		// Create Application Access Token
		$app_access = "https://graph.facebook.com/oauth/access_token?client_id=209110992586136&client_secret=931867bb52f7efac546c391e2c7d314b&grant_type=client_credentials";
		$app_access_token = file_get_contents($app_access);
		// If we have a user who is logged in, create access_token with session.
		//if ($this->uid)
			//$access_token = $_SESSION['fb_209110992586136_access_token'];
		//$access_token = $session['access_token'];
		
		echo $app_access_token.' - '.$this->accessToken.'<br/>';
	}
	
	function drawMain() {
		echo '<a href="?mod=publish">publish<br/></a>';
		
		if($_GET['mod'] == 'publish'){
			echo 'Publish';
		
			if($this->uid){
				$msg_body = array (
					//'message' => 'Test',
					//'picture ' => 'http://img1.liveinternet.ru/images/attach/b/0/10189/10189692_12681838.gif',
					//'link ' => 'http://nvtech.kiev.ua/showroom/face_detect/faceDetect.swf',
					//'access_token' => $this->accessToken,
					//'type' => 'swf',
					//'source' => 'http://nvtech.kiev.ua/showroom/face_detect/faceDetect.swf',
					//'description' => 'some text'
						'type'=> 'video',
						'source'=> 'http://www.youtube.com/watch?v=0RLGQ5w1fCY',
						'picture'=> 'http://img1.liveinternet.ru/images/attach/b/0/10189/10189692_12681838.gif',
						'name'=> 'Facebook Dialogs',
						'caption'=> 'Reference Documentation',
						'description'=> 'Using Dialogs to interact with users.',
				);
				
				$postResult = $this->facebook->api('/me/feed/', 'post', $msg_body);
				
				//var_dump($postResult);
				
				/*$video_title = 'test title';
				$video_desc = 'test desc';
				$post_url = "https://graph-video.facebook.com/me/videos?"
				    . "title=" . $video_title. "&description=" . $video_desc 
				    . "&". $this->accessToken;
				
				echo $post_url;
				
				echo '<form enctype="multipart/form-data" action=" '.$post_url.' "  
				     method="POST">';
				echo 'Please choose a file:';
				echo '<input name="file" type="file">';
				echo '<input type="submit" value="Upload" />';
				echo '</form>';*/
				
			}
		}
	}
	
	// Facebook
	function getUserNameById($_id) {
		$facebookUrl = "https://graph.facebook.com/".$_id;
		$str = file_get_contents($facebookUrl);
		$result = json_decode($str);
		return $result->name;
	}
	
	function showApp($_uid, $_u_name){
		echo '<div id="game_embed_container">';
		echo '<embed
				id="game_object"
				width="800px"
				height="800px"
				name="FacebookGame"
				wmode="transparent"
				allowfullscreen="true"
				FlashVars="userFacebookId='.$_uid.'&userName='.$_u_name.'"
				src="app/FacebookGame.swf"
				type="application/x-shockwave-flash"
			/>';
		echo '</div>';
	}
	
	// Helpers
	function utf8_to_cp1251($s){
		if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "UTF-8") {
			for ($c = 0; $c < strlen($s); $c++){
				$i = ord($s[$c]);
				if ($i <= 127)
					$out.=$s[$c];
				if ($byte2){
					$new_c2 = ($c1&3) * 64 + ($i&63);
					$new_c1 = ($c1 >> 2)&5;
					$new_i = $new_c1*256+$new_c2;
					if ($new_i == 1025){
						$out_i = 168;
					}else{
						if ($new_i == 1105){
							$out_i = 184;
						}else{
							$out_i = $new_i-848;
						}
					}
					$out .= chr($out_i);
					$byte2 = false;
				}
				if( ($i >> 5) == 6 ){
					$c1 = $i;
					$byte2 = true;
				}
			}
			return $out;
		}else{
			return $s;
		}
	}
}