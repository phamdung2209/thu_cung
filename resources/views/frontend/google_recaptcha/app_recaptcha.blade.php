<html>

<head>
  <style type="text/css">
  *{
margin:0;
padding:0;
}
      html, body {
        overflow: hidden;
      }
      </style>
      
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<form action='?' method='POST'>
    <div id="ff" style='height: 600px; width:2000px;' class='g-recaptcha' data-sitekey="{{ env('CAPTCHA_KEY') }}"
        data-callback='captchaCallback' data-expired-callback='expiredCaptchaCallback' data-size='normal'></div>
</form>
<script>
    function captchaCallback(response) {
        if ( Captcha != 'undefined') {
          console.log(response);
            Captcha.postMessage(response);
          Captcha1.postMessage("1235");
        }
    }
  
    function expiredCaptchaCallback(response) {
      console.log("error");
            Captcha.postMessage("");
        
    }
  
  
  
 setInterval(captchaShow,2000);
 
  function captchaShow(){
    var data =  document.querySelectorAll("[style*='visibility: visible; z-index: 2000000000;']");
    
   CaptchaShowValidation.postMessage(data.length==1);

    }

</script>
</body>

</html>
