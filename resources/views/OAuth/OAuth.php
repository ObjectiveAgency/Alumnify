<script type="text/javascript">
    code = window.location.href;
    code = code.slice(0,code.indexOf("?"));
    document.cookie = "uri=" + code;
</script>
<?php 
   
    if(!empty($_COOKIE['uri'])){


    $uri = $_COOKIE['uri'];
    list(,$code) = explode("=",$_SERVER['REQUEST_URI']);
    $url = "https://login.mailchimp.com/oauth2/token";
    $data = "grant_type=authorization_code&client_id=277274991059&client_secret=c4e402cc790c57ec9fb69081a5bb042e&redirect_uri={$uri}&code={$code}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 
    $response = curl_exec($ch);
   
    curl_close($ch);
    $response = json_decode($response);
    
    
        
   echo "<pre>";  
   $token = $response->access_token;
   echo gettype($token);
   echo "</pre>";

$accounts = App\User::find(1);
$accounts->Oauth = $token;
$accounts->update();
}