<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sorting Addon class
 *
 * @since 1.0
 */
class ACP_Sorting_Addon extends AC_Addon {

	const OPTIONS_KEY = 'ac_sorting';

	/**
	 * @since 1.0
	 */
	public function __construct() {
		AC()->autoloader()->register_prefix( 'ACP_Sorting', $this->get_plugin_dir() . 'classes' );

		// Column
		add_action( 'ac/column/settings', array( $this, 'register_column_settings' ) );

		// Settings screen
		add_action( 'ac/settings/general', array( $this, 'add_settings' ) );
		add_filter( 'ac/settings/groups', array( $this, 'settings_group' ), 15 );
		add_action( 'ac/settings/group/sorting', array( $this, 'settings_display' ) );

		add_action( 'admin_init', array( $this, 'handle_settings_request' ) );

		// Table screen
		add_action( 'ac/table_scripts', array( $this, 'table_scripts' ) );
		add_action( 'wp_ajax_acp_reset_sorting', array( $this, 'ajax_reset_sorting' ) );

		// After filtering
		add_action( 'ac/table/list_screen', array( $this, 'init_sorting_preference' ), 11 );
		add_action( 'ac/table/list_screen', array( $this, 'handle_sorting' ), 11 );
		add_action( 'ac/table/list_screen', array( $this, 'save_sorting_preference' ), 12 );
	}

	protected function get_file() {
		return __FILE__;
	}

	/**
	 * Get an instance of preferences for the current user
	 *
	 * @return AC_Preferences
	 */
	public function preferences() {
		return new AC_Preferences_Site( 'sorted_by' );
	}

	/**
	 * @since 4.0
	 *
	 * @param AC_ListScreen $list_screen
	 */
	public function handle_sorting( AC_ListScreen $list_screen ) {

		/**
		 * @see WP_List_Table::get_column_info
		 * */
		add_filter( 'manage_' . $list_screen->get_screen_id() . '_sortable_columns', array( $this, 'add_sortable_headings' ) );

		// Handle sorting request
		foreach ( $list_screen->get_columns() as $column ) {
			$model = $this->get_sorting_model( $column );

			if ( ! $model ) {
				continue;
			}

			if ( ! $model->is_active() ) {
				continue;
			}

			if ( $this->get_orderby() !== $this->get_sorting_label( $column ) ) {
				continue;
			}

			$list_screen = $column->get_list_screen();

			if ( ! $list_screen instanceof ACP_Sorting_ListScreen ) {
				continue;
			}

			$model->get_strategy()->manage_sorting();
		}
	}

	/**
	 * Get request var from $_GET
	 *
	 * Don't use filter_input(): $_GET is managed by Admin Columns and filter_input() uses the request headers
	 *
	 * @return false|string
	 */
	private function get_request_var( $key ) {
		return isset( $_GET[ $key ] ) ? $_GET[ $key ] : false;
	}

	/**
	 * @return false|string
	 */
	private function get_orderby() {
		return $this->get_request_var( 'orderby' );
	}

	/**
	 * @return string 'asc' or 'desc'
	 */
	private function get_order() {
		return $this->get_request_var( 'order' ) === 'desc' ? 'desc' : 'asc';
	}

	/**
	 * Sanitizes label so it matches the label sorting url.
	 *
	 * @since 1.0
	 *
	 * @param string $label
	 *
	 * @return string Sanitized string
	 */
	public function get_sorting_label( AC_Column $column ) {

		// Make display label compatible with sorting label in the URL
		if ( $column instanceof ACP_Column_SortingInterface ) {
			return $column->get_name();
		}

		if ( $orderby = $this->is_native_sortable( $column ) ) {
			return $orderby;
		}

		return false;
	}

	/**
	 * Is this column native sortable
	 *
	 * @param AC_Column $column
	 *
	 * @return false|string Orderby parameter that will be used in the query string
	 */
	public function is_native_sortable( AC_Column $column ) {
		$native_sortables = $this->get_native_sortables( $column->get_list_screen() );

		if ( ! isset( $native_sortables[ $column->get_type() ] ) ) {
			return false;
		}

		return $native_sortables[ $column->get_type() ];
	}

	/**
	 * @param AC_ListScreen $list_screen
	 * @param string        $orderby Query string 'orderby' value
	 *
	 * @return string Column name
	 */
	private function get_sortable_column_name_from_orderby( AC_ListScreen $list_screen, $orderby ) {
		if ( ! $list_screen instanceof AC_ListScreenWP ) {
			return $orderby;
		}

		foreach ( $list_screen->get_default_sortable_columns() as $column_name => $data ) {
			if ( $data[0] === $orderby ) {
				return $column_name;
			}
		}

		return $orderby;
	}

	/**
	 * @param AC_ListScreen $list_screen
	 */
	private function get_native_sortables( AC_ListScreen $list_screen ) {
		if ( ! $list_screen instanceof AC_ListScreenWP ) {
			return array();
		}

		$native_sortables = $this->get_stored_default_sortable_columns( $list_screen->get_key() );

		if ( ! $native_sortables ) {
			$native_sortables = array_keys( $list_screen->get_default_sortable_columns() );
		}

		return $native_sortables;
	}

	/**
	 * @since 1.0
	 *
	 * @param array $columns Column name or label
	 *
	 * @return array Column name or Sanitized Label
	 */
	public function add_sortable_headings( $sortable_columns ) {
		$list_screen = AC()->table_screen()->get_current_list_screen();

		if ( ! $list_screen ) {
			return $sortable_columns;
		}

		// Stores the default columns on the listings screen
		if ( ! AC()->is_doing_ajax() && AC()->user_can_manage_admin_columns() ) {
			$this->store_default_sortable_columns( $list_screen->get_key(), $sortable_columns );
		}

		if ( ! $list_screen->get_settings() ) {
			return $sortable_columns;
		}

		$columns = $list_screen->get_columns();

		if ( ! $columns ) {
			return $sortable_columns;
		}

		// Columns that are active and have enabled sort will be added to the sortable headings.
		foreach ( $columns as $column ) {
			if ( $model = $this->get_sorting_model( $column ) ) {

				// Custom column
				if ( $model->is_active() ) {
					$sortable_columns[ $column->get_name() ] = $this->get_sorting_label( $column );
				}
			} elseif ( isset( $sortable_columns[ $column->get_name() ] ) ) {

				// Native column
				$setting = $column->get_setting( 'sort' );
				if ( $setting instanceof ACP_Sorting_Settings && ! $setting->is_active() ) {
					unset( $sortable_columns[ $column->get_name() ] );
				}
			}
		}

		return $sortable_columns;
	}

	/**
	 * Hide or show empty results
	 *
	 * @since 4.0
	 * @return boolean
	 */
	public function show_all_results() {
		return AC()->admin()->get_general_option( 'show_all_results' );
	}

	/**
	 * @param AC_Admin_Page_Settings $settings
	 */
	public function add_settings( $settings ) {
		$settings->single_checkbox( array(
			'name'  => 'show_all_results',
			'label' => __( "Show all results when sorting.", 'codepress-admin-columns' ) . ' ' . $settings->get_default_text( 'off' ),
		) );
	}

	/**
	 * @param AC_Column $column
	 *
	 * @return ACP_Sorting_Model|false
	 */
	public function get_sorting_model( $column ) {
		if ( ! $column instanceof ACP_Column_SortingInterface ) {
			return false;
		}

		$list_screen = $column->get_list_screen();

		if ( ! $list_screen instanceof ACP_Sorting_ListScreen ) {
			return false;
		}

		$model = $column->sorting();

		return $model->set_strategy( $list_screen->sorting( $model ) );
	}

	/**
	 * @param string $list_screen_key
	 * @param string $column_names
	 */
	private function store_default_sortable_columns( $list_screen_key, $column_names ) {
		update_option( self::OPTIONS_KEY . '_' . $list_screen_key . "_default", $column_names );
	}

	/**
	 * Get default sortable headings
	 *
	 * @param $list_screen_key
	 *
	 * @return false|array [ column_name => order_by ] Sortable column names
	 */
	private function get_stored_default_sortable_columns( $list_screen_key ) {
		return get_option( self::OPTIONS_KEY . '_' . $list_screen_key . "_default" );
	}

	/**
	 * Register field settings for sorting
	 *
	 * @param AC_Column $column
	 */
	public function register_column_settings( $column ) {

		// Custom columns
		if ( $model = $this->get_sorting_model( $column ) ) {
			$model->register_settings();
		}

		// Native columns
		if ( $this->is_native_sortable( $column ) ) {
			$setting = new ACP_Sorting_Settings( $column );
			$setting->set_default( 'on' );

			$column->add_setting( $setting );
		}
	}

	/**
	 * Callback for the settings page to add settings for sorting
	 *
	 */
	public function settings_group( $groups ) {
		if ( isset( $groups['sorting'] ) ) {
			return $groups;
		}

		$groups['sorting'] = array(
			'title'       => __( 'Sorting Preferences', 'codepress-admin-columns' ),
			'description' => __( 'This will reset the sorting preference for all users.', 'codepress-admin-columns' ),
		);

		return $groups;
	}

	/**
	 * Callback for the settings page to display settings for sorting
	 *
	 */
	public function settings_display() {
		?>
		<form action="" method="post">
			<?php wp_nonce_field( 'reset-sorting-preference', '_acnonce' ); ?>
			<input type="submit" class="button" value="<?php _e( 'Reset sorting preferences', 'codepress-admin-columns' ); ?>">
		</form>
		<?php
	}

	/**
	 * Reset all sorting preferences for all users
	 *
	 */
	public function handle_settings_request() {
		if ( ! AC()->user_can_manage_admin_columns() ) {
			return;
		}
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, '_acnonce' ), 'reset-sorting-preference' ) ) {
			return;
		}

		$this->preferences()->reset_for_all_users();

		AC()->notice( __( 'All sorting preferences have been reset.', 'codepress-admin-columns' ) );
	}

	/**
	 * When you revisit a page, set the orderby variable so WordPress prints the columns headers properly
	 *
	 * @param AC_ListScreen $list_screen
	 *
	 * @since 4.0
	 */
	public function init_sorting_preference( $list_screen ) {

		// Do not apply any preferences when no columns are stored
		if ( ! $list_screen->get_settings() ) {
			return;
		}

		if ( filter_input( INPUT_GET, 'orderby' ) ) {
			return;
		}

		// Ignore media grid
		if ( 'grid' === filter_input( INPUT_GET, 'mode' ) ) {
			return;
		}

		$preference = $this->get_sorting_preference( $list_screen );

		if ( ! $preference ) {
			$preference = $this->get_sorting_default( $list_screen );
		}

		// Only load when a preference is set for this screen and no orderby is set
		if ( empty( $preference['orderby'] ) || empty( $preference['order'] ) ) {
			return;
		}

		// Set $_GET and $_REQUEST (used by WP_User_Query)
		$_REQUEST['orderby'] = $_GET['orderby'] = $preference['orderby'];
		$_REQUEST['order'] = $_GET['order'] = $preference['order'];
	}

	/**
	 * @param AC_ListScreen $list_screen
	 *
	 * @return array
	 */
	private function get_sorting_default( AC_ListScreen $list_screen ) {

		/**
		 * @param string        $orderby [ string $column_name, bool $descending ]
		 * @param AC_ListScreen $list_screen
		 */
		$default = apply_filters( 'acp/sorting/default', false, $list_screen );

		$sorting = array(
			'orderby' => is_array( $default ) && isset( $default[0] ) ? $default[0] : $default,
			'order'   => is_array( $default ) && isset( $default[1] ) && $default[1] ? 'desc' : 'asc',
		);

		return $sorting;
	}

	/**
	 * @param AC_ListScreen $list_screen
	 *
	 * @return array|false
	 */
	private function get_sorting_preference( AC_ListScreen $list_screen ) {
		$preference = $this->preferences()->get( $list_screen->get_storage_key() );

		if ( empty( $preference['orderby'] ) ) {
			return false;
		}

		// Maybe column no longer exists
		$column_name = $this->get_sortable_column_name_from_orderby( $list_screen, $preference['orderby'] );

		if ( ! $list_screen->get_column_by_name( $column_name ) ) {
			return false;
		}

		return $preference;
	}

	/**
	 * When the orderby (and order) are set, save the preference
	 *
	 * @param AC_ListScreen $list_screen
	 *
	 * @since 4.0
	 */
	public function save_sorting_preference( $list_screen ) {
		if ( $orderby = $this->get_orderby() ) {
			$this->preferences()->set( $list_screen->get_storage_key(), array(
				'orderby' => $orderby,
				'order'   => $this->get_order(),
			) );
		}
	}

	/**
	 * @param AC_ListScreen $list_screen
	 *
	 * @return bool
	 */
	public function delete_sorting_preference( $list_screen ) {
		return $this->preferences()->delete( $list_screen->get_storage_key() );
	}

	/**
	 * @since 1.0
	 *
	 * @param $list_screen AC_ListScreen
	 */
	public function table_scripts( $list_screen ) {
		wp_enqueue_script( 'acp-sorting', $this->get_plugin_url() . 'assets/js/table.js', array( 'jquery' ), ACP()->get_version() );

		wp_localize_script( 'acp-sorting', 'ACP_Sorting', array(
			'reset_button' => array(
				'label'   => __( 'Reset sorting', 'codepress-admin-columns' ),
				'orderby' => $this->show_reset_button( $list_screen ),
			),
		) );

		wp_enqueue_style( 'acp-sorting', $this->get_plugin_url() . 'assets/css/table.css', array(), ACP()->get_version() );
	}

	/**
	 * @param AC_ListScreen $list_screen
	 *
	 * @return string|false Ordered by column name
	 */
	private function show_reset_button( AC_ListScreen $list_screen ) {
		$default = $this->get_sorting_default( $list_screen );

		if ( $this->get_orderby() === $default['orderby'] && $this->get_order() === $default['order'] ) {
			return false;
		}

		$preference = $this->get_sorting_preference( $list_screen );

		if ( ! isset( $preference['orderby'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Ajax reset sorting
	 */
	public function ajax_reset_sorting() {
		check_ajax_referer( 'ac-ajax' );

		$list_screen = AC()->get_list_screen( filter_input( INPUT_POST, 'list_screen' ) );

		if ( ! $list_screen ) {
			wp_die();
		}

		$list_screen->set_layout_id( filter_input( INPUT_POST, 'layout' ) );

		$deleted = $this->delete_sorting_preference( $list_screen );

		wp_send_json_success( $deleted );
	}

}
