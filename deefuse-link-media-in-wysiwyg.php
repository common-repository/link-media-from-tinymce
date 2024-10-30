<?php
/*
Plugin Name: Link media from TinyMCE
Description: This plugin allows you to create links to elements of the media in the Wysiwyg editor
Author: Aurelien Chappard
Author URI: http://www.deefuse.fr/
Version: 1.0
Network: false
License: GPL
*/

if( !class_exists( 'DeefuseLinkMediaInWysiwyg' ) ) {
    require dirname(__FILE__) . "/includes/settings.php";
    
    class DeefuseLinkMediaInWysiwyg {  
        
        private $pluginPath;
        
        public function __construct()  
		{
            $this->pluginPath = dirname(__FILE__);
            load_plugin_textdomain('deefuseLinkMediaInWysiwyg', false, basename($this->pluginPath).'/languages' );
            
            //Settings
			new DeefuseLinkMediaInWysiwygSettings();
            
            $this->filters_hook();
        }
        

        
        private function filters_hook(){
            add_filter("wp_link_query_args", array(&$this,'alter_link_query_arg'));
            add_filter("wp_link_query", array(&$this,'alter_link_query') );
            
        }
        public function alter_link_query_arg($query){
            $query['post_status'] = array( 'inherit', 'publish' );
            return $query;
        }
        
        public function alter_link_query($results){
            if ( empty( $results ) )
            return $results;
            
            $optionLink = get_option('deefuseLinkMediaInWysiwyg_type', 'media_file');
            foreach ( $results as $idx => $p ) {
                $post = get_post( $p['ID'] );
                if ( 'attachment' == $post->post_type ) {
                    if($optionLink == 'media_file'){
                        $results[$idx]['permalink'] = wp_get_attachment_url( $post->ID );
                    }
                                   
                }
            }          
            return $results;
        }
    }
}
if( class_exists( 'DeefuseLinkMediaInWysiwyg' ) ) {
	$deefuseLinkMediaInWysiwyg_plugin = new DeefuseLinkMediaInWysiwyg();
}