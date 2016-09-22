<?php

use \DrewM\MailChimp\MailChimp;//mailchimp namespace

//query to mailchimp

/**
*the varible $exclude is a @param in mailchimp API please visit(http://developer.mailchimp.com/documentation/mailchimp/guides/get-started-with-mailchimp-api-3/#parameters) for more info
*/

$MailChimp = new MailChimp('dfd2a41d52f4fef742def6bbc43b78b9-us14');

$resource = 'lists/6852212594/members'; // test id folder members


function NewMemdata($data){
        $data = array("email_address"=>"",
                      "status"=>"",//subcribed, unsubscribed, cleaned, pending
                      "merge_fields"=>array(
                                      "FNAME"=>"",//first name
                                      "MNAME"=>"",//optional
                                      "LNAME"=>"",//last name
                                      "ADDRESS"=>array(
                                                  "addr1"=>"#97 Purok 2",
                                                  "addr2"=>"Brgy. Basud, West District",
                                                  "city"=>"Sorsogon City",
                                                  "state"=>"Sorsogon",
                                                  "zip"=>"4700",
                                                  "country"=>"Philippines"
                                        )
                                      )

                        );


        $result = $MailChimp->post($resource,$data);

        return $result;

}




//var data(array) is the data to be converted to json, it will be put into $arg var in mailchimp wrapper




echo "<pre>";

var_export($result); 

echo "</pre>";

?>

