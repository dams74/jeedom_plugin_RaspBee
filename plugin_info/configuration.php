<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}

$ch = curl_init('http://10.0.0.19/api');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
'Content-Type: application/json',                                                                                
'Content-Length: ' . strlen($data_string))                                                                       
);  
//curl_setopt($ch, CURLOPT_POSTFIELDS,   $data_string );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');

$result = curl_exec($ch);
$json = json_decode($result, true);
print_r($json);
curl_close($ch);
?>
<form class="form-horizontal">
    <fieldset>
	<legend><i class="fa fa-list-alt"></i> {{Passerelle}}</legend>
        <div class="form-group">
            <label class="raspbeeGWRefresh col-lg-4 control-label">{{Adresse IP du pont RaspBEE}}</label>
            <div class="col-lg-2">
                <input class="configKey form-control" id="raspbeeGWIP" data-l1key="raspbeeIP" />				
            </div>		
			<div class="col-lg-5">
				<a class="btn btn-success tooltips" id="bt_searchRaspBEE" title="{{Cherche la première passerelle RaspBee sur le réseau}}"><i class="fa fa-refresh"></i></a>
			</div>			
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">{{Clé API RaspBEE}}</label>
			<div class="col-lg-2">
                <input class="configKey form-control" data-l1key="raspbeeAPIKEY" value="80" />
            </div>
			<div class="col-lg-5">
				<a class="btn btn-info tooltips" id="bt_raspbeeGETNEWKEY" title="{{Demande une nouvelle cléf API}}"><i class="fa fa-refresh"></i></a>
			</div>		
        </div>
	<legend><i class="fa fa-list-alt"></i> {{Général}}</legend>
	<div class="form-group">
		<label class="col-lg-4 control-label">{{Supprimer automatiquement les périphériques exclus de la passerelle}}</label>
		<div class="col-lg-3">
			<input type="checkbox" class="configKey" data-l1key="autoRemoveExcludeDevice" />
		</div>
	</div>
  </fieldset>
</form>
<script>

	$('#bt_searchRaspBEE').on('click', function () {			
	$.ajax({
		url : 'https://dresden-light.appspot.com/discover',
		type : 'GET',
		dataType : 'json',
		success : function(resp, statut){
			$('#raspbeeGWIP').val(resp[0].internalipaddress+":"+resp[0].internalport);
		},
		error : function(resp, statut, erreur){
		$('#md_modal2').dialog({title: "{{Erreur RaspBEE}}"});
		$('#md_modal2').html('Aucune passerelle RaspBEE ne peut être trouvée<br>'+resp).dialog('open');	
       }		
    });
	
	
});
	
	
</script>
