<?php 
   if(empty($_SESSION['username']))
    {
        die('<script type="text/javascript">setTimeout(function(){ location.href = "/login/" },0);</script>');
    }
?>