<?php

class Settings_VDXMLExport_SaveSettings_Action extends Vtiger_Action_Controller
{
    public function checkPermission(Vtiger_Request $request)
    {
        $moduleName = $request->getModule();
        $record = $request->get("record");
        if (!Users_Privileges_Model::isPermitted($moduleName, "Save", $record)) {
            throw new AppException("LBL_PERMISSION_DENIED");
        }
    }
    public function process(Vtiger_Request $request)
    {
        $settingModel = new Settings_GetResponceIntegrator_Settings_Model();
        $result = $settingModel->saveSetting($request);
        header("Location: index.php?module=VDXMLExport&view=Settings&parent=Settings");
    }
}

?>