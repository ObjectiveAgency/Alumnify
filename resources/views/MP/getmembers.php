<?php

use \DrewM\MailChimp\MailChimp;//mailchimp namespace

//query to mailchimp

/**
*the varible $exclude is a @param in mailchimp API please visit(http://developer.mailchimp.com/documentation/mailchimp/guides/get-started-with-mailchimp-api-3/#parameters) for more info
*/
$user = App\User::find(1);
echo gettype($user->OAuth);


$MailChimp = new MailChimp($user->OAuth);
$resource = 'lists/6852212594/members'; //this is not yet dynamic. the {id} "the pure number in the url is the list campaigns name". means I still need to put it on variable
$exclude = array(
  "exclude_fields"=>'members._links,_links'
  );

$result = $MailChimp->get($resource,$exclude);//data result;



//get fields: Email, Name, Address and other merge fields
//please make sure that you rendered a right Mailchimp variable before using this function
function getMember_fields($data){

  for($i=0;$i<(int)$data['total_items'];$i++){ // the array 'total_items' is mailchimp return json data of how many subcribers are inside  
  	$id = $data['members'][$i]['id'];
    $name = $data['members'][$i]['email_address'];
    $members[$name] = array("id"=>$id,
    	"merge_fields"=>$data['members'][$i]['merge_fields']);
  }

  return $members;//return array of data

}


echo "<pre>";
$arr = getMember_fields($result); //example of the function call
dd($arr);
//dd($result);
echo "</pre>";

?>

