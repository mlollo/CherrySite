<?php
if (empty($root)) {
    $root = './';
}
?>

<footer class="footer" height= 37px;>
    <div class="container-fluid" style="text-align: center;">
        <img  height="50px" src=<?php echo $root."img/logo_cherry.png" ?> /> 
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
<script src=<?php echo $root."js/bootstrap.min.js"; ?>></script>
<script src ="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script src=<?php echo $root."js/validator.js"; ?>></script>
