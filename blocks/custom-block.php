<?php
/**
 * Block Template File: Custom Block with Color Picker Background
 */

// Register the block
function custom_block_register() {
    wp_register_script(
        'custom-block-js',
        get_template_directory_uri() . '/blocks/custom-block.js',
        array( 'wp-blocks', 'wp-editor', 'wp-components' ),
        filemtime( get_template_directory() . '/blocks/custom-block.js' )
    );

    register_block_type( 'custom/block', array(
        'editor_script' => 'custom-block-js',
    ) );
}
add_action( 'init', 'custom_block_register' );

// Block Template
function custom_block_template( $attributes ) {
    // Set background color from attributes
    $background_color = isset( $attributes['backgroundColor'] ) ? $attributes['backgroundColor'] : '#ffffff';
    ?>
    <div class="custom-block" style="background-color: <?php echo esc_attr( $background_color ); ?>">
        <div class="custom-block-content">
            <p>Your content goes here!</p>
        </div>
    </div>
    <?php
}
add_action( 'the_content', 'custom_block_template' );
