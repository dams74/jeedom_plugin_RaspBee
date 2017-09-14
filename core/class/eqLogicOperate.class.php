<?php
/* This file is part of Plugin RaspBEE for jeedom.
*
* Plugin openzwave for jeedom is free software: you can redistribute it and/or modify
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
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class eqLogicOperate extends eqLogic {
	
	public function createDevice($device,$syncType = 0){
		$dejavu = false;
		foreach (eqlogic::byType('RaspBEE') as $eqLogic){
		if ($eqLogic->getConfiguration('origid')==$device[origid]) return false;		
		}
		switch ($device[type]){
		case "ZHASwitch" :{
				eqLogicOperate::createZHASwitch($device);
				break;
			}
		case "ZHATemperature" :{
				eqLogicOperate::createZHATemperature($device);
				break;
			}
		case "ZHAHumidity" :{
				eqLogicOperate::createZHAHumidity($device);
				break;
			}
		case "ZHAPressure" :{
				eqLogicOperate::createZHAPressure($device);
				break;
			}
		}
		return true;
	}
	
	private function isDeviceExist($device){
		
	}
	
	
	public function createZHASwitch($device){
		error_log("createZHASwitch ".$device[origID]);
		$eqLogic = new eqLogic();
		$eqLogic->setEqType_name('RaspBEE');
		$eqLogic->setName($device[name]." ".$device[origid]);
		$eqLogic->setIsEnable(1);
		$_logical_id = null;
		$eqLogic->setLogicalId($_logical_id);
		// on fabrique un sensor ZHASwitch (avec bouton)
		$eqLogic->setConfiguration('origid', $device[origid]);
		//$eqLogic->setConfiguration('etag', "e6797100e644d32ac0019ea2a8336bcd");
		$eqLogic->setConfiguration('manufacturername', $device[manufacturername]);
		//$eqLogic->setConfiguration('mode', $device[mode]);
		//$eqLogic->setConfiguration('reachable', $device[config][reachable]);
		$eqLogic->setConfiguration('modelid', $device[modelid]);
		$eqLogic->setConfiguration('swversion', $device[swversion]);
		$eqLogic->setConfiguration('type', $device[type]);
		$eqLogic->setConfiguration('uniqueid', $device[uniqueid]);
		$eqLogic->setIsVisible(1);
		$eqLogic->batteryStatus($device[config][battery]);
		$eqLogic->save();
		if (!is_object($RaspBEECmd)) {
			$RaspBEECmd = new RaspBEECmd();
		}
		
		$RaspBEECmd->setName('buttonevent');
		$RaspBEECmd->setLogicalId('buttonevent');
		$RaspBEECmd->setEqLogic_id($eqLogic->getId());
		$RaspBEECmd->setValue($device[state][buttonevent]);
		$dateInLocal = new DateTime($device[state][lastupdated],new DateTimeZone('UTC'));
		// il faut connaitre le timezone local
		$dateInLocal->setTimeZone(new DateTimeZone('Europe/Paris'));
		//$RaspBEECmd->setValueDate($dateInLocal->format("Y-m-d H:i:s"));				
		//error_log("setValueDate ".$dateInLocal->format("Y-m-d H:i:s"));

		//$RaspBEECmd->setConfiguration('day', '-1');
		//$RaspBEECmd->setConfiguration('data', 'temp');
		//$RaspBEECmd->setUnite('°C');
		$RaspBEECmd->setType('info');
		$RaspBEECmd->setSubType('numeric');
		$RaspBEECmd->save();
		return true;	
		
		//$eqLogic->save();
		//return;
	}
	
	public function createZHATemperature($device){
		error_log("createZHATemperature ".$device[origID]);
		$eqLogic = new eqLogic();
		$eqLogic->setEqType_name('RaspBEE');
		$eqLogic->setName($device[name]." ".$device[origid]);
		$eqLogic->setIsEnable(1);
		$eqLogic->setIsVisible(1);
		$_logical_id = null;
		$eqLogic->setLogicalId($_logical_id);
		// on fabrique un sensor ZHATemperature
		$eqLogic->setConfiguration('origid', $device[origid]);
		//$eqLogic->setConfiguration('etag', "e6797100e644d32ac0019ea2a8336bcd");
		$eqLogic->setConfiguration('manufacturername', $device[manufacturername]);
		//$eqLogic->setConfiguration('mode', $device[mode]);
		$eqLogic->setConfiguration('modelid', $device[modelid]);
		$eqLogic->setConfiguration('swversion', $device[swversion]);
		$eqLogic->setConfiguration('type', $device[type]);
		$eqLogic->setConfiguration('uniqueid', $device[uniqueid]);

		$eqLogic->batteryStatus($device[config][battery]);
		$eqLogic->save();
		if (!is_object($RaspBEECmd)) {
			$RaspBEECmd = new RaspBEECmd();
		}
		
		$RaspBEECmd->setName('temperature');
		$RaspBEECmd->setLogicalId('temperature');
		$RaspBEECmd->setEqLogic_id($eqLogic->getId());
		$RaspBEECmd->setValue($device[state][temperature]/100);
		$dateInLocal = new DateTime($device[state][lastupdated],new DateTimeZone('UTC'));
		// il faut connaitre le timezone local
		$dateInLocal->setTimeZone(new DateTimeZone('Europe/Paris'));
		//$RaspBEECmd->setValueDate($dateInLocal->format("Y-m-d H:i:s"));				
		//error_log("setValueDate ".$dateInLocal->format("Y-m-d H:i:s"));

		//$RaspBEECmd->setConfiguration('day', '-1');
		//$RaspBEECmd->setConfiguration('data', 'temp');
		$RaspBEECmd->setUnite('°C');
		$RaspBEECmd->setType('info');
		$RaspBEECmd->setSubType('numeric');
		$RaspBEECmd->save();
		return true;	
		
		//$eqLogic->save();
		//return;
	}
	
	public function createZHAHumidity($device){
		error_log("createZHAHumidity ".$device[origID]);
		$eqLogic = new eqLogic();
		$eqLogic->setEqType_name('RaspBEE');
		$eqLogic->setName($device[name]." ".$device[origid]);
		$eqLogic->setIsEnable(1);
		$eqLogic->setIsVisible(1);
		$_logical_id = null;
		$eqLogic->setLogicalId($_logical_id);
		// on fabrique un sensor ZHATemperature
		$eqLogic->setConfiguration('origid', $device[origid]);
		//$eqLogic->setConfiguration('etag', "e6797100e644d32ac0019ea2a8336bcd");
		$eqLogic->setConfiguration('manufacturername', $device[manufacturername]);
		//$eqLogic->setConfiguration('mode', $device[mode]);
		$eqLogic->setConfiguration('modelid', $device[modelid]);
		$eqLogic->setConfiguration('swversion', $device[swversion]);
		$eqLogic->setConfiguration('type', $device[type]);
		$eqLogic->setConfiguration('uniqueid', $device[uniqueid]);

		$eqLogic->batteryStatus($device[config][battery]);
		$eqLogic->save();
		if (!is_object($RaspBEECmd)) {
			$RaspBEECmd = new RaspBEECmd();
		}
		
		$RaspBEECmd->setName('humidity');
		$RaspBEECmd->setLogicalId('humidity');
		$RaspBEECmd->setEqLogic_id($eqLogic->getId());
		$RaspBEECmd->setValue($device[state][humidity]/100);
		$dateInLocal = new DateTime($device[state][lastupdated],new DateTimeZone('UTC'));
		// il faut connaitre le timezone local
		$dateInLocal->setTimeZone(new DateTimeZone('Europe/Paris'));
		//$RaspBEECmd->setValueDate($dateInLocal->format("Y-m-d H:i:s"));				
		//error_log("setValueDate ".$dateInLocal->format("Y-m-d H:i:s"));

		//$RaspBEECmd->setConfiguration('day', '-1');
		//$RaspBEECmd->setConfiguration('data', 'temp');
		$RaspBEECmd->setUnite('%');
		$RaspBEECmd->setType('info');
		$RaspBEECmd->setSubType('numeric');
		$RaspBEECmd->save();
		return true;	
		
		//$eqLogic->save();
		//return;
	}
	
	public function createZHAPressure($device){
		error_log("createZHAPressure ".$device[origID]);
		$eqLogic = new eqLogic();
		$eqLogic->setEqType_name('RaspBEE');
		$eqLogic->setName($device[name]." ".$device[origid]);
		$eqLogic->setIsEnable(1);
		$eqLogic->setIsVisible(1);
		$_logical_id = null;
		$eqLogic->setLogicalId($_logical_id);
		// on fabrique un sensor ZHATemperature
		$eqLogic->setConfiguration('origid', $device[origid]);
		//$eqLogic->setConfiguration('etag', "e6797100e644d32ac0019ea2a8336bcd");
		$eqLogic->setConfiguration('manufacturername', $device[manufacturername]);
		//$eqLogic->setConfiguration('mode', $device[mode]);
		$eqLogic->setConfiguration('modelid', $device[modelid]);
		$eqLogic->setConfiguration('swversion', $device[swversion]);
		$eqLogic->setConfiguration('type', $device[type]);
		$eqLogic->setConfiguration('uniqueid', $device[uniqueid]);

		$eqLogic->batteryStatus($device[config][battery]);
		$eqLogic->save();
		if (!is_object($RaspBEECmd)) {
			$RaspBEECmd = new RaspBEECmd();
		}
		
		$RaspBEECmd->setName('pressure');
		$RaspBEECmd->setLogicalId('pressure');
		$RaspBEECmd->setEqLogic_id($eqLogic->getId());
		$RaspBEECmd->setValue($device[state][pressure]);
		$dateInLocal = new DateTime($device[state][lastupdated],new DateTimeZone('UTC'));
		// il faut connaitre le timezone local
		$dateInLocal->setTimeZone(new DateTimeZone('Europe/Paris'));
		//$RaspBEECmd->setValueDate($dateInLocal->format("Y-m-d H:i:s"));				
		//error_log("setValueDate ".$dateInLocal->format("Y-m-d H:i:s"));

		//$RaspBEECmd->setConfiguration('day', '-1');
		//$RaspBEECmd->setConfiguration('data', 'temp');
		$RaspBEECmd->setType('info');
		$RaspBEECmd->setSubType('numeric');
		$RaspBEECmd->save();
		return true;	
		
		//$eqLogic->save();
		//return;
	}
}

?>