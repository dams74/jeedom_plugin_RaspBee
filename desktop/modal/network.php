<?php
/* This file is part of Plugin RaspBEE for jeedom.
 *
 * Plugin RaspBEE for jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Plugin RaspBEE for jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Plugin RaspBEE for jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
	throw new Exception('401 Unauthorized');
}
require_once dirname(__FILE__) . '/../../core/class/RaspBEECom.class.php';
$raspbeecom = new RaspBEECom;
		$RaspBEEConfJson = json_decode($raspbeecom->getConf());
		//print_r(get_object_vars($RaspBEEConfJson));
		//print_r($RaspBEEConfJson);
		//echo "debut :".$RaspBEEConfJson->apiversion;
?>
<script type="text/javascript" src="plugins/openzwave/3rdparty/vivagraph/vivagraph.min.js"></script>
<style>

</style>
<div id='div_networkRaspBEEAlert' style="display: none;"></div>
<div class='network' nid='' id="div_templateNetwork">
    <div class="container-fluid">
        <div id="content">
            <ul id="tabs_network" class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#summary_network" data-toggle="tab"><i class="fa fa-info-circle"></i> {{Informations}}</a></li>
                <li id="tab_users"><a href="#api_users" data-toggle="tab"><i class="fa fa-user"></i> {{Utilisateurs}}</a></li>
            </ul>
            <div id="network-tab-content" class="tab-content">
                <div class="tab-pane active" id="summary_network">
                    <br>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="panel-title">{{Informations de la passerelle RaspBEE}}</h4></div>
                        <div class="panel-body">
							<p>{{Nom}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->name;
							?>
							</span></p>
							<p>{{ID Modèle}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->modelid;
							?>
							</span></p>
                            <p>{{Version}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->swversion;
							?>
							</span></p>								
                            <p>{{UUID}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->uuid;
							?>
							</span></p>								
							<p>{{ID bridge RaspBEE}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->bridgeid;
							?>
							</span></p>							
                            <p>{{Port Websocket}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->websocketport;
							?>							
                            <p>{{Canal ZigBEE}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->zigbeechannel;
							?>
							</span></p>
                            <p>{{Clé API RaspBEE}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo config::byKey('raspbeeAPIKEY','RaspBEE');
							?>
							</span></p>							
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="panel-title">{{Etat}}</h4></div>
                        <div class="panel-body">

                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="panel-title">{{Réseau}}</h4></div>
                        <div class="panel-body"><lu style="font-size : 1em;"></span></p>
                            <p>{{Adresse IP}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->ipaddress.' ('.$RaspBEEConfJson->netmask.')';
							?>
							</span></p>
                            <p>{{Gateway}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->gateway;
							?>
							</span></p>
                            <p>{{Adresse MAC}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->mac;
							?>
							</span></p>								
						</div>
                    </div>
					<div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="panel-title">{{Wifi}}</h4></div>
                        <div class="panel-body"><lu style="font-size : 1em;"></span></p>
                            <p>{{Etat}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->wifi;
							?>
							</span></p>
							<p>{{SSID}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->wifiname;
							?>
							</span></p>
                            <p>{{Adresse IP}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->wifiip;
							?>
							</span></p>
                            <p>{{Canal}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->wifichannel;
							?>
							</span></p>
                            <p>{{Type}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->wifitype;
							?>
							</span></p>							
						</div>
                    </div>					
                    <div class="panel panel-primary">
                        <div class="panel-heading"><h4 class="panel-title">{{Système}}</h4></div>
                        <div class="panel-body">
                            <p>{{Heure}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->localtime;
							?>
							</span></p>							
                            <p>{{Format de l'heure}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->timeformat;
							?>
							</span></p>							
                            <p>{{TimeZone}} <span class="label label-default" style="font-size : 1em;">
							<?php
							echo $RaspBEEConfJson->timezone;
							?>
							</span></p>							
                        </div>
                    </div>
                </div>
                <div id="api_users" class="tab-pane">
                    <br/>
					<table class="table table-bordered table-condensed" style="width:100%">
					<tr>
						<th>{{Clé}}</th>
						<th>{{Nom}}</th>
						<th>{{Date de création}}</th>
						<th>{{Date dernière utilisation}}</th>
						<th>{{Action}}</th>
					</tr>
					<tbody>
					<?php
					foreach ($RaspBEEConfJson->whitelist as $user => $value) {
						echo '<tr id="'.$user.'">';
						echo "<td>".$user."</td>";
						echo "<td>".$value->name."</td>";
						echo "<td>".$value->{"create date"}."</td>";
						echo "<td>".$value->{"last use date"}."</td>";
						echo '<td><a id='.$user.' name='.$value->name.' class="btn btn-danger  deleteRaspBeeUser"><i class="fa fa-minus-circle"></i> {{Supprimer l\'utilisateur}}</a></td>';
						echo "</tr>";
					}
					?>
					</tbody>
					</table>
                </div>                
            </div>
        </div>
    </div>
</div>
</div>
<?php
 unset($raspbeecom);
 include_file('desktop', 'network', 'js', 'RaspBEE');
 ?>
