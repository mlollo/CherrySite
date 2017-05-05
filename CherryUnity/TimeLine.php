<!doctype html>
<html>
<head>
<?php include 'head.php' ?>
<style>

html, body {
    margin: 0;
    padding: 0;
}

nav {
	background-color: #292f36;
	width: 100%;
	height: 120px;
}

#palette {
	background-color: #292f36;
	width: 100%;
	height: 120px;
	padding-left: 30px;
}

.fixed_palette {
	position: fixed;
}

/*#palette img {
	width: 60px;	
	height: 60px;
	margin-top: 60px;
}
#palette img:hover {
	width: 120px;
	height: 120px;
	margin-top: 0;
}*/

.pic_gesture{
    transition: all 0.3s ease;
    max-width: 100%;
    width:60px;
  	height:60px;
  	margin-top: 30px;
  	overflow: auto;
}
.pic_gesture:hover{
	/*width:120px;
	height: 120px;*/
    transform:scale(2) translate(13px,0px);
}

#pic_dump{
	width : 100px;
	height : 90px;
	position: absolute;
	right:0;
	top:15px;
}

#editZone { 
	width: 100%; 
	min-height: 150px;
	background-color: #F3F1EC;
	/*position: relative;
	top:120px;*/
}
#editZone:after {
	content: ""; /* Important, sinon l'élément n'est pas généré. */
  	display: table;
  	clear: both;
}

#slide {
	width: 240px;
	height: 150px;
}

.fig_slide {
    transition: all 0.3s ease;
}

.fig_slide:focus {
    transform: translate(625px,-30px) scale(1.75);
}


.gesture {
	min-height: 120px;
	min-width: 2px;
}
.gesture img {
	width: 50px;
	height: 50px;
}
/*.gesture img:hover {
	width: 120px;
	height: 120px;
	margin-top: 0;
}*/

.word {
	float: left;
	margin-left: 0.3em;
	margin-top: 5px;
}
.line {
	clear: both;
	border-style: solid;
    border-width: 0px;
    border-top-width: 1px;
}

#button {
	text-align: center;
}
.btn_form {
	float : left;
	margin-left: 0.3em;
}

</style>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.0.min.js"></script>
<script>

var id = 0;

//Récupération de la timeline passée en post
var post = <?php echo json_encode($_POST) ?>;
var data = post.timeline;

var post_data = "";

window.onload = function()
{
    var editZone = document.getElementById("editZone");
    var lines = data.split("{{");
    for (var i=0; i<lines.length; i++){
    	//Gestion split et espaces
    	if (lines[i] != "" && lines[i] != " "){
    		createLine(editZone,lines[i]);
    	}
    }
}

$(window).scroll(function(){
    if ($(window).scrollTop() >= 0) {
       $('#palette').addClass('fixed_palette');
    }
    else {
       $('#palette').removeClass('fixed_palette');
    }
});

//Ajout d'une ligne correspondant à un slide
function createLine(editZone, data){
	var new_line = document.createElement('div');
	new_line.className = "line";
	editZone.appendChild(new_line);

	//Ajout image du slide
	var data_slide = data.split("}}");
	/*if (data_slide[0] != ""){
		var new_slide = document.createElement('img');
		new_slide.id = 'slide';
		new_slide.setAttribute('src', data_slide[0]);
		new_slide.style.float = 'left';
		new_line.appendChild(new_slide);
	}*/
	//Version avec zoom sur le slide
	if (data_slide[0] != ""){
		var new_slide = document.createElement('img');
		var new_figure = document.createElement('figure');
		new_figure.setAttribute('contenteditable', 'true');
		new_figure.className = 'fig_slide';
		new_slide.id = 'slide';
		new_slide.setAttribute('src', data_slide[0]);
		new_slide.style.float = 'left';
		new_slide.setAttribute('contenteditable','false');
		new_figure.appendChild(new_slide);
		new_line.appendChild(new_figure);
	}

	//Gestion des espaces multiples
	var data_line = data_slide[1].replace(/ +/g, " ")
	var words = data_line.split(" ");
	for (var i=0; i<words.length; i++){
		createWord(new_line,words[i]);
	}

	//Bouton pour jouer un seul slide
	var new_button = document.createElement('button');
	new_button.setAttribute('type', 'submit');
	new_button.className = 'btn btn-info';
	new_button.setAttribute('name', 'Valider');
	new_button.setAttribute('onclick', 'htmlToString()');
	new_button.style.width = '180px';
	var new_span = document.createElement('span');
	new_span.className='glyphicon glyphicon-play';
	new_span.style.marginRight = '6px';
	new_button.appendChild(new_span);
	new_button.innerHTML =  'Jouer ce slide&nbsp;&nbsp;';
	new_button.style.float = 'right';
	new_line.appendChild(new_button);
}

//Ajout du div "word" + informations
function createWord(line, data){
	var new_word = document.createElement('div');
	new_word.className = "word";
	line.appendChild(new_word);

	if (data.indexOf("[[") > -1){
		//Séparation gesture et text
		var data_tmp = data.split("]]");
		//Ajout text
		addText(new_word, data_tmp[1]);

		//Suppression "[[""
		data_tmp = data_tmp[0].split("[[");
		var img_name = data_tmp[1];
		//Ajout gesture
		var new_gesture = addGesture(new_word);
		//Ajout image
		var new_img = document.createElement('img');
		new_img.id = 'gest_' + img_name + "_on_board_" + id++;
		new_img.setAttribute('src', 'img/' + img_name + '.png');
		new_img.setAttribute('draggable', 'true');
		new_img.setAttribute('ondragstart', 'drag(event)');
		new_img.className = 'pic_gesture';
		new_gesture.appendChild(new_img);
	} else{
		//Ajout text
		addText(new_word, data);
		
		//Ajout gesture
		addGesture(new_word);
	}	
}

//Ajout du div "text"
function addText(parent, text){
	var new_text = document.createElement('div');
	new_text.className = "text";
	new_text.appendChild(document.createTextNode(text));
	parent.appendChild(new_text);
}
	
//Ajout du div "gesture"
function addGesture(parent){
	var new_gesture = document.createElement('div');
	new_gesture.className = "gesture";
	new_gesture.setAttribute('ondrop', 'drop(event)');
	new_gesture.setAttribute('ondragover', 'allowDrop(event)');
	parent.appendChild(new_gesture);

	return new_gesture;
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    if (document.getElementById(data) != null){
    	//Gestion création ou déplacement suivant la position initiale (connue grâce à l'id)
	    if (data.indexOf("_on_board") == -1){
	    	var nodeCopy = document.getElementById(data).cloneNode(true);
			nodeCopy.id = data + "_on_board_" + id++;// We cannot use the same ID
			checkAndDrop(ev, nodeCopy);
	    } else{
	    	checkAndDrop(ev, document.getElementById(data));
		}
	} else{
		ev.target.parentNode.style.background = "";
	}
}

//Gestion du drop d'une gesture (drop ou replace s'il y en a déjà une)
function checkAndDrop(ev, child){
	if (ev.target.nodeName == "IMG"){
		var parent = ev.target.parentNode;
		//Remove encore en test donc pas compatible avec tous les navigateurs (IE)
		//ev.target.remove();
		ev.target.parentNode.removeChild(ev.target);
		parent.appendChild(child);
		parent.parentNode.style.background = ""
	} else if (ev.target.nodeName == "DIV"){
		var old_gesture = ev.target.childNodes;
		for (var i=0; i<old_gesture.length; i++){
			//Remove encore en test donc pas compatible avec tous les navigateurs (IE)
			//old_gesture[i].remove();
			old_gesture[i].parentNode.removeChild(old_gesture[i]);
		}
		ev.target.appendChild(child);
		ev.target.parentNode.style.background = "";
	}
}

function dumpDrop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    if (data.indexOf("_on_board") > -1){
    	//Remove encore en test donc pas compatible avec tous les navigateurs (IE)
    	//document.getElementById(data).remove();
    	document.getElementById(data).parentNode.removeChild(document.getElementById(data));
    }
}
//TODO suppression touche delete

document.addEventListener("dragenter", function(ev) {
      if ( ev.target.className == "gesture" /*&& document.getElementById(ev.dataTransfer.getData("text")) != null*/) {
          	ev.target.parentNode.style.background = "#DEDEDD";
      	}
  	}, false);

document.addEventListener("dragleave", function(ev) {
      if ( ev.target.className == "gesture" ) {
          	ev.target.parentNode.style.background = "";
      	}
  	}, false);

function htmlToString(){
	var editZone = document.getElementById("editZone");
	var lines = editZone.childNodes;
	post_data = "";
	for (var i=0; i<lines.length; i++){
		var elems = lines[i].childNodes;
		for (var j=0; j<elems.length; j++){
			if (elems[j].className.indexOf("fig_slide") > -1){
				var img_slide = elems[j].childNodes;
				if (img_slide[0].id.indexOf("slide") > -1){
					//Ajout du string pour l'image du slide
					post_data += "{{" + img_slide[0].getAttribute("src") + "}}";
				}
			} else if (elems[j].className.indexOf("word") > -1){
				var word = elems[j].childNodes;
				var text = "";
				var gesture = "";
				for (var k=0; k<word.length; k++){
					if (word[k].className == "text"){
						text = word[k].innerHTML;
					} else if(word[k].className == "gesture" && word[k].firstChild != null){
						var gesture_src = word[k].firstChild.getAttribute("src");
						//Suppression des infos src
						gesture = gesture_src.split(".png")[0];
						gesture = gesture.split("img/")[1];
						gesture = "[[" + gesture + "]]";
					}
				}
				//Ajout du string pour les mots avec d'éventuelles gestuelles
				post_data += gesture + text + " ";
			}
		}
	}
	console.log(post_data);
	document.getElementById("timeline").value = post_data;
}
	
</script>
</head>
<body>
	<nav>
		<div id="palette">
			<img id="gest_point_arm_left_behave" class="pic_gesture" src="img/point_arm_left_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_double_me_behave" class="pic_gesture" src="img/double_me_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_left_arm_up_behave" class="pic_gesture" src="img/left_arm_up_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_head_idle_motion" class="pic_gesture" src="img/head_idle_motion.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_question_behave" class="pic_gesture" src="img/question_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_swap_behave" class="pic_gesture" src="img/swap_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_rest_open_behave" class="pic_gesture" src="img/rest_open_behave.png" draggable="true" ondragstart="drag(event)" />
			<img id="gest_torso_idle_motion" class="pic_gesture" src="img/torso_idle_motion.png" draggable="true" ondragstart="drag(event)" />
		
			<img id="pic_dump" src="img/dump.png" ondrop="dumpDrop(event)" ondragover="allowDrop(event)" />
		</div>
	</nav>

	<div id="editZone">
		
	</div>

	<div id="buttons">
		<form class="btn_form" method="post" action="TimeLine.php">
			<input id="timeline" name="timeline" hidden/>
            
            <button type="submit" class="btn btn-default" onclick="htmlToString()" style="width: 180px;">
            	<span class="glyphicon glyphicon-floppy-saved" style="margin-right: 6px;"></span>
            	Sauvegarder&nbsp;&nbsp;
            </button>

            <button type="submit" class="btn btn-success" name="Valider" onclick="htmlToString()" style="width: 180px;">
                <span class="glyphicon glyphicon-play" style="margin-right: 6px;"></span>
                Jouer ce scénario&nbsp;&nbsp;
            </button>
        </form>
	</div>

</body>
</html>
<?php
/*// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    $root = "./";
    include 'includes.php'; 
    include 'head.php';
print_r($_POST);


//EXEMPLE :
echo "<br/><br/><br/><br/><br/><br/>Exemple : Voici l'affichage de la 1ère slide :";
$images = explode("{{", $_POST['timeline']);
$images[0]="_";
//echo "<br/><br/>";print_r($images);echo "<br/><br/>";
$_images = explode("}}", $images[1]);
//print_r($_images);echo "<br/><br/>";
$img="";
for($i=0; $i<strlen($_images[0]); $i++)
{
    $img .= $_images[0][$i];
}
echo "<br/><br/><img  src='".$img."' style='height: 500px; margin-bottom: 15px;' />";
echo "<br/>lien : ".$img;

//redecoupage
echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>Redécoupage de la chaîne de caractère pour sauvegarde dans la BDD :<br/>";

$lignes = array();
$colonnes=array();
$colonnes[] = "Behave";
$colonnes[] = "Text";
$colonnes[] = "Slide";
$lignes[] = $colonnes;
$colonnes = array();
$slides = explode("{{", $_POST["timeline"]);
//print_r($slides);echo"<br/><br/>^SLIDES<br/>vSPLIT<br/>";
unset($slides[0]);
//print_r($slides);echo"<br/><br/>";
//print_r($slides);echo "<br/><br/>";
//pour chaque slide decoupe en etapes
foreach ($slides as $slide)
{
    //recuperation du diapo
    $slide = explode("}}", $slide);
    //print_r($slide); echo"<br/><br/>";
    $diapo = str_replace("http://localhost/PhpProject_test/uploads/", "", $slide[0]);
    //echo "DIAPO : ".$diapo."<br/><br/>UNE ETAPE :<br/>";
    
    //decoupe en etapes
    $etapes = explode("[[", $slide[1]);
    unset($etapes[0]);
    //print_r($etapes); echo "<br/><br/>";
    foreach ($etapes as $etape)
    {
        $etape = explode("]]", $etape);
        $etape[] = $diapo;
        //print_r($etape);echo "<br/><br/>ALL en construction : <br/>";
        $lignes[] = $etape;
        //print_r($lignes);echo "<br/><br/>";
    }
    
    
}
echo "<br/>";
$url = print_r($lignes, true);
echo $url;

//si ce contenu existe      
        //getItem
        $emailOwner = $_SESSION['email'];
        $name = $_POST['name'];
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());
        $contentDAOExist = $contentDao->get($name, $emailOwner);
        echo '<br/><br/>URL EXISTANTE :';
        //print_r($contentDAOExist);
        $contentExist = new Content();
        $contentExist = $contentDAOExist;
        $urlExist = $contentExist->getUrl();
        $typeExist = $contentExist->getType();
        $dateExistDebut = $_POST['dateDebut0'];
        $dateExistFin = $_POST['dateFin0'];
        echo '<br/><br/>';
        echo $urlExist;
        
        /*
         * MISE A JOUR
        $contentExist->setUrl($url);
        
        //alors le met a jour
                $contentDao->UpDate($content, $children);
                echo '<p>Ce contenu a été correctement mis à jour !</p><br/>';
         * 
         */