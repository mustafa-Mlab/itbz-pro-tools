<?php 
// Add a custom metabox for each categories of brb2-files

function brb_2_page_meta() {
    $taxonomy = 'brb2_exercise_category';
    $terms = get_terms($taxonomy, );

    if (!empty($terms)) {
        foreach ($terms as $term) {
            add_meta_box('brb_2_page_meta', 'BRB2 File Contains', 'render_brb_2_page_meta', 'page', 'normal', 'high');
        }
    }
    
}

add_action('add_meta_boxes', 'brb_2_page_meta');

// Render the custom metabox content
function render_brb_2_page_meta($post) {
    $foundation = get_post_meta($post->ID, 'brb2_foundation', true);
    $birth_prep = get_post_meta($post->ID, 'brb2_birth_prep', true);
    $birth_position = get_post_meta($post->ID, 'brb2_birth_position', true);
    $birth_tecnique = get_post_meta($post->ID, 'brb2_birth_tecnique', true);
    wp_nonce_field(basename(__FILE__), 'brb_2_page_meta_nonce');
    ?>
    <h2 class="repeter-lable">Foundations</h2> 
    <div class="repeater-container foundation-selector">
        <?php
        $args = array(
            'post_type' => 'brb2-files',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'brb2_exercise_category', 
                    'field'    => 'slug', 
                    'terms'    => 'foundations',
                ),
            ),
        );
        
        $brb2_files = get_posts($args);
        if (!empty($foundation)) {
            foreach ($foundation as $repeater) {
                echo '<div class="repeater-group">';
                echo '<select name="brb2_foundation[]">';
                echo '<option value="">Select a post</option>';

                foreach ($brb2_files as $file) {
                    echo '<option value="' . esc_attr($file->ID) . '"';
                    if ($repeater == $file->ID) {
                        echo ' selected';
                    }
                    echo '>' . esc_html($file->post_title) . '</option>';
                }

                echo '</select>';
                echo '<button class="remove-repeater">Remove</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="repeater-group">';
            echo '<select name="brb2_foundation[]">';
            echo '<option value="">Select a post</option>';
            foreach ($brb2_files as $file) {
                echo '<option value="' . esc_attr($file->ID) . '" >' . esc_html($file->post_title) . '</option>';
            }
            echo '</select>';
            echo '<button class="remove-repeater" style="display: none;">Remove</button>';
            echo '</div>';
        }
        ?>
        
    </div>
    <div class="repeter-control"><button class="add-repeater" data-object="foundation-selector" >Add More Foundations</button></div>

    <h2 class="repeter-lable">Birth Tecniques</h2> 
    <div class="repeater-container birth-tecnique-selector">
        <?php
        $args = array(
            'post_type' => 'brb2-files',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'brb2_exercise_category', 
                    'field'    => 'slug', 
                    'terms'    => 'birth-techniques',
                ),
            ),
        );
        
        $brb2_files = get_posts($args);
        
        if (!empty($birth_tecnique)) {
            foreach ($birth_tecnique as $repeater) {
                echo '<div class="repeater-group">';
                echo '<select name="brb2_birth_tecnique[]">';
                echo '<option value="">Select a post</option>';
                foreach ($brb2_files as $file) {
                    echo '<option value="' . esc_attr($file->ID) . '"';
                    if ($repeater == $file->ID) {
                        echo ' selected';
                    }
                    echo '>' . esc_html($file->post_title) . '</option>';
                }
                echo '</select>';
                echo '<button class="remove-repeater">Remove</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="repeater-group">';
            echo '<select name="brb2_birth_tecnique[]">';
            echo '<option value="">Select a post</option>';
            foreach ($brb2_files as $file) {
                echo '<option value="' . esc_attr($file->ID) . '" >' . esc_html($file->post_title) . '</option>';
            }
            echo '</select>';
            echo '<button class="remove-repeater" style="display: none;">Remove</button>';
            echo '</div>';
        }
        ?>
        
    </div>
    <div class="repeter-control"><button class="add-repeater" data-object="birth-tecnique-selector" >Add More Birth Tecniques</button></div>

    <h2 class="repeter-lable">Birth Prep</h2> 
    <div class="repeater-container birth-prep-selector">
        <?php
        $args = array(
            'post_type' => 'brb2-files',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'brb2_exercise_category', 
                    'field'    => 'slug', 
                    'terms'    => 'birth-prep',
                ),
            ),
        );
        
        $brb2_files = get_posts($args);
        if (!empty($birth_prep)) {
            foreach ($birth_prep as $repeater) {
                echo '<div class="repeater-group">';
                echo '<select name="brb2_birth_prep[]">';
                echo '<option value="">Select a post</option>';
                foreach ($brb2_files as $file) {
                    echo '<option value="' . esc_attr($file->ID) . '"';
                    if ($repeater == $file->ID) {
                        echo ' selected';
                    }
                    echo '>' . esc_html($file->post_title) . '</option>';
                }

                echo '</select>';
                echo '<button class="remove-repeater">Remove</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="repeater-group">';
            echo '<select name="brb2_birth_prep[]">';
            echo '<option value="">Select a post</option>';
            foreach ($brb2_files as $file) {
                echo '<option value="' . esc_attr($file->ID) . '" >' . esc_html($file->post_title) . '</option>';
            }
            echo '</select>';
            echo '<button class="remove-repeater" style="display: none;">Remove</button>';
            echo '</div>';
        }
        ?>
        
    </div>
    <div class="repeter-control"><button class="add-repeater" data-object="birth-prep-selector" >Add More Birth Prep</button></div>

    <h2 class="repeter-lable">Birth Position</h2> 
    <div class="repeater-container birth-position-selector">
        <?php
        $args = array(
            'post_type' => 'brb2-files',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'brb2_exercise_category', 
                    'field'    => 'slug', 
                    'terms'    => 'birth-positions',
                ),
            ),
        );
        
        $brb2_files = get_posts($args);
        if (!empty($birth_position)) {
            foreach ($birth_position as $repeater) {
                echo '<div class="repeater-group">';
                echo '<select name="brb2_birth_position[]">';
                echo '<option value="">Select a post</option>';

                foreach ($brb2_files as $file) {
                    echo '<option value="' . esc_attr($file->ID) . '"';
                    if ($repeater == $file->ID) {
                        echo ' selected';
                    }
                    echo '>' . esc_html($file->post_title) . '</option>';
                }

                echo '</select>';
                echo '<button class="remove-repeater">Remove</button>';
                echo '</div>';
            }
        } else {
            echo '<div class="repeater-group">';
            echo '<select name="brb2_birth_position[]">';
            echo '<option value="">Select a post</option>';
            foreach ($brb2_files as $file) {
                echo '<option value="' . esc_attr($file->ID) . '" >' . esc_html($file->post_title) . '</option>';
            }
            echo '</select>';
            echo '<button class="remove-repeater" style="display: none;">Remove</button>';
            echo '</div>';
        }
        ?>
        
    </div>
    <div class="repeter-control"><button class="add-repeater" data-object="birth-position-selector" >Add More Birth Positions</button></div>
    <?php
}

// Save custom metabox data
function save_brb_2_page_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return $post_id;

    if (!isset($_POST['brb_2_page_meta_nonce']) || !wp_verify_nonce($_POST['brb_2_page_meta_nonce'], basename(__FILE__)))
        return $post_id;

    if (isset($_POST['brb2_foundation'])) {
        update_post_meta($post_id, 'brb2_foundation', $_POST['brb2_foundation']);
    }
    if (isset($_POST['brb2_birth_prep'])) {
        update_post_meta($post_id, 'brb2_birth_prep', $_POST['brb2_birth_prep']);
    }
    if (isset($_POST['brb2_birth_position'])) {
        update_post_meta($post_id, 'brb2_birth_position', $_POST['brb2_birth_position']);
    }
    if (isset($_POST['brb2_birth_tecnique'])) {
        update_post_meta($post_id, 'brb2_birth_tecnique', $_POST['brb2_birth_tecnique']);
    }
}

add_action('save_post', 'save_brb_2_page_meta');
