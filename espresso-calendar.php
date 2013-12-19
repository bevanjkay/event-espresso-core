<?php
/*
  Plugin Name: Event Espresso - Calendar
  Plugin URI: http://www.eventespresso.com
  Description: A full calendar addon for Event Espresso. Includes month, week, and day views.
  Version: 2.2.0.DEV
  Author: Event Espresso
  Author URI: http://www.eventespresso.com
  Copyright 2012 Event Espresso (email : support@eventespresso.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA02110-1301USA
 *
 * ------------------------------------------------------------------------
 *
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package			Event Espresso
 * @ author				Seth Shoultes
 * @ copyright			(c) 2008-2011 Event Espresso  All Rights Reserved.
 * @ license			http://eventespresso.com/support/terms-conditions/   * see Plugin Licensing *
 * @ link				http://www.eventespresso.com
 * @ version		 	3.1
 *
 * ------------------------------------------------------------------------
 *
 * EE_Calendar
 *
 * @package				Event Espresso
 * @subpackage			espresso-calendar
 * @author				Seth Shoultes, Chris Reynolds, Brent Christensen 
 *
 * ------------------------------------------------------------------------
 */

/**
		 * Class for containing info about how to display an event  datetime in the calendar
		 */
class EE_Datetime_In_Calendar {

	/**
	 * @var EE_Event $_Event
	 */
	protected $_event;
	protected $_datetime;
	protected $_color = '';
	protected $_textColor = '';
	protected $_classname = '';
	protected $_event_time = '';
	protected $_event_time_no_tags = '';
	protected $_event_img_thumb = '';
	protected $_eventType = '';
	protected $_description = null;
	protected $_tooltip = null;
	protected $_tooltip_my = null;
	protected $_tooltip_at = null;
	protected $_tooltip_style = null;
	protected $_show_tooltips = null;
	public function __construct(EE_Datetime $datetime) {
		$this->_datetime = $datetime;
		$this->_event = $datetime->event();
	}
	
	public function get($variable_name){
		return $this->$variable_name;
	}
	public function set($variable_name,$value){
		return $this->$variable_name = $value;
	}

	/**
	 * Gets color
	 * @return string
	 */
	function color() {
		return $this->get('_color');
	}

	/**
	 * Sets color
	 * @param string $color
	 * @return boolean
	 */
	function set_color($color) {
		return $this->set('_color', $color);
	}

	/**
	 * Gets textColor
	 * @return string
	 */
	function textColor() {
		return $this->get('_textColor');
	}

	/**
	 * Sets textColor
	 * @param string $textColor
	 * @return boolean
	 */
	function set_textColor($textColor) {
		return $this->set('_textColor', $textColor);
	}

	/**
	 * Gets datetime
	 * @return EE_Datetime
	 */
	function datetime() {
		return $this->get('_datetime');
	}

	/**
	 * Sets datetime
	 * @param EE_Datetime $datetime
	 * @return boolean
	 */
	function set_datetime($datetime) {
		return $this->set('_datetime', $datetime);
	}

	/**
	 * Gets event
	 * @return EE_Event
	 */
	function event() {
		return $this->get('_event');
	}

	/**
	 * Sets event
	 * @param EE_Event $event
	 * @return boolean
	 */
	function set_event($event) {
		return $this->set('_event', $event);
	}
	/**
	 * Gets classname
	 * @return string
	 */
	function classname() {
		return $this->get('_classname');
	}

	/**
	 * Sets classname
	 * @param string $classname
	 * @return boolean
	 */
	function set_classname($classname) {
		return $this->set('_classname', $classname);
	}
	/**
	 * Just adds $classname to th eexisting classname attribute
	 * @param string $classname
	 * @return string
	 */
	function add_classname($classname){
		return $this->set('_classname',$this->get('_classname')." ".$classname);
	}
	/**
	 * Gets event_time html
	 * @return string
	 */
	function event_time() {
		return $this->get('_event_time');
	}

	/**
	 * Sets event_time html
	 * @param string $event_time
	 * @return boolean
	 */
	function set_event_time($event_time) {
		$this->set('_event_time_no_tags',strip_tags($event_time));
		return $this->set('_event_time', $event_time);
	}
	/**
	 * Gets event_time_no_tags 
	 * @return string
	 */
	function event_time_no_tags() {
		return $this->get('_event_time_no_tags');
	}

	/**
	 * Gets event_img_thumb HTML
	 * @return string
	 */
	function event_img_thumb() {
		return $this->get('_event_img_thumb');
	}

	/**
	 * Sets event_img_thumb HTML
	 * @param string $event_img_thumb
	 * @return boolean
	 */
	function set_event_img_thumb($event_img_thumb) {
		return $this->set('_event_img_thumb', $event_img_thumb);
	}
	/**
	 * Gets eventType
	 * @return string
	 */
	function eventType() {
		return $this->get('_eventType');
	}

	/**
	 * Sets eventType
	 * @param string $eventType
	 * @return boolean
	 */
	function set_eventType($eventType) {
		return $this->set('_eventType', $eventType);
	}
	
	/**
	 * Gets description
	 * @return string
	 */
	function description() {
		return $this->get('_description');
	}

	/**
	 * Sets description
	 * @param string $description
	 * @return boolean
	 */
	function set_description($description) {
		return $this->set('_description', $description);
	}
	/**
	 * Gets tooltip
	 * @return string
	 */
	function tooltip() {
		return $this->get('_tooltip');
	}

	/**
	 * Sets tooltip
	 * @param string $tooltip
	 * @return boolean
	 */
	function set_tooltip($tooltip) {
		return $this->set('_tooltip', $tooltip);
	}
	/**
	 * Gets tooltip_my
	 * @return string
	 */
	function tooltip_my() {
		return $this->get('_tooltip_my');
	}

	/**
	 * Sets tooltip_my
	 * @param string $tooltip_my
	 * @return boolean
	 */
	function set_tooltip_my($tooltip_my) {
		return $this->set('_tooltip_my', $tooltip_my);
	}
	/**
	 * Gets tooltip_at
	 * @return string
	 */
	function tooltip_at() {
		return $this->get('_tooltip_at');
	}

	/**
	 * Sets tooltip_at
	 * @param string $tooltip_at
	 * @return boolean
	 */
	function set_tooltip_at($tooltip_at) {
		return $this->set('_tooltip_at', $tooltip_at);
	}
	/**
	 * Gets tooltip_style
	 * @return string
	 */
	function tooltip_style() {
		return $this->get('_tooltip_style');
	}

	/**
	 * Sets tooltip_style
	 * @param string $tooltip_style
	 * @return boolean
	 */
	function set_tooltip_style($tooltip_style) {
		return $this->set('_tooltip_style', $tooltip_style);
	}
	/**
	 * Gets show_tooltips
	 * @return boolean
	 */
	function show_tooltips() {
		return $this->get('_show_tooltips');
	}

	/**
	 * Sets show_tooltips
	 * @param boolean $show_tooltips
	 * @return boolean
	 */
	function set_show_tooltips($show_tooltips) {
		return $this->set('_show_tooltips', $show_tooltips);
	}

	
	/**
	 * 
	 * @return array which can be used for converting to json
	 */
	function to_array_for_json(){
		return array(
			'allDay'=>false,
			'className'=>$this->classname(),
			'color'=>$this->color(),
			'end'=>$this->_datetime->end_date('c'),
			'event_days'=>$this->_datetime->length('days', true),
			'event_time'=>$this->event_time(),
			'event_time_no_tags'=>$this->event_time_no_tags(),
			'event_img_thumb'=>$this->event_img_thumb(),
			'eventType'=>$this->eventType(),
			'description'=>$this->description(),
			'id'=>$this->_event->ID(),
			'show_tooltips'=>$this->show_tooltips(),
			'start'=>$this->_datetime->start_date('c'),
			'textColor'=>$this->textColor(),
			'tooltip'=>$this->tooltip(),
			'tooltip_my'=>$this->tooltip_my(),
			'tooltip_at'=>$this->tooltip_at(),
			'tooltip_style'=>$this->tooltip_style(),
			'title'=>$this->_event->name(),
			
			'url'=>$this->_event->get_permalink(),
		);
	}

}

class EE_Calendar {

   /**
     * 	EE_Calendar Object
     * 	@var EE_Calendar $_instance
	 * 	@access 	private 	
     */
	private static $_instance = NULL;

	/**
	 * 	@var 	array	$_calendar_options
	 *  @access 	private
	 */
	private $_calendar_options = array();

	/**
	 * 	@var 	INT	$_event_category_id
	 *  @access 	private
	 */
	private $_event_category_id = 0;

	/**
	 * 	@var 	boolean	$_show_expired
	 *  @access 	private
	 */
	private $_show_expired = TRUE;


	private $timer = NULL;


	/**
	 *@singleton method used to instantiate class object
	 *@access public
	 *@return EE_Calendar instance
	 */	
	public static function instance() {
		// check if class object is instantiated
		if ( self::$_instance === NULL  or ! is_object( self::$_instance ) or ! is_a( self::$_instance, __CLASS__ )) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}





	/**
	 * 	class constructor
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function __construct() {
		
//		$this->timer = new Elapse_time();

		// calendar_version
		define( 'ESPRESSO_CALENDAR_VERSION', $this->calendar_version());
		// define the plugin directory path and URL
		define( 'ESPRESSO_CALENDAR_PLUGINFULLPATH', plugin_dir_path( __FILE__ ));
		define( 'ESPRESSO_CALENDAR_PLUGINFULLURL', plugin_dir_url( __FILE__ ));	
		
		if ( is_admin() ) {			
			register_activation_hook(  __FILE__ , array( $this, 'activation' ));
			require_once( ESPRESSO_CALENDAR_PLUGINFULLPATH . 'calendar_admin.php' );
			EE_Calendar_Admin::instance();
			// ajax hooks
			add_action( 'wp_ajax_get_calendar_events', array( $this, 'get_calendar_events' ));
			add_action( 'wp_ajax_nopriv_get_calendar_events', array( $this, 'get_calendar_events' ));			
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'calendar_scripts' ));
			add_shortcode( 'ESPRESSO_CALENDAR', array( $this, 'espresso_calendar' ));
		}

		add_action( 'widgets_init', array( $this, 'widget_init' ));
		
	}



	/**
	 * 	calendar_version - Define the version of the plugin
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function calendar_version() {
		return '2.2.0.DEV';
	}



	/**
	 * 	activation
	 *
	 *  @return 	void
	 */
	function activation() {		
	    if ( ! current_user_can( 'activate_plugins' )) {
			 return;
		}
	    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	    check_admin_referer( "activate-plugin_{$plugin}" );
	 	require_once( ESPRESSO_CALENDAR_PLUGINFULLPATH . 'calendar_admin.php' );
		EE_Calendar_Admin::activation();
	}



	/**
	 * 	plugin_file
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public static function plugin_file() {
		static $plugin_file;
		if ( ! $plugin_file ) {
		    $plugin_file = plugin_basename( __FILE__ );
		}
		return $plugin_file;
	}
	


	/**
	 * 	get_calendar_options
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	private function _get_calendar_options() {
		if ( empty( $this->_calendar_options ) || ! is_array( $this->_calendar_options )) {
			$this->_calendar_options = get_option( 'espresso_calendar_settings', array() );
		}
		return $this->_calendar_options;
	}



	/**
	 * 	calendar_scripts - Load the scripts and css
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function calendar_scripts() {
		if ( ! defined( 'EVENT_ESPRESSO_VERSION' )) {
			return;
		}
		// get calendar options
		$this->_calendar_options = $this->_get_calendar_options();
		//Load tooltips styles
		$show_tooltips = isset( $this->_calendar_options['show_tooltips'] ) && $this->_calendar_options['show_tooltips'] ? TRUE : FALSE;
		if ( $show_tooltips ) {
			// load jQuery qtip script from CDN with local fallback
			$qtip_js_url = 'cdnjs.cloudflare.com/ajax/libs/qtip2/2.1.1/jquery.qtip.js';
			// is the URL accessible ?
			$test_url = @fopen( $qtip_js_url, 'r' );
			// use CDN URL or local fallback ?
			$qtip_js_url = $test_url !== FALSE ? $qtip_js_url : ESPRESSO_CALENDAR_PLUGINFULLURL . 'scripts/jquery.qtip.js';
			// use CDN URL or local fallback ?
			$qtip_css_url = $test_url !== FALSE ? 'cdnjs.cloudflare.com/ajax/libs/qtip2/2.1.1/jquery.qtip.min.css' : ESPRESSO_CALENDAR_PLUGINFULLURL . 'css/jquery.qtip.min.css';
			// register jQuery qtip
			wp_register_style( 'qtip', $qtip_css_url );
			wp_register_script( 'jquery-qtip', $qtip_js_url, array('jquery'), '2.1.1', TRUE);			
		}
		
		// load base calendar style
		wp_register_style('fullcalendar', ESPRESSO_CALENDAR_PLUGINFULLURL . 'css/fullcalendar.css'); 
		//Check to see if the calendar css file exists in the '/uploads/espresso/' directory
		if (file_exists(EVENT_ESPRESSO_UPLOAD_DIR . "css/calendar.css")) {
			//This is the url to the css file if available
			wp_register_style('espresso_calendar', EVENT_ESPRESSO_UPLOAD_URL . 'css/calendar.css'); 
		} else {
			// EE calendar style
			wp_register_style('espresso_calendar', ESPRESSO_CALENDAR_PLUGINFULLURL . 'css/calendar.css'); 
		}
		//core calendar script
		wp_register_script( 'fullcalendar-min-js', ESPRESSO_CALENDAR_PLUGINFULLURL . 'scripts/fullcalendar.min.js', array('jquery'), '1.6.2', TRUE ); 
		wp_register_script( 'espresso_calendar', ESPRESSO_CALENDAR_PLUGINFULLURL . 'scripts/espresso_calendar.js', array('fullcalendar-min-js'), ESPRESSO_CALENDAR_VERSION, TRUE ); 

		// get the current post
		global $post;
		if ( isset( $post->post_content )) {
			 // check the post content for the short code
			 if ( strpos( $post->post_content, '[ESPRESSO_CALENDAR') !== FALSE ) {
				if ( $show_tooltips ) {
					wp_enqueue_style('qtip');
					wp_enqueue_script('jquery-qtip');
				}
				wp_enqueue_style('fullcalendar');
				wp_enqueue_style('espresso_calendar');
				wp_enqueue_script('espresso_calendar');	
			}
		}
	}



	/**
	 * 	espresso_calendar - Build the short code
	 * 	
	 * 	[ESPRESSO_CALENDAR]
	 * 	[ESPRESSO_CALENDAR show_expired="true"]
	 * 	[ESPRESSO_CALENDAR event_category_id="your_category_identifier"]
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function espresso_calendar( $atts ) {
		
		if ( ! defined( 'EVENT_ESPRESSO_VERSION' )) {
			return '';
		}
		// get calendar options
		$this->_calendar_options = $this->_get_calendar_options();
		$defaults = array_merge( array( 'event_category_id' => '', 'show_expired' => 'false', 'cal_view' => 'month', 'widget' => FALSE, 'show_tooltips' => FALSE ), $this->_calendar_options );
		// make sure $atts is an array
		$atts = is_array( $atts ) ? $atts : array( $atts );
		// set default attributes
		$atts = shortcode_atts( $defaults, $atts );
		// grab some request vars
		$this->_event_category_id = $atts['event_category_id'] = isset( $_REQUEST['event_category_id'] ) && ! empty( $_REQUEST['event_category_id'] ) ? sanitize_key( $_REQUEST['event_category_id'] ) : $atts['event_category_id'];
		$this->_show_expired = $atts['show_expired'] = isset( $_REQUEST['show_expired'] ) && ! empty( $_REQUEST['show_expired'] ) ? sanitize_key( $_REQUEST['show_expired'] ) : $atts['show_expired'];
		// loop thru atts and add to js options
		foreach ( $atts as $att_name => $att_value ) {
			if ( ! empty( $att_value )) {
				$ee_calendar_js_options[$att_name] = is_array( $att_value ) ? stripslashes_deep( $att_value ) : stripslashes( $att_value );
			}
		}
		// i18n some strings
		$ee_calendar_js_options['monthNames'] = array( 
			__('January', 'event_espresso'),
			__('February', 'event_espresso'),
			__('March', 'event_espresso'),
			__('April', 'event_espresso'),
			__('May', 'event_espresso'),
			__('June', 'event_espresso'),
			__('July', 'event_espresso'),
			__('August', 'event_espresso'),
			__('September', 'event_espresso'),
			__('October', 'event_espresso'),
			__('November', 'event_espresso'),
			__('December', 'event_espresso')
		);
			
		$ee_calendar_js_options['monthNamesShort'] =array( 
				__('Jan', 'event_espresso'),
				__('Feb', 'event_espresso'),
				__('Mar', 'event_espresso'),
				__('Apr', 'event_espresso'),
				__('May', 'event_espresso'),
				__('Jun', 'event_espresso'),
				__('Jul', 'event_espresso'),
				 __('Aug', 'event_espresso'),
				__('Sep', 'event_espresso'),
				__('Oct', 'event_espresso'),
				__('Nov', 'event_espresso'),
				__('Dec', 'event_espresso')
			);
				
		$ee_calendar_js_options['dayNames'] = array( 
				__('Sunday', 'event_espresso'),
				__('Monday', 'event_espresso'),
				__('Tuesday', 'event_espresso'),
				__('Wednesday', 'event_espresso'),
				__('Thursday', 'event_espresso'),
				__('Friday', 'event_espresso'),
				__('Saturday', 'event_espresso')
			);
			
		$ee_calendar_js_options['dayNamesShort'] = array( 
				__('Sun', 'event_espresso'),
				__('Mon', 'event_espresso'),
				__('Tue', 'event_espresso'),
				__('Wed', 'event_espresso'),
				__('Thu', 'event_espresso'),
				__('Fri', 'event_espresso'),
				__('Sat', 'event_espresso')
			);
			
		global $org_options;
		$ee_calendar_js_options['theme'] = ! empty( $org_options['style_settings']['enable_default_style'] ) && $org_options['style_settings']['enable_default_style'] == 'Y' ? TRUE : FALSE;
		
//		echo '<h3>$ee_calendar_js_options</h3><pre style="height:auto;border:2px solid lightblue;">' . print_r( $ee_calendar_js_options, TRUE ) . '</pre><br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span>';

		// Get current page protocol
		$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
		// Output admin-ajax.php URL with same protocol as current page
		$ee_calendar_js_options['ajax_url'] = admin_url('admin-ajax.php', $protocol);
		wp_localize_script( 'espresso_calendar', 'eeCAL', $ee_calendar_js_options );
		
		$calendar_class = $atts['widget'] ? 'calendar_widget' : 'calendar_fullsize';

		return '
	<div id="espresso_calendar" class="'. $calendar_class . '">
		<div id="ee-calendar-ajax-loader-dv">
			<img id="ee-calendar-ajax-loader-img" class="ee-ajax-loader-img" style="display:none;" src="' . EE_IMAGES_URL . 'ajax-loader.gif">
		</div>
	</div>
	<div style="clear:both;" ></div>
	<div id="espresso_calendar_images" ></div>
	'; 
	
	}



	/**
	 * 	get_calendar_events
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function get_calendar_events() {
		
//	$this->timer->start();
		remove_shortcode('LISTATTENDEES');
		// get calendar options
		$this->_calendar_options = $this->_get_calendar_options();
		 $enable_cat_classes = isset( $this->_calendar_options['enable_cat_classes'] ) && $this->_calendar_options['enable_cat_classes'] ? TRUE : FALSE;
		 $show_attendee_limit = isset( $this->_calendar_options['show_attendee_limit'] ) && $this->_calendar_options['show_attendee_limit'] ? TRUE : FALSE;
		 $show_time = isset( $this->_calendar_options['show_time'] ) && $this->_calendar_options['show_time'] ? TRUE : FALSE;
		 $show_tooltips = isset( $this->_calendar_options['show_tooltips'] ) && $this->_calendar_options['show_tooltips'] ? TRUE : FALSE;
		if ( $show_tooltips ) {
			$tooltip_my = isset( $this->_calendar_options['tooltips_pos_my_1'] ) && ! empty( $this->_calendar_options['tooltips_pos_my_1'] ) ? $this->_calendar_options['tooltips_pos_my_1'] : 'bottom';
			$tooltip_my .= isset( $this->_calendar_options['tooltips_pos_my_2'] ) && ! empty( $this->_calendar_options['tooltips_pos_my_2'] ) ? ' ' . $this->_calendar_options['tooltips_pos_my_2'] : ' center';
			$tooltip_at = isset( $this->_calendar_options['tooltips_pos_at_1'] ) && ! empty( $this->_calendar_options['tooltips_pos_at_1'] ) ? $this->_calendar_options['tooltips_pos_at_1'] : 'top';
			$tooltip_at .= isset( $this->_calendar_options['tooltips_pos_at_2'] ) && ! empty( $this->_calendar_options['tooltips_pos_at_2']) ? ' ' . $this->_calendar_options['tooltips_pos_at_2'] : ' center';
			$tooltip_style = isset( $this->_calendar_options['tooltip_style'] ) && $this->_calendar_options['tooltip_style'] ? $this->_calendar_options['tooltip_style'] : 'qtip-light';
			$tooltip_word_count = isset( $this->_calendar_options['tooltip_word_count'] ) ? $this->_calendar_options['tooltip_word_count'] : 50;
		}
		$enable_calendar_thumbs = isset( $this->_calendar_options['enable_calendar_thumbs'] ) && $this->_calendar_options['enable_calendar_thumbs'] ? TRUE : FALSE;

		
		$today = date( 'Y-m-d' );
		$month = date('m' );
		$year = date('Y' );
		$start_datetime = isset( $_REQUEST['start_date'] ) ? date( 'Y-m-d H:i:s', absint( $_REQUEST['start_date'] )) : date('Y-m-d H:i:s', mktime( 0, 0, 0, $month, 1, $year ));
		$end_date = isset( $_REQUEST['end_date'] ) ? date( 'Y-m-d H:i:s', absint( $_REQUEST['end_date'] )) : date('Y-m-t H:i:s', mktime( 0, 0, 0, $month, 1, $year ));
		$show_expired = isset( $_REQUEST['show_expired'] ) ? sanitize_key( $_REQUEST['show_expired'] ) : $this->_show_expired;	
		// set boolean for categories 
		$use_categories = isset($this->_calendar_options['disable_categories']) && $this->_calendar_options['disable_categories'] == FALSE ? TRUE : FALSE;
		$event_category_id = isset( $_REQUEST['event_category_id'] ) && ! empty( $_REQUEST['event_category_id'] ) ? sanitize_key( $_REQUEST['event_category_id'] ) : $this->_event_category_id;
		if($event_category_id){
			$where_params['Event.Term_Taxonomy.term_taxonomy_id'] = $event_category_id;
		}
		$where_params['Event.status'] = 'publish';
		
		$where_params['DTT_EVT_start*1']= array('>=',$start_datetime);
		$where_params['DTT_EVT_start*2'] = array('<=',$end_date);
//		if($show_expired == 'false'){
//			$where_params['DTT_EVT_start*3'] = array('>=',$today);
//			$where_params['Ticket.TKT_end_date'] = array('>=',$today);
//		}
		$datetime_objs = EEM_Datetime::instance()->get_all(array($where_params,'order_by'=>array('DTT_EVT_start'=>'ASC')));
		/* @var $datetime_objs EE_Datetime[] */
				
//	$this->timer->stop();
//	echo $this->timer->get_elapse( __LINE__ );
		
		$calendar_datetimes_for_json = array();
		foreach ( $datetime_objs as $datetime ) {
			/* @var $datetime EE_Datetime */
			$calendar_datetime = new EE_Datetime_In_Calendar($datetime);
//	$this->timer->start();
			$event = $datetime->event();
			/* @var $event EE_Event */
			if( ! $event ){
				EE_Error::add_error(sprintf(__("Datetime data for datetime with ID %d has no associated event!", "event_espresso"),$datetime->ID()));
				continue;
			}
			//Get details about the category of the event
			if ($use_categories) {
				$primary_cat = $event->first_term_taxonomy();
				//any term_taxonmies set for this event?
				if ( $primary_cat ) {
					if($primary_cat->get_extra_meta('use_pickers',true,false)){
						$calendar_datetime->set_color($primary_cat->get_extra_meta('color',true,null));
						$calendar_datetime->set_textColor($primary_cat->get_extra_meta('text_color',true,null));
						
					}
					$calendar_datetime->set_eventType($primary_cat->taxonomy());
					if ( $enable_cat_classes ) {
						foreach ( $event->term_taxonomies() as $term_taxonomy ) {
							$calendar_datetime->add_classname($term_taxonomy->taxonomy());
						}				
					} else {
						$calendar_datetime->add_classname($primary_cat->taxonomy());
					}
				}
				
			}

			if ( $datetime->is_expired() ) {
				$calendar_datetime->set_classname('expired');
			}
			

			$startTime = $datetime->start_time($this->_calendar_options['time_format']) ? '<span class="event-start-time">' . $datetime->start_time($this->_calendar_options['time_format']) . '</span>' : FALSE;
			$endTime = $datetime->end_time($this->_calendar_options['time_format']) ? '<span class="event-end-time">' . $datetime->end_time($this->_calendar_options['time_format']) . '</span>' : FALSE;

			if ( $show_time && $startTime ) {
				$event_time_html = '<span class="time-display-block">' . $startTime;
				$event_time_html .= $endTime ? ' - ' . $endTime : '';
				$event_time_html .= '</span>';
			} else {
				$event_time_html = FALSE;
			}
			$calendar_datetime->set_event_time($event_time_html);
			
					
			// Add thumb to event
			if ( $enable_calendar_thumbs ) {
				
				$thumbnail_url = $event->feature_image_url('thumbnail');
				if ( $thumbnail_url ) { 
					$calendar_datetime->set_event_img_thumb( '
					<span class="thumb-wrap">
						<img id="ee-event-thumb-' . $datetime->ID() . '" class="ee-event-thumb" src="' . $thumbnail_url . '" alt="image of ' . $event->name() . '" />
					</span>');
					$calendar_datetime->add_classname('event-has-thumb');
				}
			}

//	$this->timer->stop();
//	echo $this->timer->get_elapse( __LINE__ );
//	$this->timer->start();

			if ( $show_tooltips ) {
				//Gets the description of the event. This can be used for hover effects such as jQuery Tooltips or QTip
				$description = $event->description_filtered();
				
				//Supports 3.1 short descriptions
//				if ( false ){// isset( $org_options['display_short_description_in_event_list'] ) && $org_options['display_short_description_in_event_list'] == 'Y' ) {
				$desciption_parts =  explode( '<!--more-->', $description);
				if(is_array($desciption_parts)){
					$description = array_shift($desciption_parts);
				}
//				}
				// and just in case it's still too long, or somebody forgot to use the more tag...
				$calendar_datetime->set_description($description);			
// tooltip wrapper
				$tooltip_html = '<div class="qtip_info">';
				// show time ?
				$tooltip_html .= $show_time && $startTime ? '<p class="time_cal_qtip">' . __('Event Time: ', 'event_espresso') . $startTime . ' - ' . $endTime . '</p>' : '';
				
				$tickets_initially_available_at_datetime = $datetime->sum_tickets_initially_available();

				// add attendee limit if set
				if ( $show_attendee_limit ) {
					$tickets_sold = $datetime->sold();
					$attendee_limit_text = $datetime->total_tickets_available_at_this_datetime() == -1 ? __('Available Spaces: unlimited', 'event_espresso') : __('Registrations / Spaces: ', 'event_espresso') . $tickets_sold . ' / ' . $tickets_initially_available_at_datetime;
					$tooltip_html .= ' <p class="attendee_limit_qtip">' .$attendee_limit_text . '</p>';
				}

				//add link
				$regButtonText = $event->display_reg_form() ?  __('Register Now', 'event_espresso') :  __('View Details', 'event_espresso');
				// reg open
				if ( $event->is_sold_out() || $datetime->sold_out() || $datetime->total_tickets_available_at_this_datetime() == 0) {
					$tooltip_html .= '<div class="sold-out-dv">' . __('Sold Out', 'event_espresso') . '</div>';				
				} else if($event->is_cancelled()){
					$tooltip_html .= '<div class="sold-out-dv">' . __('Registration Closed', 'event_espresso') . '</div>';				
				}else{
					'<a class="reg-now-btn" href="' . $event->get_permalink() . '">' . $regButtonText . '</a>';				
				}

				$tooltip_html .= '<div class="clear"></div>';
				$tooltip_html .= '</div>';
				$calendar_datetime->set_tooltip($tooltip_html);
				
				
				// Position my top left...
				$calendar_datetime->set_tooltip_my($tooltip_my);
				$calendar_datetime->set_tooltip_at($tooltip_at);
				$calendar_datetime->set_tooltip_style( $tooltip_style );
				$calendar_datetime->set_show_tooltips(true);
			} else {
				$calendar_datetime->set_show_tooltips(FALSE);
			}
			$calendar_datetimes_for_json [] = $calendar_datetime->to_array_for_json();
			
//	$this->timer->stop();
//	echo $this->timer->get_elapse( __LINE__ );

		}
//		echo '<h3>$events</h3><pre style="height:auto;border:2px solid lightblue;">' . print_r( $events, TRUE ) . '</pre><br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span>';
		echo json_encode( $calendar_datetimes_for_json );
		die();

	}
	
	




	/**
	 * 	widget_init
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function widget_init() {
		if ( ! file_exists( ESPRESSO_CALENDAR_PLUGINFULLPATH . 'espresso-calendar-widget.php' )) {
			echo 'An error occurred. The file espresso-calendar-widget.php could not be found.';
		} else {		
			include_once(ESPRESSO_CALENDAR_PLUGINFULLPATH . 'espresso-calendar-widget.php');
			// registers our widget
			register_widget('Espresso_Calendar_Widget'); 
		}
	}




	/**
	 *		@ override magic methods
	 *		@ return void
	 */	
	public function __set($a,$b) { return FALSE; }
	public function __get($a) { return FALSE; }
	public function __isset($a) { return FALSE; }
	public function __unset($a) { return FALSE; }
	public function __clone() { return FALSE; }
	public function __wakeup() { return FALSE; }	
	public function __destruct() { return FALSE; }		

}
EE_Calendar::instance();






// http://uniapple.net/blog/?p=274
/*class Elapse_time {
	private $_start = 0;
	private $_stop = 0;
	private $_elpase = 0;

	public function start(){
		$this->_start = array_sum(explode(' ',microtime()));
	}
	public function stop(){
		$this->_stop = array_sum(explode(' ',microtime()));
	}
	public function get_elapse( $line_nmbr ){
		$this->_elpase = $this->_stop - $this->_start;
		return sprintf( 'L# %d) elpased time : %.3f<br/>', $line_nmbr, $this->_elpase );
	}
}*/
// End of file espresso-calendar.php
// Location: /espresso-calendar/espresso-calendar.php