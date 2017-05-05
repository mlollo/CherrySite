<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
 /*browser starts executing the received code only after receiving 1kb of chunk data. So we need to send 1kb data before we send real code for execution.*/
        $p = "";  //padding
        for ($i=0; $i < 1024; $i++) { 
            $p .= " "; //we can send any character, here we are sending white space.
        };
        echo $p;

        ob_flush();
        flush();

        /*Now we will send update code to iframe whenever an update is available. Below code is just an example.*/
        for ($i = 0; $i < 10000; $i++) {
            ?>
              <script>
                 parent.document.getElementById("update").innerHTML = "<?php echo $i; ?>";
              </script>
            <?php
            ob_flush();
            flush();
            sleep(2);
        }

?>