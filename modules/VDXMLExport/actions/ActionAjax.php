<?php

class VDXMLExport_ActionAjax_Action extends Vtiger_IndexAjax_View
{
    public function __construct()
    {
        parent::__construct();
        $this->exposeMethod("getSettings");
        $this->exposeMethod("getInfoData");
    }
    public function process(Vtiger_Request $request)
    {
        $mode = $request->getMode();
        if (!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
        }
    }
    public function getSettings(Vtiger_Request $request)
    {
        $current_module = $request->get("current_module");
        $moduleModel =  new VDXMLExport_Module_Model();
        $settings = $moduleModel->getAllSettings();
        $response = new Vtiger_Response();
        if ($settings && !empty($settings)) {
            $response->setResult($settings);
        } else {
            $response->setError(1, 'There is no settings for VDXMLExport', 'Empty settings');
        }
        $response->emit();

    }

}

?>