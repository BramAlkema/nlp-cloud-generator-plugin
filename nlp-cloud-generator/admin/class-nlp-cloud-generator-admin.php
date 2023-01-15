<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-nlp-cloud-generator-post-generator.php';


class Nlp_Cloud_Generator_Admin {
    private $plugin_name;
    private $version;
	private $post_generator;
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
		$this->post_generator = new Nlp_Cloud_Generator_Post_Generator();
    }
    public function add_options_page() {
        add_options_page(
            'NLP Cloud Generator Settings',
            'NLP Cloud Generator',
            'manage_options',
            'nlp-cloud-generator',
            array( $this, 'render_options_page' )
        );
    }
    public function render_options_page() {
		?>
		<form action='options.php' method='post'>
			<?php
			settings_fields( 'nlp-cloud-generator-settings-group' );
			do_settings_sections( 'nlp-cloud-generator' );
			submit_button();
			?>
		</form>
		<?php
		//error_log("Options page rendered.");
	}

    public function register_setting() {
		register_setting( 'nlp-cloud-generator-settings-group', 'nlp_cloud_api_key' );
		register_setting( 'nlp-cloud-generator-settings-group', 'nlp_cloud_model' );
		add_settings_section(
			'nlp_cloud_settings_section',
			'NLP Cloud Settings',
			array( $this, 'nlp_cloud_settings_section_callback' ),
			'nlp-cloud-generator'
		); 
		//error_log("Before add_settings_field for nlp_api_key");

		add_settings_field(
			'nlp_cloud_api_key',
			'API Key',
			array( $this, 'nlp_cloud_api_key_callback' ),
			'nlp-cloud-generator',
			'nlp_cloud_settings_section'
		);

		//error_log("After add_settings_field for nlp_cloud_api_key");

		add_settings_field(
			'nlp_cloud_model',
			'Model',
			array( $this, 'nlp_cloud_model_callback' ),
			'nlp-cloud-generator',
			'nlp_cloud_settings_section'
		);
		//error_log(var_export(array($this, 'nlp_cloud_api_key_callback'), true));
		//error_log(var_export(array($this, 'nlp_cloud_model_callback'), true));
		//if (is_callable(array($this, 'nlp_cloud_model_callback'))) {
    	//error_log('callback is callable');}
	}
  
	//Callbacks

	public function nlp_cloud_settings_section_callback() {
		echo __( 'Enter your NLP Cloud API Key and select the model to use for generating posts.', 'nlp-cloud-generator' );
		//error_log("Settings section callback end");
	}
	
	public function nlp_cloud_api_key_callback() {
		//error_log("API Key callback start");
		$api_key = get_option( 'nlp_cloud_api_key' );
		echo '<input type="text" name="nlp_cloud_api_key" value="' . esc_attr( $api_key ) . '" class="regular-text">';
		echo '<p class="description">' . __( 'Enter your NLP Cloud API key.', 'nlp-cloud-generator' ) . '</p>';
		//error_log("API Key callback ends");
	}

	public function nlp_cloud_model_callback() {
		//error_log("NLP Cloud Model callback start");
		$model = get_option( 'nlp_cloud_model' );
		echo '<input type="text" name="nlp_cloud_model" value="' . esc_attr( $model ) . '" class="regular-text">';
		echo '<p class="description">' . __( 'Enter the NLP Cloud model you want to use.', 'nlp-cloud-generator' ) . '</p>';
		//error_log("Cloud model callback ends");
	
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 
		'css/nlp-cloud-generator-admin.css', array(), $this->version, 'all' );
		//error_log("CSS ");
	}

	public function enqueue_scripts() {
   	 // Enqueue the script only on the plugin's setting page
    	if ( isset( $_GET['page'] ) && $_GET['page'] == $this->plugin_name . '-settings' ) {
        wp_enqueue_script( $this->plugin_name . '-admin-script', plugin_dir_url( __FILE__ ) . 
		'js/nlp-cloud-generator-admin.js', array( 'jquery' ), $this->version, false );
 	   }
	//	error_log("Enques_scripts");
	}


}

