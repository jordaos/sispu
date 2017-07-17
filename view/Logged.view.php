<?php
	$modeloDemanda->validarDadosFormulario();
	$modeloCategoria->validarDadosFormulario();
	$modeloApoiar->Apoiar($this->parametros);
	$modeloComentario->validarDadosComentario();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<base href="">
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_css/estilo.css">



	<!-- MAPS -->
	<script type="text/javascript">
		function initMarkers(map){
			var allMarkers = [];
			<?php
				foreach ($modeloDemanda->listaDemandas() as $value) {
					echo "var array = ".json_encode($value).";\n";
					echo "var comentarios = ".json_encode($modeloComentario->listarComentariosDemanda($value['codigo'])).";\n";
					echo "allMarkers.push(addMarker(map, array, comentarios));\n";
				}
			?>
			return allMarkers;
		}
		function addMarker(map, array, comentarios){
			var lat = parseFloat(array["latitude"]);
			var lng = parseFloat(array["longitude"]);
			var marker = new google.maps.Marker({       
			    position: {lat: lat, lng: lng}, 
			    map: map,  // google.maps.Map 
			    title: array["descricao"],
			    icon: "<?php echo CATEGORIAS_URI;?>/"+array["icone"]  
			});

			google.maps.event.addListener(marker, 'click', function() { 
			    $("#abt_titulo").text(array["descricao"]);
			    $("#abt_imagem").attr("src","<?php echo UPLOAD_URI;?>/"+array["foto"]);
			    $("#qtdApoiadores").text(array["COUNT(A.codigo_demanda)"]);
			    $("#codDemandaShow").val(array["codigo"]);
			    $("#demandaShowComentario").val(array["codigo"]);

			    count = 0;
			    var coment = "";
			    while(comentarios[count]){
			    	coment += "<div class=\"div_Comentario\">";
					coment += "<div class=\"div_comentarioUsuario\">";
					coment += "<label>"+comentarios[count]['nome']+"</label>";
					coment += "<p>"+comentarios[count]['mensagem']+"</p>";
					coment += "</div>";
					coment += "</div>";

			    	count++;
			    }
			    $(".div_caixaComentarios").html(coment);

			    $("#verPonto").addClass("dialog--open");
			}); 

			return marker;
		}
	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_css/maps.css" />

	<!-- DIALOG -->
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_css/dialog-sally.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI;?>/view/_css/novo.css">	
	<script src="<?php echo HOME_URI;?>/view/_js/modernizr.custom.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="menu">
			<div class="row">
				<div class="col-lg-2">
					<a href="#" class="itens">
						<img src="<?php echo HOME_URI;?>/view/_img/inicio.png">
						<span>Início</span>
					</a>
				</div>
				<div class="col-lg-2">
					<a href="#" class="itens">
						<img src="<?php echo HOME_URI;?>/view/_img/saiba.png">
						<span>Saiba</span>
					</a>
				</div>

				<div class="col-lg-2">
						<img src="<?php echo HOME_URI;?>/view/_img/sispu.png" class="logo">
				</div>
				<div class="col-lg-2">
					<a href="#" class="itens">
						<img src="<?php echo HOME_URI;?>/view/_img/sugestao.png">
						<span>Sugestões</span>
					</a>
				</div>
				<div class="col-lg-2">
					<a href="#" class="itens">
						<img src="<?php echo HOME_URI;?>/view/_img/indique.png">
						<span>Indicações</span>
					</a>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<?php echo $modeloDemanda->form_msg;?>
			<?php echo $modeloApoiar->form_msg;?>
			<div class="mapa" id="map"></div>
			<div class="menuLateral">
				<div class="lateral">
					<div id="caixaSubMenu">
						<div class="subMenus">
							<div>
								<label>Categorias <img src="<?php echo HOME_URI.'/view/_img/icons/add.png'; ?>" style="width:30px; height: 30px; cursor: pointer;" id="bnt_addCategoria"/></label>
								<?php echo $modeloCategoria->form_msg;?>
							</div>
<?php
	foreach ($modeloCategoria->listarCategorias() as $categoria) {
		echo '<div class="itensLateral">';
		echo '<img src="'.CATEGORIAS_URI.'/'.$categoria->getIcone().'" class="icon">';
		echo '<span>'.$categoria->getNome().'</span>';
		echo '</div>';
	}
?>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>

	<!--MAPS-->
	<!-- HTML DIALOG-->
		<div id="selecionarPonto" class="dialog">
			<div class="dialog__overlay"></div>
			<div class="dialog__content">
				<h2>Sugerir ponto</h2>
				<form action="" method="POST" enctype="multipart/form-data">
					<label>Rua: <input type="TEXT" name="rua"></label>
					<label>Local sugerido: <input type="TEXT" id="localSugerido" name="bairro" readonly></label>
					<label>Categoria:
					<select name="categoria">
						<option>Selecione</option>
<?php
	foreach ($modeloCategoria->listarCategorias() as $categoria) {
		echo "<option value=\"".$categoria->getCodigo()."\">".$categoria->getNome()."</option>";
	}
?>
					</select>
					</label>
					<label>Foto: <input type="FILE" name="imagem" accept="image/*"></label>
					<label>Motivo: <textarea name="descricao"></textarea></label>
					<input type="HIDDEN" id="latitude" name="latitude"/>
					<input type="HIDDEN" id="longitude" name="longitude"/>
					<input type="HIDDEN" name="formname" value="demanda"/>
					<input type="BUTTON" value="Cancelar" data-dialog-close style="background: #5d5656;">
					<input type="submit" value="Enviar">
				</form>
			</div>
		</div>

		<div id="verPonto" class="dialog">
			<div class="dialog__overlay1"></div>
			<div class="dialog__content">
				<h2 id="abt_titulo">Título do Ponto</h2>
				<h5><b id="qtdApoiadores">0</b> apoiadores</h5>
				<img src="images/default.png" class="imageSolicitacao" id="abt_imagem">
				<input type="BUTTON" value="Apoiar" id="apoiar" />
				<input type="HIDDEN" id="codDemandaShow">
				<div class="div_caixaComentarios">
					
				</div>

				<form action="" method="POST">
					<div class="escreverComentario">
						<input type="HIDDEN" id="demandaShowComentario" name="demanda"/>
						<textarea name="mensagem" style="float: left; width: 400px; max-width: 400px;"></textarea>
						<input type="HIDDEN" name="formname" value="comentario"/>
						<input type="submit" value="Comentar">
					</div>
				</form>	
			</div>
		</div>

		<div id="addCategoria" class="dialog">
			<div class="dialog__overlay2"></div>
			<div class="dialog__content">
				<h2>Adicionar nova categoria</h2>
				<form action="" method="POST" enctype="multipart/form-data">
					<label>Nome da categoria: <input type="TEXT" name="nome"></label>
					<label>Foto: <input type="FILE" name="imagem" accept="image/*"></label>
					<input type="HIDDEN" name="formname" value="categoria"/>
					<input type="BUTTON" value="Cancelar" data-dialog-close2 style="background: #5d5656;">
					<input type="submit" value="Enviar">
				</form>
			</div>
		</div>

		<!-- jQuery -->
		<script src="<?php echo HOME_URI;?>/view/_js/jquery.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$("#bnt_addCategoria").click(function(){
					$("#addCategoria").addClass("dialog--open");
				});
			});
		</script>

		<!-- GoogleNexusMenu -->
		<script src="<?php echo HOME_URI;?>/view/_js/classie.js"></script>
		<script src="<?php echo HOME_URI;?>/view/_js/gnmenu.js"></script>
		<script>
			new gnMenu( document.getElementById( 'gn-menu' ) );
		</script>
		<!-- END - GoogleNexusMenu -->

		<!-- MAPS -->
		<script type="text/javascript" src="<?php echo HOME_URI;?>/view/_js/qxCoords.js"></script>
		<script type="text/javascript" src="<?php echo HOME_URI;?>/view/_js/mapa.js"></script>
    	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEzs2VBneFsppT7t1xHZp5DJ7Nqbxeg9o&callback=initMap"></script>
    	<!-- END - MAPS -->

    	<!-- DIALOG -->
		<script>
		$(document).ready(function(){
			var close = document.querySelector( '[data-dialog-close]');
			var overlay = document.querySelector( '.dialog__overlay');
			$(close).add(overlay).click(function(){
				$("#selecionarPonto").removeClass("dialog--open");
			});

			var close1 = document.querySelector( '[data-dialog-close1]');
			var overlay1 = document.querySelector( '.dialog__overlay1');
			$(close1).add(overlay1).click(function(){
				$("#verPonto").removeClass("dialog--open");
			});


			var close2 = document.querySelector( '[data-dialog-close2]');
			var overlay2 = document.querySelector( '.dialog__overlay2');
			$(close2).add(overlay2).click(function(){
				$("#addCategoria").removeClass("dialog--open");
			});
		});
		</script>

		<!-- APOIAR -->
		<script>
			$(document).ready(function(){
				$("#apoiar").click(function(){
					var codDemandaShow = $("#codDemandaShow").val();
					$(location).attr("href", "<?php echo HOME_URI;?>/home/apoiar/"+codDemandaShow)
				});
			});

		</script>
</body>
</html>