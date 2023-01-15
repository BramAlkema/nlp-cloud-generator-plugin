<?php
  class Nlp_Cloud_Generator_Post_Generator {
    private $api_key;
    private $model;
    private $nonce_field;
    private $nonce_action;

    public function __construct() {
        $this->api_key = get_option( 'nlp_cloud_api_key' );
        $this->model = get_option( 'nlp_cloud_model' );
        if ( ! $this->api_key || ! $this->model ) {
            wp_die( 'Please set the API key and model options in the plugin settings.' );
        }
        $this->nonce_field = 'generate_post_nonce';
        $this->nonce_action = 'generate_post';
    }

    public function generate_post_content() {
        error_log("Generate Post Content");
        if ( ! isset( $_POST['post_id'] ) || ! wp_verify_nonce( $_POST['nonce'], 'generate_post' ) ) {
            wp_die( 'Invalid request.' );
        }
            $post_id = sanitize_text_field( $_POST['post_id'] );
            $post_title = get_the_title( $post_id );
            $nlp_cloud = new NLPCloud( $this->api_key, $this->model );
            error_log("New NLPCloud");
            $post_content = $nlp_cloud->generate($post->post_title);
            $post_data = array(
                'ID' => $post_id,
                'post_content' => $post_content
            );
            wp_insert_post($post_data);
            wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . $post_id ) );
            exit;
        }

   public function add_generate_button() {
        $screen = get_current_screen();
        if ( 'post' === $screen->post_type ) {
            echo '<div id="generate-post-button-container">';
            echo '<form action="' . esc_url( admin_url( "admin-post.php" ) ) . '" method="post">';
            echo '<script> function handleFormSubmit(event) {event.preventDefault(); return false;}</script>';
            echo '<input type="hidden" name="action" value= "generate_post1">';
            echo '<input type="hidden" name="post_id" value="' . get_the_ID() . '">';
            echo '<input type="hidden" name="' . $this->nonce_field . '" value="' . wp_create_nonce( $this->nonce_action ) . '">';
            echo '<input type="submit" id="generate-post-button" value="' . __( 'Generate', 'nlp-cloud-generator' ) . '" class="button button-primary button-large">';
            echo '</form></div>';
            error_log(sanitize_text_field($_POST));
        }
    }

    public function run() {
        add_action('media_buttons', array($this, 'add_generate_button'), 20);
        add_action('admin_post_generate_post1', array($this, 'generate_post_content'));
    }
    
}

$nlp_cloud_generator_post_generator = new Nlp_Cloud_Generator_Post_Generator();
$nlp_cloud_generator_post_generator->run();
?>