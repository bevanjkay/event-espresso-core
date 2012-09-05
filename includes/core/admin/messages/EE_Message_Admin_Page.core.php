<?php if (!defined('EVENT_ESPRESSO_VERSION') )
	exit('NO direct script access allowed');

/**
 * Event Espresso
 *
 * Event Registration and Management Plugin for Wordpress
 *
 * @package		Event Espresso
 * @author		Seth Shoultes
 * @copyright	(c)2009-2012 Event Espresso All Rights Reserved.
 * @license		@link http://eventespresso.com/support/terms-conditions/  ** see Plugin Licensing * *
 * @link		http://www.eventespresso.com
 * @version		3.2.P
 *
 * ------------------------------------------------------------------------
 *
 * EE_Message_Admin_Page class
 *
 * for Admin setup of the message pages
 *
 * @package		Event Espresso
 * @subpackage	includes/core/message/EE_Message_Admin_Page.core.php
 * @author		Darren Ethier
 *
 * ------------------------------------------------------------------------
 */

class EE_Message_Admin_Page extends EE_Admin_Page implements Admin_Page_Interface {

	private $_active_messengers;
	private $_active_message_types;

	/**
	 * constructor
	 * @constructor 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );

		$this->page_slug = EE_MSG_PG_SLUG;
		$this->init();

		//add ajax calls here
		if ( $this->_AJAX ) {
		}
	}

	/**
	 * 		define_page_vars
	*		@access private
	*		@return void
	*/
	protected function define_page_vars() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
		$this->admin_base_url = EE_MSG_ADMIN_URL;
		$this->admin_page_title = __( 'Messages', 'event_espresso' );
	}

	/**
	 * set views array for List Table
	 * @access public
	 * @return array
	 */
	public function _set_list_table_views() {
		global $espresso_wp_user;
		do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '');

		//we're also going to set the active messengers and active message types in here.
		
		$this->_active_messengers = get_user_meta($espresso_wp_user, 'ee_active_messengers', true);
		$this->_active_message_types = get_user_meta($espresso_wp_user, 'ee_active_message_types', true);

		$this->_views = array(
			'all' => array(
				'slug' => 'all',
				'label' => __('All', 'event_espresso'),
				'count' => 0,
				'bulk_action' => array(
					'trash_message_template' => __('Move to Trash', 'event_espresso')
				)
			),
			'global' => array(
				'slug' => 'global',
				'label' => __('Global', 'event_espresso'),
				'count' => 0,
				'bulk_action' => array(
					'trash_message_template' => __('Move to Trash', 'event_espresso')
				)
			),
			'event' => array(
				'slug' => 'event',
				'label' => __('Events', 'event_espresso'),
				'count' => 0,
				'bulk_action' => array(
					'trash_message_template' => __('Move to Trash', 'event_espresso')
				)
			),
			'trashed' => array(
				'slug' => 'trashed',
				'label' => __('Trash', 'event_espresso'),
				'count' => 0,
				'bulk_action' => array(
					'restore_message_template' => __('Restore From Trash', 'event_espresso'),
					'delete_message_template' => __('Delete Permanently', 'event_espresso')
				)
			)
		);
	}

	/**
	 * 		an array for storing key => value pairs of request actions and their corresponding methods
	*		@access private
	*		@return void
	*/
	protected function set_page_routes() {			

		//echo '<h3>'. __CLASS__ . '->' . __FUNCTION__ . ' <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h3>';
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );

		$this->_page_routes = array(
				// prices
				'default'	=> '_ee_messages_overview_list_table',
				'add_new_message_template'	=> '_add_message_template',
				'edit_message_template'	=> '_edit_message_template',
				'insert_message_template'	=> array( 'func' => '_insert_or_update_message_template', 'args' => array( 'new_template' => TRUE )),
				'update_message_template'	=> array( 'func' => '_insert_or_update_message_template', 'args' => array( 'new_template' => FALSE )),
				'trash_message_template'	=> array( 'func' => '_trash_or_restore_message_template', 'args' => array( 'trash' => TRUE, 'all' => TRUE )),
				'trash_message_template_context' => array( 'func' => '_trash_or_restore_message_template', 'args' => array( 'trash' => TRUE )),
				'restore_message_template'	=> array( 'func' => '_trash_or_restore_message_template', 'args' => array( 'trash' => FALSE )),
				'restore_message_template_context' => array( 'func' => '_trash_or_restore_message_template' , 'args' => array('trash' => FALSE) ),
				'delete_message_template'	=> '_delete_message_template',
				'settings'	=> array( 'func' => '_activate_messenger', 'args' => array( 'new_price' => TRUE )),
				'reports' => '_messages_reports'
		);
	}

	/**
	 * generates HTML for main EE Messages Admin page
	 * @access protected
	 * @return void
	 * @todo I expect that this will modify somewhat but uncertain if it will occur in the extended WP_List_tables or not.
	 */
	protected function _ee_messages_overview_list_table() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');
		//generate URL for Add New Price link
		$add_new_message_template_url = wp_nonce_url( add_query_arg( array( 'action' => 'add_new_message_template' ), EE_MSG_ADMIN_URL ), 'add_new_message_template_nonce' );
		// add link to title
		$this->admin_page_title .= ' <a href="' . $add_new_message_template_url . '" class="button add-new-h2" style="margin-left: 20px;">' . __('Add New Message Template', 'event_espresso') . '</a>';
		$this->admin_page_title .= $this->_learn_more_about_message_templates_link();
		
		$all_message_templates = $this->_get_message_templates();
		
		if ( empty($message_templates) ) {
			$message_templates = new WP_Error( __('no_message_templates', 'event_espresso'), __('There are no message templates in the system.  Have you activated any messengers?', 'event_espresso') . espresso_get_error_code( __FILE__, __FUNCTION__, __LINE__) );
		}

		//$message_templates COULD be an error object. IF it is then we want to handle/display the error
		if ( is_wp_error($message_templates) ) {
			$this->_handle_errors($message_templates);
			$message_templates = array();
		}

		$this->template_args['table_rows'] = count( $message_templates );

		//send along active messengers and active message_types for filters
		$this->template_args['active_messengers'] = $this->_active_messengers;
		$this->template_args['active_message_types'] = $this->_active_message_types;

		$entries_per_page_dropdown = $this->_entries_per_page_dropdown( $this->template_args['table_rows'] );

		$this->template_args['view_RLs'] = $this->get_list_table_view_RLs();
		$this->template_args['list_table'] = new EE_Messages_List_Table( $message_templates, $this->_view, $this->_views, $entries_per_page_dropdown );

		// link back to here
		$this->template_args['ee_msg_overview_url'] = add_query_arg( array( 'noheader' => 'true' ), EE_MSG_ADMIN_URL );
		$this->template_args['status'] = $this->_view;
		// path to template
		$template_path = EE_MSG_TEMPLATE_PATH . 'ee_msg_admin_overview.template.php';
		$this->template_args['admin_page_content'] = espresso_display_template( $template_path, $this->template_args, TRUE );
		
		// the final template wrapper
		$this->display_admin_page_with_sidebar();
	}

	/**
	 * _get_message_templates
	 * This gets all the message templates for listing on the overview list.
	 * @access protected
	 * @return array|WP_Error object
	 */
	protected function _get_message_templates() {
		global $espresso_wp_user;
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
		// start with an empty array
		$message_templates = array();

		/** todo: is this even needed?
		//require_once( EE_MSG_ADMIN . 'EE_Message_Template_List_Table.class.php' ); /**/
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'models/EEM_Message_Template.model.php');
		$MTP = EEM_Message_Template::instance();
		
		$_GET['orderby'] = empty($_GET['orderby']) ? '' : $_GET['orderby'];

		switch ( $_GET['orderby'] ) {
			case 'messenger' :
				$orderby = 'MTP_messenger';
				break;
			case 'message_type' :
				$orderby = 'MTP_message_type';
				break;
			case 'user_id' :
				$orderby = 'MTP_user_id';
				break;
			default:
				$orderby = 'GRP_ID';
				break; 
		}

		$order = ( isset( $_GET['order'] ) && ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'ASC';

		$trashed_templates = $MTP->get_all_trashed_grouped_message_templates();
		$all_templates = $MTP->get_all_message_templates($orderby, $order);
		$global_templates = $MTP->get_all_global_message_templates($orderby, $order);
		$event_templates = $MTP->get_all_event_message_templates($orderby, $order);

		$view_templates_ref = $this->view . '_templates';
		$message_templates = ${$view_templates_ref};

		foreach ( $this->_views as $view ) {
			$count_ref = $view['slug'] . '_templates';
			$this->_views[$view['slug']]['count'] = count(${$count_ref});
		}

		return $message_templates;
	}

	/**
	 * _add_message_template
	 * 
	 * @access  protected
	 * @return void
	 */
	protected function _add_message_template() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');

		//we need to ask for a messenger and message type in order to generate the templates.
		
		//is this for a custom evt?
		$EVT_ID = isset( $_REQUEST['evt_id'] ) && !empty( $_REQUEST['evt_id'] ) ? absint( $_REQUEST['evt_id'] ) : FALSE;
		
		$this->template_args['EVT_ID'] = $EVT_ID ? $EVT_ID : FALSE;
		$this->template_args['event_name'] = $EVT_ID ? $this->_event_name($EVT_ID) : FALSE;
		$this->template_args['active_messengers'] = $this->_active_messengers;
		$this->template_args['active_message_types'] = $this->_active_message_types;
		$this->template_args['action'] = 'insert_message_template';
		$this->template_args['edit_message_template_form_url'] = add_query_arg( array( 'action' => 'insert_message_template', 'noheader' => TRUE ), EE_MSG_ADMIN_URL );
		$this->template_args['learn_more_about_message_templates_link'] = $this->_learn_more_about_message_templates_link();
		$this->template_args['action_message'] = __('Before we generate the new templates we need to ask you what messenger and message type you want the templates for');

		//add nav tab for this page
		$this->nav_tabs['add_message_template']['url'] = wp_nonce_url( add_query_arg( array( 'action' => 'add_message_template'), EE_MSG_ADMIN_URL ), 'add_message_template_nonce' );
		$this->nav_tabs['add_message_template']['link_text'] = __('Add Message Template', 'event_espresso');
		$this->nav_tabs['add_message_template']['css_class'] = ' nav-tab-active';
		$this->nav_tabs['add_message_template']['order'] = 15;

		//generate metabox
		$this->_add_admin_page_meta_box( $action, $title, __FUNCTION__, NULL);

		//final template wrapper
		$this->display_admin_page_with_sidebar();

	}

	/**
	 * _edit_message_template
	 * 
	 * @access protected
	 * @return void
	 */
	protected function _edit_message_template() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');
		$GRP_ID = isset( $_REQUEST['id'] ) && !empty( $_REQUEST['id'] ) ? absint( $_REQUEST['id'] ) : FALSE;

		$EVT_ID = isset( $_REQUEST['evt_id'] ) && !empty( $_REQUEST['evt_id'] ) ? absint( $_REQUEST['evt_id'] ) : FALSE;

		$context = isset( $_REQUEST['context']) && !empty($_REQUEST['context'] ) ? strtolower($_REQUEST['context']) : FALSE;
		
		//todo: this localization won't work for translators because the string is variable.
		$title = __(ucwords( str_replace( '_', ' ', $this->_req_action ) ), 'event_espresso' );

		//let's get the message templates
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'models/EEM_Message_Template.model.php');
		$MTP = EEM_Message_Template::instance();

		if ( empty($GRP_ID) && $new_template ) {
			$message_template = $MTP->get_new_template;
			$action = 'insert_message_template';
			$edit_message_template_form_url = add_query_arg( array( 'action' => $action, 'noheader' => TRUE ), EE_MSG_ADMIN_URL );
		} else {
			$message_template = $MTP->get_message_template_by_ID($GRP_ID);
			$action = 'update_message_template';
			$edit_message_template_form_url = add_query_arg( array( 'action' => $action, 'noheader' => TRUE ), EE_MSG_ADMIN_URL );
			$title .= $message_template->messenger() . ' ' . $message_template->message_type . ' Template'; 
		}

		$context_switcher_url = add_query_arg( array( 'action' => 'edit_message_template', 'noheader' => TRUE, 'id' => $GRP_ID, 'evt_id' => $EVT_ID ), EE_MSG_ADMIN_URL);

		//todo: let's display the event name rather than ID. 
		$title .= $EVT_ID ? ' for EVT_ID: ' . $EVT_ID : '';

		$this->template_args['GRP_ID'] = $GRP_ID;
		$this->template_args['message_template'] = $message_template;

		//let's get the EE_messages_controller so we can get templates
		$MSG = new EE_messages();
		$template_fields = $MSG->get_fields($message_template->messenger(), $message_template->message_type());
		
		if ( is_wp_error($template_fields) ) {
			$this->_handle_errors($template_fields); 
			$template_fields = false;
		}

		$this->template_args['template_fields'] = $template_fields;
		$this->template_args['action'] = $action;
		$this->template_args['context'] = $context;
		$this->template_args['EVT_ID'] = $EVT_ID;
		$this->template_args['edit_message_template_form_url'] = $edit_message_template_form_url;
		$this->template_args['context_switcher_url'] = $context_switcher_url;
		$this->template_args['learn_more_about_message_templates_link'] = $this->_learn_more_about_message_templates_link();

		//add nav tab for this page
		$this->nav_tabs['edit_message_template']['url'] = wp_nonce_url( add_query_arg( array( 'action' => 'edit_message_template', 'id' => $GRP_ID, 'context' => $context, 'evt_id' => $EVT_ID), EE_MSG_ADMIN_URL ), $action . '_nonce' );
		$this->nav_tabs['edit_message_template']['link_text'] = __('Edit Message Template', 'event_espresso');
		$this->nav_tabs['edit_message_template']['css_class'] = ' nav-tab-active';
		$this->nav_tabs['edit_message_template']['order'] = 15;

		//generate metabox
		$this->_add_admin_page_meta_box( $action, $title, __FUNCTION__, NULL );

		//final template wrapper
		$this->display_admin_page_with_sidebar();
	}

	/**
	 * utility for sanitizing new values coming in.
	 * Note: this is only used when updating a context.
	 * 
	 * @access protected
	 * @param int $index This helps us know which template field to select from the request array.
	 */
	protected function _set_message_template_column_values($index=null) {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );

		$set_column_values = array(
			'MTP_ID' => absint($_REQUEST['MTP_template_field'][$index]['MTP_ID']),
			'EVT_ID' => absint($_REQUEST['EVT_ID']),
			'GRP_ID' => absint($_REQUEST['GRP_ID']),
			'MTP_user_id' => absint($_REQUEST['MTP_user_id']),
			'MTP_messenger'	=> strtolower($_REQUEST['MTP_messenger']),
			'MTP_message_type' => strtolower($_REQUEST['MTP_message_type']),
			'MTP_template_field' => strtolower($_REQUEST['MTP_template_field'][$index]['name']),
			'MTP_context' => strtolower($_REQUEST['MTP_context']),
			'MTP_content' => strtolower($_REQUEST['MTP_template_field'][$index]['content']),
			'MTP_is_global' => absint($_REQUEST['MTP_is_global']),
			'MTP_is_override' => absint($_REQUEST['MTP_is_override']),
			'MTP_deleted' => absint($_REQUEST['MTP_deleted'])
		);
		return $set_column_values;
	}

	protected function _insert_or_update_message_template($new = FALSE ) {
		
		do_action ( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');
		$success = 0;
		//setup notices description	
		$messenger = !empty($_REQUEST['MTP_messenger']) ? ucwords(str_replace('_', ' ', $_REQUEST['MTP_messenger'] ) ) : false;
		$message_type = !empty($_REQUEST['MTP_message_type']) ? ucwords(str_replace('_', ' ', $_REQUEST['MTP_message_type'] ) ) : false;
		$context = !empty($_REQUEST['MTP_context']) ? ucwords(str_replace('_', ' ', $_REQUEST['MTP_context'] ) ) : false;

		$item_desc = $messenger ? $messenger . ' ' . $message_type . ' ' . $context . ' ' : '';
		$item_desc .= 'Message Template';
		$query_args = array();

		//if this is "new" then we need to generate the default contexts for the selected messenger/message_type for user to edit.
		if ( $new_price ) {
			if ( $edit_array = $this->_generate_new_templates($messenger, $message_type) ) {
				if ( is_wp_error ($edit_array) ) {
					$this->_handle_errors($edit_array);
				} else {
					$success = 1;
					$query_args = array(
						'id' => $edit_array['GRP_ID'],
						'evt_id' => $edit_array['EVT_ID'],
						'context' => $edit_array['MTP_context'],
						'action' => 'edit_message_template'
						);
				}
			}
			$action_desc = 'created';
		} else {
			require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'models/EEM_Message_Type.model.php');
			$MTP = EEM_Message_Type::instance();
			
			//run update for each template field in displayed context
			for ( $i=0; $i < count($_REQUEST['MTP_template_field']); $i++ ) {
				$set_column_values = $this->_set_message_template_column_values($i);
				$where_cols_n_values = array( 'MTP_ID' => $_REQUEST['MTP_template_field'][$index]['MTP_ID']);
				if ( $updated = $MTP->update( $set_column_values, $where_cols_n_values ) ) {
					if ( is_wp_error($updated) ) {
						$this->_handle_errors($edit_array);
					} else {
						$success = 1;
					}
				}
				$action_desc = 'updated';
			}
		}
		
		$this->_redirect_after_admin_action( $success, $item_desc, $action_desc, $query_args );

	}

	/**
	 * _generate_new_templates
	 * This will handle the messenger, message_type selection when "adding a new custom template" for an event and will automaticlaly create the defaults for the event.  The user would then be redirected to edit the default context for the event.
	 * @return array|error_object array of data required for the redirect to the correct edit page or error object if encountering problems.
	 */
	protected function _generate_new_templates($messenger, $message_type, $evt_id) {
		if ( empty($messenger) || empty($message_type) ) {
			return new WP_Error(__('empty_variable', 'event_espresso'), __('Missing required messenger or message_type', 'event_espresso') . espresso_get_error_code(__FILE__, __FUNCTION__, __LINE__) );
		}

		//todo: may need to explicitly load the file containing the class here.
		$MSG = new EE_messages();
		$new_message_template_group = $MSG->create_new_templates($messenger, $message_type, $evt_id);

		return $new_message_template_group;

	}

	/**
	 * [_trash_or_restore_message_template]
	 * 
	 * @access protected
	 * @param  boolean $trash whether to move an item to trash (TRUE) or restore it (FALSE)
	 * @param boolean $all whether this is going to trash all contexts within a template group (TRUE) OR just an individual context (FALSE).
	 * @return void
	 */
	protected function _trash_or_restore_message_template($trash = TRUE, $all = FALSE ) {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'models/EEM_Message_Type.model.php');
			$MTP = EEM_Message_Type::instance();

		$success = 1;
		$MTP_deleted = $trash ? TRUE : FALSE;

		//incoming GRP_IDs
		if ( $all ) {
			//Checkboxes
			if ( !empty( $_POST['checkbox'] ) && is_array($_POST['checkbox'] ) ) {
				//if array has more than one element then success message should be plural.
				//todo: what about nonce?
				$success = count( $_POST['checkbox'] ) > 1 ? 2 : 1;

				//cycle through checkboxes
				while ( list( $GRP_ID, $value ) = each ($_POST['checkbox']) ) {
					if ( ! $MTP->update(array('MTP_deleted' => $MTP_deleted), array('GRP_ID' => absint($GRP_ID) ) ) ) {
						$success = 0;
					}
				}
			} else {
				//grab single GRP_ID and handle
				$GRP_ID = absint($_REQUEST['id']);
				if ( !$MTP->update(array('MTP_deleted' => $MTP_deleted), array('GRP_ID' => $GRP_ID ) ) ) {
					$success = 0;
				}
			}
		//not entire GRP, just individual context
		} else {
			//we should only have the MTP_id for the context,
			//todo: will probably need to make sure we have a nonce here?
			$GRP_ID = absint( $_REQUEST['id'] );
			$MTP_message_type = strtolower( $_REQUEST['message_type']);
			$MTP_context = strtolower( $_REQUEST['context'] );
			
			if ( !$MTP->update(array('MTP_deleted' => $MTP_deleted), array('GRP_ID' => $GRP_ID, 'MTP_message_type' => $MTP_message_type, 'MTP_context' => $MTP_context ) ) ) {
				$success = 0;
			}
		}

		$action_desc = $trash ? 'moved to the trash' : 'restored';
		$item_desc = $all ? 'Message Template Group' : 'Message Template Context';
		$this->_redirect_after_admin_action( $success, $item_desc, $action_desc, array() );
	
	}

	/**
	 * [_delete_message_template]
	 * NOTE: at this point only entire message template GROUPS can be deleted because it 
	 * @return void
	 */
	protected function _delete_message_template() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );
		require_once(EVENT_ESPRESSO_INCLUDES_DIR . 'models/EEM_Message_Type.model.php');
			$MTP = EEM_Message_Type::instance();

		$success = 1;

		//checkboxes
		if ( !empty($_POST['checkbox']) && is_array($_POST['checkbox'] ) ) {
			//if array has more than one element then success message should be plural
			$success = count( $_POST['checkbox'] ) > 1 ? 2 : 1;

			//cycle through bulk action checkboxes
			while ( list( $GRP_ID, $value ) = each($_POST['checkbox'] ) ) {
				if ( ! $MTP->delete_by_id(absint($GRP_ID) ) ) {
					$success = 0;
				}
			}
		} else {
			//grab single grp_id and delete
			$GRP_ID = absint($_REQUEST['id'] );
			if ( ! $MTP->delete_by_id($GRP_ID) ) {
				$success = 0;
			}
		}

		$this->_redirect_after_admin_action( $success, 'Message Templates', 'deleted', array() );

	}

	/**
	 * 	_redirect_after_admin_action
	 *	@param int 		$success 				- whether success was for two or more records, or just one, or none
	 *	@param string 	$what 					- what the action was performed on
	 *	@param string 	$action_desc 		- what was done ie: updated, deleted, etc
	 *	@param int 		$query_args		- an array of query_args to be added to the URL to redirect to after the admin action is completed
	 *	@access private
	 *	@return void
	 */
	private function _redirect_after_admin_action( $success = FALSE, $what = 'item', $action_desc = 'processed', $query_args = array() ) {
		global $espresso_notices;

		//echo '<h3>'. __CLASS__ . '->' . __FUNCTION__ . ' <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h3>';

		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '' );

		// overwrite default success messages
		$espresso_notices['success'] = array();
		// how many records affected ? more than one record ? or just one ?
		if ( $success == 2 ) {
			// set plural msg
			$espresso_notices['success'][] = __('The ' . $what . ' have been successfully ' . $action_desc . '.', 'event_espresso');
		} else if ( $success == 1 ) {
			// set singular msg
			$espresso_notices['success'][] = __('The ' . $what . ' has been successfully ' . $action_desc . '.', 'event_espresso');
		}

		// check that $query_args isn't something crazy
		// check that $query_args isn't something crazy
		if ( ! is_array( $query_args )) {
			$query_args = array();
		}
		// grab messages
		$notices = espresso_get_notices( FALSE, TRUE, TRUE, FALSE );
		//combine $query_args and $notices
		$query_args = array_merge( $query_args, $notices );
		// generate redirect url

		// if redirecting to anything other than the main page, add a nonce
		if ( isset( $query_args['action'] )) {
			// manually generate wp_nonce
			$nonce = array( '_wpnonce' => wp_create_nonce( $query_args['action'] . '_nonce' ));
			// and merge that with the query vars becuz the wp_nonce_url function wrecks havoc on some vars
			$query_args = array_merge( $query_args, $nonce );
		} 
		//printr( $query_args, '$query_args  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span>', 'auto' );

		$redirect_url = add_query_arg( $query_args, EE_MSG_ADMIN_URL ); 
		//echo '<h4>$redirect_url : ' . $redirect_url . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
		//die();
		wp_safe_redirect( $redirect_url );	
		exit();
		
	}

	/**
	 * _edit_message_template_fields_meta_box
	 * @access public
	 * @return void
	 */
	public function _edit_message_template_meta_box() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');
		$template_path = $this->template_args['GRP_ID'] ?EE_MSG_TEMPLATE_PATH . 'ee_msg_details_main_edit_meta_box.template.php' : EE_MSG_TEMPLATE_PATH . 'ee_msg_details_main_add_meta_box.template.php';
		echo espresso_display_template( $template_path, $this->template_args, TRUE);
	}

	/**
	 * _add_message_template_meta_box()
	 * 
	 * @access public
	 * @return void
	 */
	public function _add_message_template_meta_box() {
		do_action( 'action_hook_espresso_log', __FILE__, __FUNCTION__, '');
		$template_path = EE_MSG_TEMPLATE_PATH . 'ee_msg_details_main_add_meta_box.template.php';
		echo espresso_display_template( $template_path, $this->template_args, TRUE);
	}


	/**
	 * 	_learn_more_about_message_templates_link
	*	@access protected
	*	@return string
	*/
	protected function _learn_more_about_message_templates_link() {
		return '<a class="hidden" style="margin:0 20px; cursor:pointer; font-size:12px;" >' . __('learn more about how message templates works', 'event_espresso') . '</a>';
	}

	/**
	 * [_event_name description]
	 * This just takes a given event_id and will output the name of the event for it.
	 * @todo: temporary... will need to remove/replace once proper Event models/classes are in place.
	 * @access private
	 * @param  int $evt_id event_id
	 * @return string event_name 
	 */
	private function _event_name($evt_id) {
		global $wpdb;
		$evt_id = absint($evt_id);
		$tablename = $wpdb->prefix . 'events_detail';
		$query = "SELECT event_name FROM {$table_name} WHERE id = '{$evt_id}'";
		$event_name = $wpdb->get_var( $wpdb->prepare($query) );
		return $event_name;
	}
}