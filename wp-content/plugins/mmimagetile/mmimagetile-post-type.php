<?php
/**
 *
 * Notice: This is a forked version of the plugin, originally developed by Devin Price. The original plugin is available on wordpress.org and is called "MM Image Tile Post Type."
 *
 * @original-author: Matthias Steinböck
 *
 * @wordpress-plugin
 * Plugin Name: MM Image Tile Content
 * Description: Enables a mmimagetile post type
 * Version:     1.0.0
 * Author:      gruzilla
 * Author URI:  https://abendstille.at
 * Text Domain: mmimagetileposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */
 
// Register Custom Post Type

if ( ! class_exists( 'MMImageTile_Post_Type' ) ) :

    class MMImageTile_Post_Type {

        public function __construct() {

            // Load plugin text domain
            add_action( 'init', array( $this, 'load_textdomain' ) );

            // Run when the plugin is activated
            register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

            // Add the mmimagetile post type and taxonomies
            add_action( 'init', array( $this, 'mmimagetile_init' ) );

            // Thumbnail support for mmimagetile posts
            add_theme_support( 'post-thumbnails', array( 'mmimagetile' ) );

            // Add thumbnails to column view
            add_filter( 'manage_edit-mmimagetile_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
            add_action( 'manage_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );

            // Show mmimagetile post counts in the dashboard
            add_action( 'right_now_content_table_end', array( $this, 'add_mmimagetile_counts' ) );
        }


        /**
         * Load the plugin text domain for translation.
         */
        public function load_textdomain() {

            $domain = 'mmimagetileposttype';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

            load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
            load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
        }

        /**
         * Flushes rewrite rules on plugin activation to ensure mmimagetile posts don't 404.
         *
         * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
         *
         * @uses MMImageTile_Post_Type::mmimagetile_init()
         */
        public function plugin_activation() {
            $this->load_textdomain();
            $this->mmimagetile_init();
            flush_rewrite_rules();
        }

        /**
         * Initiate registrations of post type and taxonomies.
         *
         * @uses MMImageTile_Post_Type::register_post_type()
         * @uses MMImageTile_Post_Type::register_taxonomy_tag()
         * @uses MMImageTile_Post_Type::register_taxonomy_category()
         */
        public function mmimagetile_init() {
            $this->register_post_type();
        }

        /**
         * Enable the MM Image Tile custom post type.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_post_type
         */
        protected function register_post_type() {
            $labels = array(
                'name'               => __( 'MM Image Tile', 'mmimagetileposttype' ),
                'singular_name'      => __( 'MM Image Tile Item', 'mmimagetileposttype' ),
                'add_new'            => __( 'Add New Item', 'mmimagetileposttype' ),
                'add_new_item'       => __( 'Add New MM Image Tile Item', 'mmimagetileposttype' ),
                'edit_item'          => __( 'Edit MM Image Tile Item', 'mmimagetileposttype' ),
                'new_item'           => __( 'Add New MM Image Tile Item', 'mmimagetileposttype' ),
                'view_item'          => __( 'View Item', 'mmimagetileposttype' ),
                'search_items'       => __( 'Search MM Image Tile', 'mmimagetileposttype' ),
                'not_found'          => __( 'No mmimagetile items found', 'mmimagetileposttype' ),
                'not_found_in_trash' => __( 'No mmimagetile items found in trash', 'mmimagetileposttype' ),
            );

            $args = array(
                'labels'          => $labels,
                'public'          => true,
                'supports'        => array(
                    'title',
                    'author',
                ),
                'capability_type' => 'post',
                'rewrite'         => false, // array( 'slug' => 'mmimagetile', ), // Permalinks format
                'menu_position'   => 5,
                'has_archive'     => true,
            );

            $args = apply_filters( 'mmimagetileposttype_args', $args );

            register_post_type( 'mmimagetile', $args );
        }

        /**
         * Add columns to MM Image Tile list screen.
         *
         * @link http://wptheming.com/2010/07/column-edit-pages/
         *
         * @param array $columns Existing columns.
         *
         * @return array Amended columns.
         */
        public function add_thumbnail_column( $columns ) {
            $column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'mmimagetileposttype' ) );
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
                    $image = get_post_meta( $post->ID, 'onioneye_image0', true );
                    if ($image) {
                        echo '<img src="' . $image . '" height="32" width="32">';
                    }
                    break;
            }
        }

        /**
         * Add MM Image Tile count to "Right Now" dashboard widget.
         *
         * @return null Return early if mmimagetile post type does not exist.
         */
        public function add_mmimagetile_counts() {
            if ( ! post_type_exists( 'mmimagetile' ) ) {
                return;
            }

            $num_posts = wp_count_posts( 'mmimagetile' );

            // Published items
            $href = 'edit.php?post_type=mmimagetile';
            $num  = number_format_i18n( $num_posts->publish );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'MM Image Tile Item', 'MM Image Tile Items', intval( $num_posts->publish ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );

            if ( 0 == $num_posts->pending ) {
                return;
            }

            // Pending items
            $href = 'edit.php?post_status=pending&amp;post_type=mmimagetile';
            $num  = number_format_i18n( $num_posts->pending );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'MM Image Tile Item Pending', 'MM Image Tile Items Pending', intval( $num_posts->pending ) );
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
                <td class="first b b-mmimagetile"><?php echo $number; ?></td>
                <td class="t mmimagetile"><?php echo $label; ?></td>
            </tr>
        <?php
        }

    }

    new MMImageTile_Post_Type;

endif;