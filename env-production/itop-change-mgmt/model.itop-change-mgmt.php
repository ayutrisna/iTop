						<?php
//
// File generated by ... on the 2019-04-10T12:21:10+0200
// Please do not edit manually
//

/**
 * Classes and menus for itop-change-mgmt (version 2.6.0)
 *
 * @author      iTop compiler
 * @license     http://opensource.org/licenses/AGPL-3.0
 */


/**
 * Persistent classes for a CMDB
 *
 * @copyright   Copyright (C) 2010-2017 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */
class Change extends Ticket
{
	public static function Init()
	{
		$aParams = array(			'category' => 'bizmodel,searchable,changemgmt',
			'key_type' => 'autoincrement',
			'name_attcode' => array('ref'),
			'state_attcode' => 'status',
			'reconc_keys' => array('ref'),
			'db_table' => 'ticket_change',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'icon' => utils::GetAbsoluteUrlModulesRoot().'itop-change-mgmt/images/change.png',
			'order_by_default' => array('ref' => false),);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("new,assigned,planned,approved,closed,rejected"), "display_style"=>'list', "sql"=>'status', "default_value"=>'new', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("category", array("allowed_values"=>new ValueSetEnum("hardware,software,system,network,application,other"), "display_style"=>'list', "sql"=>'category', "default_value"=>'hardware', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("reject_reason", array("allowed_values"=>null, "sql"=>'reject_reason', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("changemanager_id", array("targetclass"=>'Person', "allowed_values"=>null, "sql"=>'changemanager_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("changemanager_email", array("allowed_values"=>null, "extkey_attcode"=>'changemanager_id', "target_attcode"=>'email', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("parent_id", array("targetclass"=>'Change', "allowed_values"=>new ValueSetObjects("SELECT Change WHERE id != :this->id"), "sql"=>'parent_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("parent_name", array("allowed_values"=>null, "extkey_attcode"=>'parent_id', "target_attcode"=>'ref', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("creation_date", array("allowed_values"=>null, "sql"=>'creation_date', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("approval_date", array("allowed_values"=>null, "sql"=>'approval_date', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("fallback_plan", array("allowed_values"=>null, "sql"=>'fallback_plan', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("outage", array("allowed_values"=>new ValueSetEnum("yes,no"), "display_style"=>'list', "sql"=>'outage', "default_value"=>'no', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("related_request_list", array("linked_class"=>'UserRequest', "ext_key_to_me"=>'parent_change_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDREMOVE, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("related_incident_list", array("linked_class"=>'Incident', "ext_key_to_me"=>'parent_change_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDREMOVE, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("related_problems_list", array("linked_class"=>'Problem', "ext_key_to_me"=>'related_change_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDREMOVE, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("child_changes_list", array("linked_class"=>'Change', "ext_key_to_me"=>'parent_id', "count_min"=>0, "count_max"=>0, "edit_mode"=>LINKSET_EDITMODE_ADDREMOVE, "allowed_values"=>new ValueSetObjects("SELECT Change WHERE id != :this->id"), "depends_on"=>array(), "always_load_in_tables"=>false)));

		// Lifecycle (status attribute: status)
		//
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_assign", array()));
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_plan", array()));
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_reject", array()));
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_reopen", array()));
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_approve", array()));
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_finish", array()));
		MetaModel::Init_DefineState(
			"new",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array(
					'ref' => OPT_ATT_READONLY,
					'org_id' => OPT_ATT_MANDATORY,
					'title' => OPT_ATT_MANDATORY,
					'description' => OPT_ATT_MANDATORY,
					'last_update' => OPT_ATT_READONLY,
					'close_date' => OPT_ATT_HIDDEN,
					'reject_reason' => OPT_ATT_HIDDEN,
					'creation_date' => OPT_ATT_READONLY,
					'approval_date' => OPT_ATT_HIDDEN,
					'caller_id' => OPT_ATT_MANDATORY,
					'team_id' => OPT_ATT_HIDDEN,
					'agent_id' => OPT_ATT_HIDDEN,
					'changemanager_id' => OPT_ATT_HIDDEN,
					'outage' => OPT_ATT_HIDDEN,
				),
			)
		);
		MetaModel::Init_DefineTransition("new", "ev_assign", array(
            "target_state"=>"assigned",
            "actions"=>array(),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineState(
			"assigned",
			array(
				"attribute_inherit" => 'new',
				"attribute_list" => array(
					'team_id' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'agent_id' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'changemanager_id' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'caller_id' => OPT_ATT_NORMAL,
				),
			)
		);
		MetaModel::Init_DefineTransition("assigned", "ev_plan", array(
            "target_state"=>"planned",
            "actions"=>array(),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineState(
			"planned",
			array(
				"attribute_inherit" => 'assigned',
				"attribute_list" => array(
					'start_date' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'end_date' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'fallback_plan' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'caller_id' => OPT_ATT_MANDATORY,
					'outage' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
				),
			)
		);
		MetaModel::Init_DefineTransition("planned", "ev_reject", array(
            "target_state"=>"rejected",
            "actions"=>array(),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineTransition("planned", "ev_approve", array(
            "target_state"=>"approved",
            "actions"=>array(array('verb' => 'SetCurrentDate', 'params' => array(array('type' => 'attcode', 'value' => "approval_date"))), array('verb' => 'Reset', 'params' => array(array('type' => 'attcode', 'value' => "reject_reason")))),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineState(
			"rejected",
			array(
				"attribute_inherit" => 'assigned',
				'highlight' => array('code' => 'rejected'),
				"attribute_list" => array(
					'start_date' => OPT_ATT_READONLY,
					'end_date' => OPT_ATT_READONLY,
					'private_log' => OPT_ATT_READONLY,
					'caller_id' => OPT_ATT_READONLY,
					'fallback_plan' => OPT_ATT_READONLY,
					'category' => OPT_ATT_READONLY,
					'parent_id' => OPT_ATT_READONLY,
					'org_id' => OPT_ATT_READONLY,
					'title' => OPT_ATT_READONLY,
					'description' => OPT_ATT_READONLY,
					'reject_reason' => OPT_ATT_MANDATORY | OPT_ATT_MUSTPROMPT,
					'approval_date' => OPT_ATT_READONLY,
					'team_id' => OPT_ATT_READONLY,
					'agent_id' => OPT_ATT_READONLY,
					'changemanager_id' => OPT_ATT_READONLY,
					'outage' => OPT_ATT_READONLY,
				),
			)
		);
		MetaModel::Init_DefineTransition("rejected", "ev_reopen", array(
            "target_state"=>"assigned",
            "actions"=>array(),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineState(
			"approved",
			array(
				"attribute_inherit" => 'planned',
				'highlight' => array('code' => 'approved'),
				"attribute_list" => array(
					'private_log' => OPT_ATT_NORMAL,
					'category' => OPT_ATT_NORMAL,
					'parent_id' => OPT_ATT_NORMAL,
					'org_id' => OPT_ATT_READONLY,
					'title' => OPT_ATT_READONLY,
					'description' => OPT_ATT_READONLY,
					'start_date' => OPT_ATT_READONLY,
					'end_date' => OPT_ATT_READONLY,
					'reject_reason' => OPT_ATT_READONLY,
					'creation_date' => OPT_ATT_HIDDEN,
					'approval_date' => OPT_ATT_READONLY,
					'caller_id' => OPT_ATT_READONLY,
					'team_id' => OPT_ATT_READONLY,
					'agent_id' => OPT_ATT_READONLY,
					'changemanager_id' => OPT_ATT_READONLY,
					'fallback_plan' => OPT_ATT_NORMAL,
					'outage' => OPT_ATT_READONLY,
				),
			)
		);
		MetaModel::Init_DefineTransition("approved", "ev_finish", array(
            "target_state"=>"closed",
            "actions"=>array(array('verb' => 'SetCurrentDate', 'params' => array(array('type' => 'attcode', 'value' => "close_date")))),
            "user_restriction"=>null,
            "attribute_list"=>array(
            )
        ));
		MetaModel::Init_DefineState(
			"closed",
			array(
				"attribute_inherit" => 'approved',
				'highlight' => array('code' => 'closed'),
				"attribute_list" => array(
					'close_date' => OPT_ATT_READONLY,
					'creation_date' => OPT_ATT_READONLY,
					'private_log' => OPT_ATT_READONLY,
					'fallback_plan' => OPT_ATT_READONLY,
					'category' => OPT_ATT_READONLY,
					'parent_id' => OPT_ATT_READONLY,
				),
			)
		);

		// Higlight Scale
		MetaModel::Init_DefineHighlightScale( array(
		    'approved' => array('rank' => 1, 'color' => HILIGHT_CLASS_NONE, 'icon' => utils::GetAbsoluteUrlModulesRoot().'itop-change-mgmt/images/change-approved.png'),
		    'rejected' => array('rank' => 2, 'color' => HILIGHT_CLASS_NONE, 'icon' => utils::GetAbsoluteUrlModulesRoot().'itop-change-mgmt/images/change-rejected.png'),
		    'closed' => array('rank' => 3, 'color' => HILIGHT_CLASS_NONE, 'icon' => utils::GetAbsoluteUrlModulesRoot().'itop-change-mgmt/images/change-closed.png'),
		));

		MetaModel::Init_SetZListItems('details', array (
  0 => 'functionalcis_list',
  1 => 'contacts_list',
  2 => 'workorders_list',
  3 => 'related_request_list',
  4 => 'related_incident_list',
  5 => 'related_problems_list',
  6 => 'child_changes_list',
  'col:col1' => 
  array (
    'fieldset:Ticket:baseinfo' => 
    array (
      0 => 'ref',
      1 => 'org_id',
      2 => 'status',
      3 => 'title',
      4 => 'description',
    ),
    'fieldset:Ticket:contact' => 
    array (
      0 => 'caller_id',
      1 => 'team_id',
      2 => 'agent_id',
      3 => 'changemanager_id',
    ),
  ),
  'col:col2' => 
  array (
    'fieldset:Ticket:resolution' => 
    array (
      0 => 'category',
      1 => 'outage',
      2 => 'reject_reason',
      3 => 'fallback_plan',
    ),
    'fieldset:Ticket:relation' => 
    array (
      0 => 'parent_id',
    ),
  ),
  'col:col3' => 
  array (
    'fieldset:Ticket:date' => 
    array (
      0 => 'creation_date',
      1 => 'start_date',
      2 => 'end_date',
      3 => 'last_update',
      4 => 'approval_date',
      5 => 'close_date',
    ),
  ),
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'ref',
  1 => 'title',
  2 => 'org_id',
  3 => 'status',
  4 => 'operational_status',
  5 => 'start_date',
  6 => 'end_date',
  7 => 'creation_date',
  8 => 'last_update',
  9 => 'close_date',
  10 => 'team_id',
  11 => 'agent_id',
  12 => 'changemanager_id',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'title',
  1 => 'org_id',
  2 => 'start_date',
  3 => 'end_date',
  4 => 'status',
  5 => 'category',
  6 => 'agent_id',
));
;
	}


	/**
	 * To be deprecated: use SetCurrentDate() instead
	 * @return void
	 */
	public function SetApprovalDate($sStimulusCode)
	{
		$this->Set('approval_date', time());
		return true;
	}

	/**
	 * To be deprecated: use SetCurrentDate() instead
	 * @return void
	 */
	public function ResetRejectReason($sStimulusCode)
	{
		$this->Set('reject_reason', '');
		return true;
	}

	/**
	 * To be deprecated: use SetCurrentDate() instead
	 * @return void
	 */
	public function SetClosureDate($sStimulusCode)
	{
		$this->Set('close_date', time());
		return true;
	}



    protected function OnInsert()
	{
        parent::OnInsert();
        $this->UpdateImpactedItems();
		$this->SetIfNull('creation_date', time());
		$this->SetIfNull('last_update', time());
	}



    protected function OnUpdate()
	{
        parent::OnUpdate();
        $aChanges = $this->ListChanges();
        if (array_key_exists('functionalcis_list', $aChanges))
        {
            $this->UpdateImpactedItems();
        }
		$this->Set('last_update', time());
	}

}
//
// Menus
//
class MenuCreation_itop_change_mgmt extends ModuleHandlerAPI
{
	public static function OnMenuCreation()
	{
		global $__comp_menus__; // ensure that the global variable is indeed global !
		$__comp_menus__['ChangeManagement'] = new MenuGroup('ChangeManagement', 50 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Change:Overview'] = new DashboardMenuNode('Change:Overview', dirname(__FILE__).'/change_overview_dashboard.xml', $__comp_menus__['ChangeManagement']->GetIndex(), 0 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['NewChange'] = new NewObjectMenuNode('NewChange', 'Change', $__comp_menus__['ChangeManagement']->GetIndex(), 1 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['SearchChanges'] = new SearchMenuNode('SearchChanges', 'Change', $__comp_menus__['ChangeManagement']->GetIndex(), 2, null , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['Change:Shortcuts'] = new TemplateMenuNode('Change:Shortcuts', '', $__comp_menus__['ChangeManagement']->GetIndex(), 3 , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null);
		$__comp_menus__['MyChanges'] = new OQLMenuNode('MyChanges', "SELECT Change WHERE agent_id = :current_contact_id AND status NOT IN (\"closed\")", $__comp_menus__['Change:Shortcuts']->GetIndex(), 1, false , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['MyChanges']->SetParameters(array('auto_reload' => "fast"));
		$__comp_menus__['Changes'] = new OQLMenuNode('Changes', "SELECT Change WHERE status != \"closed\"", $__comp_menus__['Change:Shortcuts']->GetIndex(), 2, true , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['Changes']->SetParameters(array('auto_reload' => "fast"));
		$__comp_menus__['WaitingApproval'] = new OQLMenuNode('WaitingApproval', "SELECT Change WHERE status IN (\"planned\")", $__comp_menus__['Change:Shortcuts']->GetIndex(), 3, false , null, UR_ACTION_MODIFY, UR_ALLOWED_YES, null, true);
		$__comp_menus__['WaitingApproval']->SetParameters(array('auto_reload' => "fast"));
	}
} // class MenuCreation_itop_change_mgmt
