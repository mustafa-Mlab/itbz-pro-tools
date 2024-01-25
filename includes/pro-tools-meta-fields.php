<?php

require_once WP_PLUGIN_DIR .'/codestar-framework/cs-framework.php';

/**
 * Meta Box for the BRB2 post type
 */

add_filter('cs_metabox_options', 'meta_fields_for_pro_tools', 100 );
  
function meta_fields_for_pro_tools( $options ){
  
  $options[] = array(
    'id'        => 'exercise_tools',
    'title'     => 'Pro Tools Meta fields',
    'post_type' => 'exercise_tools',
    'context' => 'normal',
    'priority'  => 'default',
    'sections'  => array(

      // begin section
      array(
        'name'   => 'gwm-section-1',
        'fields' => array(
          array(
            'id'      => 'pro-tools-content-type',
            'type'    => 'select',
            'title'   => 'Content type',
            'options' => array(
              'image' => 'image',
              'video' => 'video',
              'pdf'   => 'pdf',
              'audio' => 'audio'
            ),
            'default_option' => 'Select content type'
          ),
          array(
            'id'         => 'pro-tools-image',
            'type'       => 'image',
            'title'      => 'Upload an image',
            'dependency' => array('pro-tools-content-type', '==', 'image')
          ),
          array(
            'id'         => 'pro-tools-pdf',
            'type'       => 'upload',
            'title'      => 'Upload a pdf',
            'dependency' => array('pro-tools-content-type', '==', 'pdf')
          ),
          array(
            'id'         => 'pro-tools-audio',
            'type'       => 'textarea',
            'title'      => 'Embed code of audio from PodBean',
            'dependency' => array('pro-tools-content-type', '==', 'audio'),
            'sanitize'   => false
          ),
          array(
            'id'         => 'pro-tools-video',
            'type'       => 'text',
            'title'      => 'Vimeo video id',
            'dependency' => array('pro-tools-content-type', '==', 'video')
          ),
          array(
            'id'         => 'pro-tools-pdf-banner',
            'type'       => 'image',
            'title'      => 'Upload pdf banner',
            'dependency' => array('pro-tools-content-type', '==', 'pdf')
          ),
          array(
            'id'         => 'pro-tools-video-banner',
            'type'       => 'image',
            'title'      => 'Upload a Video Banner',
            'dependency' => array('pro-tools-content-type', '==', 'video')
          ),
          array(
            'id'         => 'pro-tools-audio-banner',
            'type'       => 'image',
            'title'      => 'Upload a Audio Banner',
            'dependency' => array('pro-tools-content-type', '==', 'audio')
          ),
          array(
            'id'    => 'pro-tools-control-thumb',
            'type'  => 'image',
            'title' => 'Upload a control thumbnail'
          ),
          array(
            'id'    => 'pro-tools-hash-tag',
            'type'  => 'text',
            'title' => 'Add a identity name',
            'desc'  => 'Add a name to control this file location in library page with hash url'
          ),
          array(
            'id'         => 'pro-tools-video_name',
            'type'       => 'text',
            'title'      => 'Video name',
            'desc'       => 'Add video name',
            'dependency' => array('pro-tools-content-type', '==', 'video')
          ),
          array(
            'id'         => 'pro-tools-audio_name',
            'type'       => 'text',
            'title'      => 'Audio name',
            'desc'       => 'Add Audio name',
            'dependency' => array('pro-tools-content-type', '==', 'audio')
          ),
          array(
            'id'         => 'pro-tools-teacher',
            'type'       => 'text',
            'title'      => 'Teacher name',
            'desc'       => 'Add teacher name',
            'dependency' => array('pro-tools-content-type', '==', 'video')
          ),
          array(
            'id'         => 'pro-tools-audio-teacher',
            'type'       => 'text',
            'title'      => 'Teacher name',
            'desc'       => 'Add teacher name',
            'dependency' => array('pro-tools-content-type', '==', 'audio')
          ),
          array(
            'id'         => 'pro-tools-duration',
            'type'       => 'text',
            'title'      => 'Duration',
            'desc'       => 'Vimeo video duration',
            'dependency' => array('pro-tools-content-type', '==', 'video')
          ),
          array(
            'id'         => 'pro-tools-audio-duration',
            'type'       => 'text',
            'title'      => 'Duration',
            'desc'       => 'Audio video duration',
            'dependency' => array('pro-tools-content-type', '==', 'audio')
          ),
          array(
            'id'    => 'pro-tools-description',
            'type'  => 'textarea',
            'title' => 'Description',
            'desc'  => 'Add description,no need for PDF files'
          ),
          array(
            'id'    => 'pro-tools-props',
            'type'  => 'textarea',
            'title' => 'Props',
            'desc'  => 'Add props,no need for pdf files'
          )

        )
      ),

    )
  );

  return $options;
};