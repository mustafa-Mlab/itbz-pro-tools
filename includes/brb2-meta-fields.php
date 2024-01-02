<?php

require_once WP_PLUGIN_DIR .'/codestar-framework/cs-framework.php';

/**
 * Meta Box for the BRB2 post type
 */

add_filter('cs_metabox_options', 'meta_fields_for_brb2', 100 );
  
function meta_fields_for_brb2( $options ){
  
  $options[] = array(
    'id'        => 'brb2-files',
    'title'     => 'BRB2 Files content',
    'post_type' => 'brb2-files',
    'context' => 'normal',
    'priority'  => 'default',
    'sections'  => array(

      // begin section
      // array(
      //   'name'   => 'gwm-section-1',
      //   'fields' => array(
      //     array(
      //       'id'      => 'brb2-content-type',
      //       'type'    => 'select',
      //       'title'   => 'Content type',
      //       'options' => array(
      //         'image' => 'image',
      //         'video' => 'video',
      //         'pdf'   => 'pdf',
      //         'audio' => 'audio'
      //       ),
      //       'default_option' => 'Select content type'
      //     ),
      //     array(
      //       'id'         => 'brb2-image',
      //       'type'       => 'image',
      //       'title'      => 'Upload an image',
      //       'dependency' => array('brb2-content-type', '==', 'image')
      //     ),
      //     array(
      //       'id'         => 'brb2-pdf',
      //       'type'       => 'upload',
      //       'title'      => 'Upload a pdf',
      //       'dependency' => array('brb2-content-type', '==', 'pdf')
      //     ),
      //     array(
      //       'id'         => 'brb2-audio',
      //       'type'       => 'textarea',
      //       'title'      => 'Embed code of audio from PodBean',
      //       'dependency' => array('brb2-content-type', '==', 'audio'),
      //       'sanitize'   => false
      //     ),
      //     array(
      //       'id'         => 'brb2-video',
      //       'type'       => 'text',
      //       'title'      => 'Vimeo video id',
      //       'dependency' => array('brb2-content-type', '==', 'video')
      //     ),
      //     array(
      //       'id'         => 'brb2-pdf-banner',
      //       'type'       => 'image',
      //       'title'      => 'Upload pdf banner',
      //       'dependency' => array('brb2-content-type', '==', 'pdf')
      //     ),
      //     array(
      //       'id'         => 'brb2-video-banner',
      //       'type'       => 'image',
      //       'title'      => 'Upload a Video Banner',
      //       'dependency' => array('brb2-content-type', '==', 'video')
      //     ),
      //     array(
      //       'id'         => 'brb2-audio-banner',
      //       'type'       => 'image',
      //       'title'      => 'Upload a Audio Banner',
      //       'dependency' => array('brb2-content-type', '==', 'audio')
      //     ),
      //     array(
      //       'id'    => 'brb2-control-thumb',
      //       'type'  => 'image',
      //       'title' => 'Upload a control thumbnail'
      //     ),
      //     array(
      //       'id'    => 'brb2-hash-tag',
      //       'type'  => 'text',
      //       'title' => 'Add a identity name',
      //       'desc'  => 'Add a name to control this file location in library page with hash url'
      //     ),
      //     array(
      //       'id'         => 'brb2-video_name',
      //       'type'       => 'text',
      //       'title'      => 'Video name',
      //       'desc'       => 'Add video name',
      //       'dependency' => array('brb2-content-type', '==', 'video')
      //     ),
      //     array(
      //       'id'         => 'brb2-audio_name',
      //       'type'       => 'text',
      //       'title'      => 'Audio name',
      //       'desc'       => 'Add Audio name',
      //       'dependency' => array('brb2-content-type', '==', 'audio')
      //     ),
      //     array(
      //       'id'         => 'brb2-teacher',
      //       'type'       => 'text',
      //       'title'      => 'Teacher name',
      //       'desc'       => 'Add teacher name',
      //       'dependency' => array('brb2-content-type', '==', 'video')
      //     ),
      //     array(
      //       'id'         => 'brb2-audio-teacher',
      //       'type'       => 'text',
      //       'title'      => 'Teacher name',
      //       'desc'       => 'Add teacher name',
      //       'dependency' => array('brb2-content-type', '==', 'audio')
      //     ),
      //     array(
      //       'id'         => 'brb2-duration',
      //       'type'       => 'text',
      //       'title'      => 'Duration',
      //       'desc'       => 'Vimeo video duration',
      //       'dependency' => array('brb2-content-type', '==', 'video')
      //     ),
      //     array(
      //       'id'         => 'brb2-audio-duration',
      //       'type'       => 'text',
      //       'title'      => 'Duration',
      //       'desc'       => 'Audio video duration',
      //       'dependency' => array('brb2-content-type', '==', 'audio')
      //     ),
      //     array(
      //       'id'    => 'brb2-description',
      //       'type'  => 'textarea',
      //       'title' => 'Description',
      //       'desc'  => 'Add description,no need for PDF files'
      //     ),
      //     array(
      //       'id'    => 'brb2-props',
      //       'type'  => 'textarea',
      //       'title' => 'Props',
      //       'desc'  => 'Add props,no need for pdf files'
      //     )

      //   )
      // )

      array(
        'name' => 'sm-content-section-1',
        'fields' => array(
            array(
                'id' => 'content-type',
                'type' => 'select',
                'title' => 'Select file',
                'class' => 'chosen',
                'options' => osm_get_all_files(),
                'default_option' => 'Select content type',
            ),
        ),
      ),

    )
  );

  return $options;
};