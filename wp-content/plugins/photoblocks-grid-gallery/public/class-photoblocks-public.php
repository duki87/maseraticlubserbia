<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.greentreelabs.net
 * @since      1.0.0
 *
 * @package    Photoblocks
 * @subpackage Photoblocks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Photoblocks
 * @subpackage Photoblocks/public
 * @author     Diego Imbriani - GreenTreeLabs <diego@greentreelabs.net>
 */
class Photoblocks_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Gallery settings
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $settings    Gallery settings
	 */
	private $settings;

	/**
	 * Gallery values
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $defaults    Default values
	 */
	private $values;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;
		$this->values = array();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Photoblocks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Photoblocks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/photoblocks-public.css', array(), $this->version, 'all' );		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'anime', plugin_dir_url( __FILE__ ) . 'js/anime.min.js', array( ), $this->version, false );		
		wp_enqueue_script( $this->plugin_name . "-map", plugin_dir_url( __FILE__ ) . 'js/photoblocks.map.js', array( 'jquery' ), $this->version, false );				
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/photoblocks.public.js', array( 'jquery', 'photoblocks-map', 'anime' ), $this->version, false );		
	}

	/**
	 * Handle shortcode
	 *
	 * @since    1.0.0
	 */
	public function shortcode_handler($atts) {
		global $wpdb;

		$data = $wpdb->get_row(
			$wpdb->prepare('SELECT * FROM ' . $wpdb->photoblocks . ' WHERE id=%d', intval($atts['id'])),
			ARRAY_A
		);

	
		$gallery_values = json_decode($data['data'], true);

		$this->values[$atts['id']] = array_merge($this->settings->default_values(), $gallery_values);
		$this->values[$atts['id']]['id'] = $atts['id'];

		$gallery = $this->values[$atts['id']];	
		
		foreach($atts as $k => $v) {
			$this->values[$atts['id']][$k] = $v;
			$gallery[$k] = $v;
		}

		if($this->lightbox($atts['id']) == "fancybox")
		{
			wp_enqueue_script( 'fancybox3', plugin_dir_url( __FILE__ ) . 'premium/jquery.fancybox.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_style( 'fancybox3', plugin_dir_url( __FILE__ ) . 'premium/jquery.fancybox.min.css', array(), $this->version, 'all' );
		}
		if($this->lightbox($atts['id']) == "magnific")
		{
			wp_enqueue_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'js/jquery.magnific-popup.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'css/magnific-popup.css', array(), $this->version, 'all' );
		}
		
		$blocks = array();
		
		foreach(json_decode($data['blocks']) as $b) {
			if($b->type == "text" && ! photob_fs()->is_plan_or_trial('ultimate'))
				$b->type = "empty";
			$block = new PhotoBlock($this->values[$atts['id']], $b, $this->settings);
			$blocks []= apply_filters('photoblock_process_block', $block);
		}
//print_r($blocks[1]);

		ob_start();
		include "partials/photoblocks-public-display.php";
		$html = ob_get_clean();

		if($gallery['compress_html'] == 1 && ! isset($_GET["debug"])) {
			$html  = str_replace("\n", '', $html);
			$html  = str_replace("\r", '', $html);
			$html  = preg_replace('/\s+/', ' ', $html);
		}

		return $html;
	}

	/**
	 * return CSS rules
	 *
	 * @since    1.0.0
	 */
	public function css($gallery_id, $property, $field, $mu="")
	{
		return $property . ": " . $this->values[$gallery_id][$field] . $mu . ";\n";
	}

	/**
	 * return CSS gallery selector
	 *
	 * @since    1.0.0
	 */
	public function css_id()
	{
		return $property . ": " . $this->values[$field] . ";\n";
	}

	public function lightbox($gallery_id)
    {
        $field = wp_is_mobile() ? 'lightbox_mobile' : 'lightbox';
        return $this->settings->get($this->values[$gallery_id], $field);
	}
	
	public function caption_effect($gallery_id)
    {
        return $this->settings->get($this->values[$gallery_id], "caption_effect");
	}
	
	public function loading_effect($gallery_id)
    {
        return $this->settings->get($this->values[$gallery_id], "loading_effect");
    }

	public function has_filters($gallery_id)
	{
		$filters_raw = $this->settings->get($this->values[$gallery_id], "filters");
		if(empty($filters_raw))
			return false;

		$filters = explode(";", $filters_raw);

		if(! isset($filters))
			return false;
		
		return count($filters) > 0;
	}

	public function filters($gallery_id)
	{
		if(! $this->has_filters($gallery_id))
			return array();

		$filters = array();
		foreach(explode(";", $this->values[$gallery_id]["filters"]) as $f)
		{
			$filters[Photoblocks_Utils::slugify($f)] = $f;
		}

		return $filters;
	}

	public function show_toggle($gallery_id, $field)
    {
        return isset($this->values[$gallery_id][$field]) && $this->values[$gallery_id][$field] == "1" ? "true" : "false";
	}
	
	public function fancybox_buttons($gallery_id)
	{
		/*'slideShow',
        'fullScreen',
        'thumbs',
        'share',
        //'download',
        //'zoom',
		'close'*/
		$g = $this->values[$gallery_id];
		$options = array("'close'");
		
		if($g["fancybox_slideshow"] == "1")
			$options []= "'slideShow'";
		if($g["fancybox_fullscreen"] == "1")
			$options []= "'fullScreen'";
		if($g["fancybox_thumbnails"] == "1")
			$options []= "'thumbs'";
		if($g["fancybox_social"] == "1")
			$options []= "'share'";
		if($g["fancybox_download"] == "1")
			$options []= "'download'";
		if($g["fancybox_zoom"] == "1")
			$options []= "'zoom'";

		return implode(", ", $options);
	}

	public function hover_options_classes($gallery_id)
	{
		$classes = array();
		if($this->values[$gallery_id]["hover_blur"] == "1")
			$classes []= "pb-blur";

		if($this->values[$gallery_id]["hover_lift"] == "1")
			$classes []= "pb-lift";
		
		return implode(" ", $classes);
	}

	public function css_classes($gallery_id)
	{
		$classes = array();
		if($this->settings->get($this->values[$gallery_id], "caption_background_show_empty") == "1")
			$classes []= "show-empty-overlay";

		return implode(" ", $classes);
	}
}
