<?php session_start() ?>
<!doctype html>
<html>
    
<head>
    <?php include 'head.php' ?>
    <title>Connection </title>
    <style type="text/css">
        body {
            font-family: Helvetica, Verdana, Arial, sans-serif;
            background-color: white;
            color: black;
            text-align: center;
        }
        
        a{
            text-align: center;
        }
        a:link, a:visited {
            color: #000;
        }
        a:active, a:hover {
            color: #666;
        }
        th, td {
    border-bottom: 1px solid #ddd;
}
		.medical {
			margin-left: 100px;
			margin-top: 100px;
		}
		.familial {
			margin-left: 200px;
			margin-top: 100px;
		}
		.pedagogique {
			margin-left: 300px;
			margin-top: 100px;
		}
		th {
    background-color: #4CAF50;
    color: white;
}
		tr:hover {background-color: #f5f5f5}
		td {
    		 height: 30px;
    		 vertical-align: bottom;
    		 text-align: left;
}
    </style>
</head>

<body>
    <?php include 'nav.php'; 
    	  include "includes.php";?>
    <h1>Menu</h1>

    <?php
    	$childDao = new ChildDAO(LocalDBClientBuilder::get());
        $email = $_SESSION['email'];
        $child = $childDao->get($email);
        $contentsFamilial = $child->getContentByType("family");
        $contentsPedagogique = $child->getContentByType("teacher");
        $contentsMedical = $child->getContentByType("doctor");
        $test = $child->readContent("azerty", 'teacher');
        echo $test;
        
        if(count($contentsMedical)>0)
        {
            echo '<table class="medical">
            		<tr>
            			<th>Contenu medical</th>
            		</tr>';
            foreach ($contentsMedical as $contentM)
            {
                if(strcasecmp(substr($contentM['M']['name']['S'], -3), 'txt') == 0 || strcasecmp(substr($contentM['M']['name']['S'], -3), 'jpg') == 0 
            		|| strcasecmp(substr($contentM['M']['name']['S'], -4), 'jpeg') == 0 || strcasecmp(substr($contentM['M']['name']['S'], -3), 'png') == 0
            		|| strcasecmp(substr($contentM['M']['name']['S'], -3), 'doc') == 0|| strcasecmp(substr($contentM['M']['name']['S'], -4), 'docx') == 0
            		|| strcasecmp(substr($contentM['M']['name']['S'], -3), 'odt') == 0|| strcasecmp(substr($contentM['M']['name']['S'], -3), 'mp3') == 0 )
            	{
            		echo "<tr>
                		<td>".$contentM['M']['name']['S'].' : '
                            . '&nbsp;&nbsp;&nbsp;<a href="uploads/'.$contentM['M']['name']['S'].'">Voir le fichier</a>'."</td>
                	  </tr>";
            	} else {
            		$length = count($contentsMedical);
				        for ($i = 0; $i < $length; $i++) {
				            $e = $contentsMedical[$i];
				            if ($e['M']['name']['S'] == $contentM['M']['name']['S']) {
				        		//TODO
				                break;
				            }
				        }
            		echo "<tr>
                		<td>".$contentP['M']['name']['S']." TODO afficher texte !</td></tr>";
            	}
            }
            echo "</table";
        }
        if(count($contentsFamilial)>0)
        {
            echo '<table class="familial">
            		<tr>
            			<th>Contenu familial</th>
            		</tr>';
            foreach ($contentsFamilial as $contentF)
            {
            	if(strcasecmp(substr($contentF['M']['name']['S'], -3), 'txt') == 0 || strcasecmp(substr($contentF['M']['name']['S'], -3), 'jpg') == 0 
            		|| strcasecmp(substr($contentF['M']['name']['S'], -4), 'jpeg') == 0 || strcasecmp(substr($contentF['M']['name']['S'], -3), 'png') == 0
            		|| strcasecmp(substr($contentF['M']['name']['S'], -3), 'doc') == 0|| strcasecmp(substr($contentF['M']['name']['S'], -4), 'docx') == 0
            		|| strcasecmp(substr($contentF['M']['name']['S'], -3), 'odt') == 0|| strcasecmp(substr($contentF['M']['name']['S'], -3), 'mp3') == 0 )
            	{
            		echo "<tr>
                		<td>".$contentF['M']['name']['S'].' : '
                            . '&nbsp;&nbsp;&nbsp;<a href="uploads/'.$contentF['M']['name']['S'].'">Voir le fichier</a>'."</td>
                	  </tr>";
            	} else {
            		$length = count($contentsFamilial);
				        for ($i = 0; $i < $length; $i++) {
				            $e = $contentsFamilial[$i];
				            if ($e['M']['name']['S'] == $contentF['M']['name']['S']) {
				        		//TODO
				                break;
				            }
				        }
            		echo "<tr>
                		<td>".$contentF['M']['name']['S']." TODO afficher texte !</td></tr>";
            	}
            }
            echo "</table";
        }
        if(count($contentsPedagogique)>0)
        {
            echo '<table class="pedagogique">
            		<tr>
            			<th>Contenu pedagogique</th>
            		</tr>';
            foreach ($contentsPedagogique as $contentP)
            {
            	if(strcasecmp(substr($contentP['M']['name']['S'], -3), 'txt') == 0 || strcasecmp(substr($contentP['M']['name']['S'], -3), 'jpg') == 0 
            		|| strcasecmp(substr($contentP['M']['name']['S'], -4), 'jpeg') == 0 || strcasecmp(substr($contentP['M']['name']['S'], -3), 'png') == 0
            		|| strcasecmp(substr($contentP['M']['name']['S'], -3), 'doc') == 0|| strcasecmp(substr($contentP['M']['name']['S'], -4), 'docx') == 0
            		|| strcasecmp(substr($contentP['M']['name']['S'], -3), 'odt') == 0|| strcasecmp(substr($contentP['M']['name']['S'], -3), 'mp3') == 0 )
            	{
            		echo "<tr>
                		<td>".$contentP['M']['name']['S'].' : '
                            . '&nbsp;&nbsp;&nbsp;<a href="uploads/'.$contentP['M']['name']['S'].'">Voir le fichier</a>'."</td>
                	  </tr>";
            	} else {
            		$length = count($contentsPedagogique);
				        for ($i = 0; $i < $length; $i++) {
				            $e = $contentsPedagogique[$i];
				            if ($e['M']['name']['S'] == $contentP['M']['name']['S']) {
				        		//TODO
				                break;
				            }
				        }
            		echo "<tr>
                		<td>".$contentP['M']['name']['S']." TODO afficher texte !</td></tr>";
            	}
            	
            }
            echo "</table";
        }
     //include 'footer.php' ?>

</body>
</html>