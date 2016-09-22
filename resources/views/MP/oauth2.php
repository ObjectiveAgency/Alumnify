<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Javascript XMLhttprequest Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  </head>
  <body>
		<h1 id="h1">I'm a header!</h1>
		<pre><p id="result"></p></pre>
  </body>
  <script>


 var  httpRequest = new XMLHttpRequest();
var url = 'https://us9.api.mailchimp.com/schema/3.0/Batches/Create.json';
  document.getElementById("h1").onclick = makeRequest;


  function makeRequest(url) {
   

    if (!httpRequest) {
      alert('Giving up :( Cannot create an XMLHTTP instance');
      return false;
    }
    alert(url);
    httpRequest.onreadystatechange = function(){
    				document.getElementById("result").innerHTML = httpRequest.getAllResponseHeaders() + httpRequest.responseText;
    };
    httpRequest.open('GET', url,true);
    httpRequest.setRequestHeader('Content-Type','application/json');
    httpRequest.send();
  }



  </script>
</html>