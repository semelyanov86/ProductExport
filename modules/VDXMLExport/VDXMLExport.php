<?php

require_once 'modules/Vtiger/helpers/ShortURL.php';
class VDXMLExport {

function vtlib_handler($moduleName, $eventType) {
		$adb = PearDatabase::getInstance();
		
		
		if ($eventType == 'module.postinstall') {
			$this->AddSettingsLinks('VDXMLExport');
            $this->addLinks('VDXMLExport');            
		}
		else if ($eventType == 'module.disabled') {
            $this->AddSettingsLinks('VDXMLExport', false);
            require_once('vtlib/Vtiger/Link.php');
			$tabid = getTabId("VDXMLExport");
			Vtiger_Link::deleteAll($tabid);
			$this->removeURL;          
		}
		else if ($eventType == 'module.enabled') {
            $this->AddSettingsLinks('VDXMLExport');
            $this->addLinks('VDXMLExport');            
		}
		else if ($eventType == 'module.preuninstall') {
			$adb->pquery('DELETE FROM vtiger_settings_field WHERE  name= ?', array('VDXMLExport'));
			require_once('vtlib/Vtiger/Link.php');
			$tabid = getTabId("VDXMLExport");
			Vtiger_Link::deleteAll($tabid);
			$this->removeURL;
		}
		else if ($eventType == 'module.postupdate') {
			$this->AddSettingsLinks('VDXMLExport');
			$this->addLinks('VDXMLExport');            
		}
	}
	
	function AddSettingsLinks($moduleName, $setToActive = true){
		$adb = PearDatabase::getInstance();
		$otherSettingsBlock = $adb->pquery('SELECT * FROM vtiger_settings_blocks WHERE label=?', array('LBL_OTHER_SETTINGS'));
		$otherSettingsBlockCount = $adb->num_rows($otherSettingsBlock);
		
		if ($otherSettingsBlockCount > 0) {
			$blockid = $adb->query_result($otherSettingsBlock, 0, 'blockid');
			$sequenceResult = $adb->pquery("SELECT max(sequence) as sequence FROM vtiger_settings_blocks WHERE blockid=?", array($blockid));
			if ($adb->num_rows($sequenceResult)) {
				$sequence = $adb->query_result($sequenceResult, 0, 'sequence');
			}
		}
		
		$result = $adb->pquery('SELECT * FROM vtiger_settings_field WHERE name=?',[$moduleName]);
		
		if($result && $adb->num_rows($result) == 0){
			$fieldid = $adb->getUniqueID('vtiger_settings_field');
			$adb->pquery("INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence, active) 
                        VALUES(?,?,?,?,?,?,?,?)", array($fieldid, $blockid, $moduleName, '', $moduleName . ' Configuration', 'index.php?module=VDXMLExport&view=Settings&parent=Settings', $sequence++, 0));
		}
		
		if($setToActive){
			$adb->pquery("UPDATE vtiger_settings_field SET active=0 WHERE vtiger_settings_field.name=?", array($moduleName));
		}
		else{
			$adb->pquery("UPDATE vtiger_settings_field SET active=1 WHERE vtiger_settings_field.name=?", array($moduleName));
		}
		
	}

    function addLinks($moduleName){
    	$adb = PearDatabase::getInstance();
        $tabid = getTabId($moduleName);
        Vtiger_Link::addLink(getTabid($moduleName), 'HEADERSCRIPT', $moduleName, 'layouts/v7/modules/VDXMLExport/resources/VDXMLExport.js', '', 0, '');
        $options = array(
				'handler_path' => 'modules/VDXMLExport/handlers/getXML.php',
				'handler_class' => 'VDXMLExport_getXML_Handler',
				'handler_function' => 'showXML',
				'handler_data' => array()
		);
		$trackURL = Vtiger_ShortURL_Helper::generateURL($options);
		$result = $adb->pquery('SELECT * FROM vtiger_vdxmlexport WHERE name=?',['url']);
		if($result && $adb->num_rows($result) == 0) {
			$adb->pquery("INSERT INTO vtiger_vdxmlexport(name, value) 
                        VALUES(?,?)", array('url', $trackURL));
		} else {
			$adb->pquery("UPDATE vtiger_vdxmlexport SET value=? WHERE vtiger_vdxmlexport.name='url'", array($trackURL));
		}
    }
    function removeURL(){
    	$adb = PearDatabase::getInstance();
    	$res = $adb->pquery('SELECT * FROM vtiger_vdxmlexport WHERE name=?',['url']);
        if ($this->db->num_rows($res)) {
            while ($row = $this->db->fetchByAssoc($res)) {
                $url = $row['value'];
            }
        }
        $parse_string = parse_url($url);
        $stringID = $parse_string['query'];
        $id = substr($stringID, 3);
        $db->pquery('DELETE FROM vtiger_shorturls WHERE id=?', array($id));
    }
}
