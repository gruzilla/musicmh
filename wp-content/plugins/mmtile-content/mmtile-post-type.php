<?php
/**
 *
 * Notice: This is a forked version of the plugin, originally developed by Devin Price. The original plugin is available on wordpress.org and is called "MMTile Post Type."
 *
 * @original-author: Devin Price
 * @link: http://wptheming.com/mmtile-post-type/
 *
 * @wordpress-plugin
 * Plugin Name: MMTile Content
 * Description: Enables a mmtile post type and taxonomies.
 * Version:     1.0.0
 * Author:      OnionEye
 * Author URI:  http://themeforest.net/user/onioneye
 * Text Domain: mmtileposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

if ( ! class_exists( 'MMTile_Post_Type' ) ) :

class MMTile_Post_Type {

	public function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Run when the plugin is activated
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Add the mmtile post type and taxonomies
		add_action( 'init', array( $this, 'mmtile_init' ) );

		// Thumbnail support for mmtile posts
		add_theme_support( 'post-thumbnails', array( 'mmtile' ) );

		// Add thumbnails to column view
		add_filter( 'manage_edit-mmtile_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show mmtile post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_mmtile_counts' ) );

		// Add taxonomy terms as body classes
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );

	}


	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_textdomain() {

		$domain = 'mmtileposttype';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Flushes rewrite rules on plugin activation to ensure mmtile posts don't 404.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 *
	 * @uses MMTile_Post_Type::mmtile_init()
	 */
	public function plugin_activation() {
		$this->load_textdomain();
		$this->mmtile_init();
		flush_rewrite_rules();
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses MMTile_Post_Type::register_post_type()
	 * @uses MMTile_Post_Type::register_taxonomy_tag()
	 * @uses MMTile_Post_Type::register_taxonomy_category()
	 */
	public function mmtile_init() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	/**
	 * Get an array of all taxonomies this plugin handles.
	 *
	 * @return array Taxonomy slugs.
	 */
	protected function get_taxonomies() {
		return array( 'mmtile_category' );
	}

	/**
	 * Enable the MMTile custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'MMTile', 'mmtileposttype' ),
			'singular_name'      => __( 'MMTile Item', 'mmtileposttype' ),
			'add_new'            => __( 'Add New Item', 'mmtileposttype' ),
			'add_new_item'       => __( 'Add New MMTile Item', 'mmtileposttype' ),
			'edit_item'          => __( 'Edit MMTile Item', 'mmtileposttype' ),
			'new_item'           => __( 'Add New MMTile Item', 'mmtileposttype' ),
			'view_item'          => __( 'View Item', 'mmtileposttype' ),
			'search_items'       => __( 'Search MMTile', 'mmtileposttype' ),
			'not_found'          => __( 'No mmtile items found', 'mmtileposttype' ),
			'not_found_in_trash' => __( 'No mmtile items found in trash', 'mmtileposttype' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'supports'        => array(
				'title',
				'editor',
				'thumbnail',
				'revisions',
			),
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'mmtile', ), // Permalinks format
			'menu_position'   => 5,
			'has_archive'     => true,
		);

		$args = apply_filters( 'mmtileposttype_args', $args );

		register_post_type( 'mmtile', $args );
	}

	/**
	 * Register a taxonomy for MMTile Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'MMTile Categories', 'mmtileposttype' ),
			'singular_name'              => __( 'MMTile Category', 'mmtileposttype' ),
			'menu_name'                  => __( 'MMTile Categories', 'mmtileposttype' ),
			'edit_item'                  => __( 'Edit MMTile Category', 'mmtileposttype' ),
			'update_item'                => __( 'Update MMTile Category', 'mmtileposttype' ),
			'add_new_item'               => __( 'Add New MMTile Category', 'mmtileposttype' ),
			'new_item_name'              => __( 'New MMTile Category Name', 'mmtileposttype' ),
			'parent_item'                => __( 'Parent MMTile Category', 'mmtileposttype' ),
			'parent_item_colon'          => __( 'Parent MMTile Category:', 'mmtileposttype' ),
			'all_items'                  => __( 'All MMTile Categories', 'mmtileposttype' ),
			'search_items'               => __( 'Search MMTile Categories', 'mmtileposttype' ),
			'popular_items'              => __( 'Popular MMTile Categories', 'mmtileposttype' ),
			'separate_items_with_commas' => __( 'Separate mmtile categories with commas', 'mmtileposttype' ),
			'add_or_remove_items'        => __( 'Add or remove mmtile categories', 'mmtileposttype' ),
			'choose_from_most_used'      => __( 'Choose from the most used mmtile categories', 'mmtileposttype' ),
			'not_found'                  => __( 'No mmtile categories found.', 'mmtileposttype' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'mmtile_category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'mmtileposttype_category_args', $args );

		register_taxonomy( 'mmtile_category', array( 'mmtile' ), $args );
	}

	/**
	 * Add taxonomy terms as body classes.
	 *
	 * If the taxonomy doesn't exist (has been unregistered), then get_the_terms() returns WP_Error, which is checked
	 * for before adding classes.
	 *
	 * @param array $classes Existing body classes.
	 *
	 * @return array Amended body classes.
	 */
	public function add_body_classes( $classes ) {
		$taxonomies = $this->get_taxonomies();

		foreach( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach( $terms as $term ) {
					$classes[] = sanitize_html_class( str_replace( '_', '-', $taxonomy ) . '-' . $term->slug );
				}
			}
		}

		return $classes;
	}

	/**
	 * Add columns to MMTile list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'mmtileposttype' ) );
		return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
	}

	/**
	 * Custom column callback
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param string $column Column ID.
	 */
	public function display_thumbnail( $column ) {
		global $post;
		switch ( $column ) {
			case 'thumbnail':
				echo get_the_post_thumbnail( $post->ID, array(35, 35) );
				break;
		}
	}

	/**
	 * Add taxonomy filters to the mmtile admin page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomies you want to display. Use the taxonomy name or slug
		$taxonomies = $this->get_taxonomies();

		// Must set this to the post type you want the filter(s) displayed on
		if ( 'mmtile' != $typenow ) {
			return;
		}

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj          = get_taxonomy( $tax_slug );
			$tax_name         = $tax_obj->labels->name;
			$terms            = get_terms( $tax_slug );
			if ( 0 == count( $terms ) ) {
				return;
			}
			echo '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			echo '<option value="0">' . __( 'View all categories', 'mmtileposttype' ) . '</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%s"%s />%s</option>',
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug ),
					esc_html( $term->name . '(' . $term->count . ')' )
				);
			}
			echo '</select>';
		}
	}

	/**
	 * Add MMTile count to "Right Now" dashboard widget.
	 *
	 * @return null Return early if mmtile post type does not exist.
	 */
	public function add_mmtile_counts() {
		if ( ! post_type_exists( 'mmtile' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'mmtile' );

		// Published items
		$href = 'edit.php?post_type=mmtile';
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'MMTile Item', 'MMTile Items', intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=mmtile';
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'MMTile Item Pending', 'MMTile Items Pending', intval( $num_posts->pending ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );
	}

	/**
	 * Wrap a dashboard number or text value in a link, if the current user can edit posts.
	 *
	 * @param  string $value Value to potentially wrap in a link.
	 * @param  string $href  Link target.
	 *
	 * @return string        Value wrapped in a link if current user can edit posts, or original value otherwise.
	 */
	protected function link_if_can_edit_posts( $value, $href ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return '<a href="' . esc_url( $href ) . '">' . $value . '</a>';
		}
		return $value;
	}

	/**
	 * Display a number and text with table row and cell markup for the dashboard counters.
	 *
	 * @param  string $number Number to display. May be wrapped in a link.
	 * @param  string $label  Text to display. May be wrapped in a link.
	 */
	protected function display_dashboard_count( $number, $label ) {
		?>
		<tr>
			<td class="first b b-mmtile"><?php echo $number; ?></td>
			<td class="t mmtile"><?php echo $label; ?></td>
		</tr>
		<?php
	}

}

new MMTile_Post_Type;

endif;
