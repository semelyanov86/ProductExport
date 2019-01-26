<div class="container-fluid">
    <div class="contentHeader row">
        <h3 class="col-lg-8 textOverflowEllipsis" style="height: 30px;">
            <a href="index.php?module=ModuleManager&parent=Settings&view=List">&nbsp;{vtranslate('MODULE_MANAGEMENT',$QUALIFIED_MODULE)}</a>&nbsp;>&nbsp;{vtranslate('LBL_SETTING_HEADER', $QUALIFIED_MODULE)}
        </h3>
    </div>
    <hr>
    <div class="clearfix"></div>
    <form class="form-inline" id="CustomView" name="CustomView" method="post" action="index.php">
        <input type=hidden name="entities" id="entities" value="{$COUNT_ENTITY}" />
        <input type="hidden" name="module" value="{$MODULE_NAME}" />
        <input type="hidden" value="Settings" name="parent" />
        <input type="hidden" name="action" value="SaveSettings" />
        <input type="hidden" id="stdfilterlist" name="stdfilterlist" value=""/>
        <input type="hidden" id="advfilterlist" name="advfilterlist" value=""/>

        <div class="row-fluid"  style="">
            <h3 class="textAlignCenter">
                {if $RECORD_ID gt 0}
                    {vtranslate('LBL_EDIT_CONDITION_HEADER',$QUALIFIED_MODULE)}
                {else}
                    {vtranslate('LBL_NEW_CONDITION_HEADER',$QUALIFIED_MODULE)}
                {/if}
            </h3>
        </div>
        <hr>
        <div class="clearfix"></div>

        <div class="listViewContentDiv row" id="listViewContents" style="height: 450px; overflow-y: auto;width: 100%">
            <div class="row marginBottom10px">
                <div class="row">
                    <div class="row marginBottom10px">
                        <div class="col-sm-4 textAlignRight">{vtranslate('LBL_DEFAULT_MODULE',$QUALIFIED_MODULE)}</div>
                        <div class="fieldValue col-sm-6">
                            <select name="module" id="module" class="chzn-select select2" style="width: 150px">
                                {foreach item=MODULE from=$LIST_MODULES}
                                    <option value="{$MODULE.name}" {if $MODULE.name eq 'Products' || $ACTIVE_MODULE eq $MODULE.name}selected{/if} >{$MODULE.tablabel}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="row marginBottom10px">
                        <div class="col-sm-4 textAlignRight">{vtranslate('LBL_DEFAULT_FIELD',$QUALIFIED_MODULE)}</div>
                        <div class="fieldValue col-sm-6">
                            <select name="field" id="field" class="chzn-select select2" style="width: 150px">
                                {foreach item=FIELD from=$FIELDS}
                                    <option value="{$FIELD.name}" {if $MODULE.name eq $ENTITY.field}selected{/if} >{$FIELD.label}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>                    
                </div>


            </div>
        </div>

        <div class="filterActions row" style="padding: 10px 0;">
            <button type="submit" class="btn btn-success pull-right saveButton" id="save-condition-color" type="button"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
        </div>
    </form>

</div>

