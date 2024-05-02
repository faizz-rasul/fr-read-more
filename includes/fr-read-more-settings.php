<?php
// FR Read More
if (!defined("ABSPATH")) exit;
function frrm_readmore_add_settings_page() {
    add_menu_page( __( 'WP Read More Settings', 'fr-read-more' ), __( 'WP Read More', 'fr-read-more' ), 'manage_options', 'fr-readmore-settings', 'frrm_readmore_settings_page_callback','dashicons-editor-expand', 80 );
}
add_action( 'admin_menu', 'frrm_readmore_add_settings_page' );

function frrm_readmore_settings_page_callback() {
    ?>
    <div class="wrap">
        <h2><?php echo esc_html( __( 'WP Read More Settings', 'fr-read-more' ) ); ?></h2>
        <form method="post" action="options.php">
			<?php wp_nonce_field( 'frrm_readmore_settings_action', 'frrm_readmore_settings_nonce' ); ?>
            <?php settings_fields( 'frrm_readmore_settings_group' ); ?>
            <?php do_settings_sections( 'fr-readmore-settings' ); ?>
			
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function frrm_readmore_register_settings() {
    register_setting( 'frrm_readmore_settings_group', 'frrm_readmore_option_name', 'frrm_readmore_sanitize_callback' );

    // General Settings Section
    add_settings_section( 'frrm_readmore_general_settings_section', __( 'General Settings', 'fr-read-more' ), 'frrm_readmore_general_settings_section_callback', 'fr-readmore-settings' );
    add_settings_field( 'frrm_readmore_button_title', __( 'ReadMore Heading (Optional)', 'fr-read-more' ), 'frrm_readmore_button_title_callback', 'fr-readmore-settings', 'frrm_readmore_general_settings_section' );

    // Button Fonts and Color Settings Section
    add_settings_section( 'frrm_readmore_button_settings_section', __( 'Button Style Settings', 'fr-read-more' ), 'frrm_readmore_button_settings_section_callback', 'fr-readmore-settings' );
    add_settings_field( 'frrm_readmore_font_size', __( 'Font Size (px)', 'fr-read-more' ), 'frrm_readmore_font_size_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_line_height', __( 'Line Height (px)', 'fr-read-more' ), 'frrm_readmore_line_height_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
	add_settings_field( 'frrm_readmore_font_weight', __( 'Font Weight', 'fr-read-more' ), 'frrm_readmore_font_weight_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_text_align', __( 'Text Align', 'fr-read-more' ), 'frrm_readmore_text_align_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_background_color', __( 'Background Color', 'fr-read-more' ), 'frrm_readmore_background_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_text_color', __( 'Text Color', 'fr-read-more' ), 'frrm_readmore_text_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_border_color', __( 'Border Color', 'fr-read-more' ), 'frrm_readmore_border_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_border_radius', __( 'Border Radius (px)', 'fr-read-more' ), 'frrm_readmore_border_radius_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
	add_settings_field( 'frrm_readmore_button_align', __( 'Button Align', 'fr-read-more' ), 'frrm_readmore_button_align_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_button_width', __( 'Button Width (px)', 'fr-read-more' ), 'frrm_readmore_button_width_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
    add_settings_field( 'frrm_readmore_button_height', __( 'Button Height (px)', 'fr-read-more' ), 'frrm_readmore_button_height_callback', 'fr-readmore-settings', 'frrm_readmore_button_settings_section' );
	
    // Button Hover Color Settings Section
    add_settings_section( 'frrm_readmore_button_hover_settings_section', __( 'Button Hover Style Settings', 'fr-read-more' ), 'frrm_readmore_button_hover_settings_section_callback', 'fr-readmore-settings' );
    add_settings_field( 'frrm_readmore_background_color', __( 'Background Hover Color', 'fr-read-more' ), 'frrm_readmore_background_hover_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_hover_settings_section' );
    add_settings_field( 'frrm_readmore_text_color', __( 'Text Hover Color', 'fr-read-more' ), 'frrm_readmore_text_hover_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_hover_settings_section' );
    add_settings_field( 'frrm_readmore_border_color', __( 'Border Hover Color', 'fr-read-more' ), 'frrm_readmore_border_hover_color_callback', 'fr-readmore-settings', 'frrm_readmore_button_hover_settings_section' );
	add_settings_field( 'frrm_readmore_show_shortcode', __( 'Shortcode', 'fr-read-more' ), 'frrm_readmore_new_field_callback', 'fr-readmore-settings', 'frrm_readmore_button_hover_settings_section' );
}
add_action( 'admin_init', 'frrm_readmore_register_settings' );


// Callback functions for General Settings Section
function frrm_readmore_general_settings_section_callback() {
    echo esc_html__( 'General Settings for the Button', 'fr-read-more' );
}

function frrm_readmore_button_title_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $button_title = isset($option_value['button_title']) ? $option_value['button_title'] : '';
    echo '<input type="text" name="frrm_readmore_option_name[button_title]" placeholder="Read More" value="' . esc_attr( $button_title ) . '">';
}

// Callback functions for Button Settings Section
function frrm_readmore_font_size_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $font_size = isset($option_value['font_size']) ? $option_value['font_size'] : '';
    echo '<input type="text" name="frrm_readmore_option_name[font_size]" placeholder="16" value="' . esc_attr( $font_size ) . '">';
}
function frrm_readmore_line_height_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $line_height = isset($option_value['line_height']) ? $option_value['line_height'] : '';
    echo '<input type="text" name="frrm_readmore_option_name[line_height]" placeholder="30" value="' . esc_attr( $line_height ) . '">';
}
function frrm_readmore_font_weight_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $font_weight = isset($option_value['font_weight']) ? $option_value['font_weight'] : '';
    $font_weights = array(
        'Normal' => 'normal',
        'Bold' => 'bold',
        '900' => '900',
        '800' => '800',
        '700' => '700',
        '600' => '600',
        '500' => '500',
        '400' => '400',
        '300' => '300',
        '200' => '200',
        '100' => '100',
    );
    echo '<select name="frrm_readmore_option_name[font_weight]">';
    foreach ($font_weights as $label => $value) {
        $selected = ( $font_weight == $value ) ? ' selected="selected"' : '';
       echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
    }
    echo '</select>';
}
function frrm_readmore_text_align_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $text_align = isset($option_value['text_align']) ? $option_value['text_align'] : '';
    $text_align_options = array(
        'Center' => 'center',
        'Left' => 'left',
        'Right' => 'right',
    );
    echo '<select name="frrm_readmore_option_name[text_align]">';
    foreach ($text_align_options as $label => $value) {
        $selected = ( $text_align == $value ) ? ' selected="selected"' : '';
		echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
    }
    echo '</select>';
}
function frrm_readmore_button_settings_section_callback() {
    echo esc_html__( 'These options are for customizing the appearance of the Button', 'fr-read-more' );
}
function frrm_readmore_background_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $background_color = isset($option_value['background_color']) ? $option_value['background_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[background_color]" placeholder="#9b9b9b" value="' . esc_attr( $background_color ) . '">';
}
function frrm_readmore_text_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $text_color = isset($option_value['text_color']) ? $option_value['text_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[text_color]" placeholder="#ffffff" value="' . esc_attr( $text_color ) . '">';
}
function frrm_readmore_border_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $border_color = isset($option_value['border_color']) ? $option_value['border_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[border_color]" placeholder="#7e7e7e" value="' . esc_attr( $border_color ) . '">';
}
function frrm_readmore_border_radius_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $border_radius = isset($option_value['border_radius']) ? $option_value['border_radius'] : '';
	echo '<input type="text" name="frrm_readmore_option_name[border_radius]" placeholder="12" value="' . esc_attr( $border_radius ) . '">';
}
function frrm_readmore_button_align_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $button_align = isset($option_value['button_align']) ? $option_value['button_align'] : '';
    $button_align_options = array(
        'Center' => 'center',
        'Left' => 'left',
        'Right' => 'right',
    );
    echo '<select name="frrm_readmore_option_name[button_align]">';
    foreach ($button_align_options as $label => $value) {
        $selected = ( $button_align == $value ) ? ' selected="selected"' : '';
		echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
    }
    echo '</select>';
}
function frrm_readmore_button_width_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $button_width = isset($option_value['button_width']) ? $option_value['button_width'] : '';
    echo '<input type="text" name="frrm_readmore_option_name[button_width]" placeholder="120" value="' . esc_attr( $button_width ) . '">';
}
function frrm_readmore_button_height_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $button_height = isset($option_value['button_height']) ? $option_value['button_height'] : '';
    echo '<input type="text" name="frrm_readmore_option_name[button_height]" placeholder="33" value="' . esc_attr( $button_height ) . '">';
}
// Here is hover color Callback
function frrm_readmore_button_hover_settings_section_callback() {
    echo esc_html__( 'These options are for customizing the appearance of the Button Hover', 'fr-read-more' );
}

function frrm_readmore_background_hover_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $background_hover_color = isset($option_value['background_hover_color']) ? $option_value['background_hover_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[background_hover_color]" placeholder="#9b9b9b" value="' . esc_attr( $background_hover_color ) . '">';
}
function frrm_readmore_text_hover_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $text_hover_color = isset($option_value['text_hover_color']) ? $option_value['text_hover_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[text_hover_color]" placeholder="#000000" value="' . esc_attr( $text_hover_color ) . '">';
}
function frrm_readmore_border_hover_color_callback() {
    $option_value = get_option( 'frrm_readmore_option_name' );
    $border_hover_color = isset($option_value['border_hover_color']) ? $option_value['border_hover_color'] : '';
    echo '<input type="text" class="fr-color-picker" name="frrm_readmore_option_name[border_hover_color]" placeholder="#7e7e7e" value="' . esc_attr( $border_hover_color ) . '">';
}
function frrm_readmore_new_field_callback() {
	echo '<p class="fr-read-more-text">' . esc_html__( 'Copy this shortcode and paste it into your post, page, or text widget content:', 'fr-read-more' ) . '</p>';
    echo '[frrm_expander_maker id="1" more="' . esc_attr__( 'Read more', 'fr-read-more' ) . '" less="' . esc_attr__( 'Read less', 'fr-read-more' ) . '"]' . esc_html__( 'Read more hidden text', 'fr-read-more' ) . '[/frrm_expander_maker]';
}

function frrm_readmore_sanitize_callback( $input ) {
    // Sanitize input here
    return $input;
}

function frrm_readmore_plugin_load_content() {
    // Verify nonce
    if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'frrm_readmore_nonce' ) ) {
        // Nonce verification failed
        wp_send_json_error( 'Security check failed. Please try again.' );
        wp_die(); // Terminate script execution
    }

    // Sanitize the $_POST['id'] parameter
    $post_id = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';

    // Validate $post_id if needed

    // The logic to fetch dynamic content based on $post_id
    $dynamic_content = frrm_get_dynamic_content( $post_id );

    // Send the dynamic content as a JSON response
    wp_send_json_success( $dynamic_content );
    wp_die(); // Always include this to terminate script execution
}

add_action('wp_ajax_frrm_readmore_plugin_load_content', 'frrm_readmore_plugin_load_content'); // For logged-in users /my_plugin_load_content
add_action('wp_ajax_nopriv_frrm_readmore_plugin_load_content', 'frrm_readmore_plugin_load_content'); // For non-logged-in users /my_plugin_load_content

function frrm_get_dynamic_content($id) {
    // Logic to fetch dynamic content based on $id
    return $dynamic_content;
}

// Shortcode 
function frrm_readmore_shortcode( $atts, $content = null ) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'id' => '1',
            'more' => esc_attr__( 'Read more', 'fr-read-more' ),
            'less' => esc_attr__( 'Read less', 'fr-read-more' ),
        ),
        $atts,
        'frrm_expander_maker'
    );
    // Retrieve the nonce value
    $nonce = wp_create_nonce( 'frrm_readmore_nonce' );
	
	// Get saved settings
	$option_value = get_option('frrm_readmore_option_name');

	// Build button style
	$button_style = $btn_align = '';
	if (isset($option_value['font_size']) && !empty($option_value['font_size'])) {
		$button_style .= "font-size: {$option_value['font_size']}px;";
	}
	if (isset($option_value['font_weight']) && !empty($option_value['font_weight'])) {
		$button_style .= "font-weight: {$option_value['font_weight']};";
	}
	if (isset($option_value['text_align']) && !empty($option_value['text_align'])) {
		$button_style .= "text-align: {$option_value['text_align']};";
	}
	if (isset($option_value['line_height']) && !empty($option_value['line_height'])) {
		$button_style .= "line-height: {$option_value['line_height']}px;"; // Adjust line-height
	}
	if (isset($option_value['background_color']) && !empty($option_value['background_color'])) {
		$button_style .= "background-color: {$option_value['background_color']};";
	}
	if (isset($option_value['text_color']) && !empty($option_value['text_color'])) {
		$button_style .= "color: {$option_value['text_color']};";
	}
	if (isset($option_value['border_color']) && !empty($option_value['border_color'])) {
		$button_style .= "border: 1px solid {$option_value['border_color']};";
	}
	if (isset($option_value['border_radius']) && !empty($option_value['border_radius'])) {
		$button_style .= "border-radius: {$option_value['border_radius']}px;";
	}
	if (isset($option_value['button_align']) && !empty($option_value['button_align'])) {
		$btn_align .= "text-align: {$option_value['button_align']};";
	}
	if (isset($option_value['button_width']) && !empty($option_value['button_width'])) {
		$button_style .= "width: {$option_value['button_width']}px;";
		$button_style .= "display: inline-block;"; // Change display property
	}
	if (isset($option_value['button_height']) && !empty($option_value['button_height'])) {
		$button_style .= "height: {$option_value['button_height']}px;";
	}
	// Extract color options
	$background_color = isset($option_value['background_color']) ? $option_value['background_color'] : '';
	$text_color = isset($option_value['text_color']) ? $option_value['text_color'] : '';
	$border_color = isset($option_value['border_color']) ? $option_value['border_color'] : '';
	
	// Extract hover color options
	$hover_background_color = isset($option_value['background_hover_color']) ? $option_value['background_hover_color'] : '';
	$hover_text_color = isset($option_value['text_hover_color']) ? $option_value['text_hover_color'] : '';
	$hover_border_color = isset($option_value['border_hover_color']) ? $option_value['border_hover_color'] : '';

 // Build HTML output
    $output = "<div class='fr-readmore' id='fr-readmore-{$atts['id']}' style='width: 100%;'>
        <div style='{$btn_align}'>
            <span class='fr-readmore-toggle fr-readmore-less' style='{$button_style} display:none;' 
                onmouseover=\"this.style.backgroundColor='{$hover_background_color}'; this.style.color='{$hover_text_color}'; this.style.borderColor='{$hover_border_color}';\"
                onmouseout=\"this.style.backgroundColor='{$background_color}'; this.style.color='{$text_color}'; this.style.borderColor='{$border_color}';\">
                {$atts['less']}
            </span>
        </div>
        <div style='clear:both;'></div>
        <div class='fr-readmore-content' style='display:none; width: 100%;'>
            <p class='elementor-heading-title elementor-size-default'>{$content}</p>
        </div>
        <div style='{$btn_align}'>
            <span class='fr-readmore-toggle fr-readmore-more' style='{$button_style}' 
                onmouseover=\"this.style.backgroundColor='{$hover_background_color}'; this.style.color='{$hover_text_color}'; this.style.borderColor='{$hover_border_color}';\"
                onmouseout=\"this.style.backgroundColor='{$background_color}'; this.style.color='{$text_color}'; this.style.borderColor='{$border_color}';\">
                {$atts['more']}
            </span>
        </div>
        <input type='hidden' name='frrm_readmore_nonce' value='{$nonce}' />
    </div>";
    return $output;
}
add_shortcode( 'frrm_expander_maker', 'frrm_readmore_shortcode' );

