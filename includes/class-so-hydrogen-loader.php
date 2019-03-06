<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://www.saberser.com.pt/developers/
 * @since      1.0.0
 *
 * @package    So_Hydrogen
 * @subpackage So_Hydrogen/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    So_Hydrogen
 * @subpackage So_Hydrogen/includes
 * @author     Carlos Artur Matos <carlos.matos@saberser.com.pt>
 */
class So_Hydrogen_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

    /**
	 * The array of widget areas registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $widget_areas    The widget areas registered with WordPress to fire when the plugin loads.
	 */
    	protected $widget_areas;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();
        	$this->widget_areas = array();
        
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}
    
	/**
	 * Add a new sidebar to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $widget_name         The name of the WordPress sidebar that is being registered.
	 * @param    object               $widget_ID           The slug for that sidebar.
	 * @param    string               $widget_description  A small description - default is NULL.
	 */
	public function add_sidebar( $widget_name, $widget_ID, $widget_description = null ) {
		$this->widget_areas = $this->areas( $this->widget_areas, $widget_name, $widget_ID, $widget_description );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}
 
	/**
	 * A utility function that is used to register the sidebars into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $areas               The collection of sidebars that is being registered.
	 * @param    string               $widget_name         The name of the WordPress sidebar that is being registered.
	 * @param    object               $widget_ID           The slug for that sidebar.
	 * @param    string               $widget_description  A small description - default is NULL.
	 * @return   array                                     The collection of sidebars registered with WordPress.
	 */
	private function areas( $areas, $widget_name, $widget_ID, $widget_description ) {

		$areas[] = array(
			'name'              => $widget_name,
			'id'                => $widget_ID,
			'description'       => $widget_description,
		);

		return $areas;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

    /**
	 * Register the sidebars with WordPress.
	 *
	 * @since    1.0.0
	 */
    public function load_widget_areas() {
        
        foreach ( $this->widget_areas as $widget_name ) {
            
        register_sidebar(array(
			'name'              => $widget_name['name'],
			'id'                => $widget_name['id'],
			'description'       => $widget_name['description'],
			'before_widget'     => '<div id="%1$s" class="col-md widget-container align-self-center %2$s">',
			'after_widget'      => '</div>',
			'before_title'      => '<h3 class="widget-title">',
			'after_title'       => '</h3>',
			));
            
        }
    }

}
