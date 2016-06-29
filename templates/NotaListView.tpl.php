<?php
	$this->assign('title','GERA | Notas');
	$this->assign('nav','notas');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/notas.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Notas
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Pesquisar..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="notaCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nota">Nota<% if (page.orderBy == 'Nota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Avaliador">Avaliador<% if (page.orderBy == 'Avaliador') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Artigo">Artigo<% if (page.orderBy == 'Artigo') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('nota') || '') %></td>
				<td><%= _.escape(item.get('avaliador') || '') %></td>
				<td><%= _.escape(item.get('artigo') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="notaModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="notaInputContainer" class="control-group">
					<label class="control-label" for="nota">Nota</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="nota" placeholder="Nota" value="<%= _.escape(item.get('nota') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="avaliadorInputContainer" class="control-group">
					<label class="control-label" for="avaliador">Avaliador</label>
					<div class="controls inline-inputs">
						<select id="avaliador" name="avaliador"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="artigoInputContainer" class="control-group">
					<label class="control-label" for="artigo">Artigo</label>
					<div class="controls inline-inputs">
						<select id="artigo" name="artigo"></select>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteNotaButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteNotaButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Nota</button>
						<span id="confirmDeleteNotaContainer" class="hide">
							<button id="cancelDeleteNotaButton" class="btn btn-mini">Cancelar</button>
							<button id="confirmDeleteNotaButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="notaDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Editar Nota
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="notaModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancelar</button>
			<button id="saveNotaButton" class="btn btn-primary">Salvar Alterações</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="notaCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newNotaButton" class="btn btn-primary">Adicionar Nota</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
