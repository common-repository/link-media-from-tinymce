<?php

if( !class_exists( 'DeefuseLinkMediaInWysiwygSettings' ) ) {
    
    class DeefuseLinkMediaInWysiwygSettings{
        var $settingOptionPage;
		
		public function __construct()  
		{  
			
			$this->init();
            $this->actions();
		}
        
        private function init(){
			$this->settingOptionPage = "deefuse_link_media_in_wsiwyg_options_page";
		}
        
        private function actions(){
			add_action('admin_menu', array(&$this,'create_admin_page_option'));
			add_action('admin_init', array(&$this,'setup_plugin_options'));
		}
        
        /**
		 * Add an option page for the settings
		 */
		public function create_admin_page_option()
		{
			add_options_page(__('Link media from TinyMCE', 'deefuseLinkMediaInWysiwyg'), __('Link media', 'deefuseLinkMediaInWysiwyg'), 'activate_plugins', $this->settingOptionPage, array(&$this, 'printAdminPage'));
		}
        /**
		 * Setup all the plugins settings through the Wordpress Settings API
		 */
		public function setup_plugin_options()
		{
            // Define the default option setting
            if (FALSE == get_option('deefuseLinkMediaInWysiwyg_type')){	
                add_option( 'deefuseLinkMediaInWysiwyg_type', 'media_file'); //Media File or Attachment Page 
            }
            $toto = get_option('deefuseLinkMediaInWysiwyg_type');
            //echo $toto;
            // First, we register a section. This is necessary since all future options must belong to one.  
			add_settings_section(
				'deefuseLinkMediaInWysiwyg_section',						// ID used to identify this section and with which to register options  
				__('Link type', 'deefuseLinkMediaInWysiwyg'),		// Title to be displayed on the administration page  
				array(&$this,'description_likes_settingd_section_callback'),			// Callback used to render the description of the section  
				$this->settingOptionPage							// Page on which to add this section of options  
			); 
            
            add_settings_field(   
				'deefuseLinkMediaInWysiwyg_type1',						// ID used to identify the field throughout the theme  
				'<label><input type="radio" name="deefuseLinkMediaInWysiwyg_type" '.($toto == "media_file" ? 'checked="checked"' : '').' value="media_file"/> '.__('Media File').'</label>',						// The label to the left of the option interface element 
				array(&$this,'field_type1_url_callback'),		// The name of the function responsible for rendering the option interface  
				$this->settingOptionPage,			// The page on which this option will be displayed  
				'deefuseLinkMediaInWysiwyg_section',				// The name of the section to which this field belongs  
				array()									// Arg  
			); 
            
            add_settings_field(   
				'deefuseLinkMediaInWysiwyg_type2',						// ID used to identify the field throughout the theme  
				'<label><input type="radio" name="deefuseLinkMediaInWysiwyg_type" '.($toto == "link_attachement_page" ? 'checked="link_attachement_page"' : '').' value="link_attachement_page"/> '.__('Link to Attachment Page').'</label>',						// The label to the left of the option interface element 
				array(&$this,'field_type2_url_callback'),		// The name of the function responsible for rendering the option interface  
				$this->settingOptionPage,			// The page on which this option will be displayed  
				'deefuseLinkMediaInWysiwyg_section',				// The name of the section to which this field belongs  
				array()									// Arg  
			); 
            
            register_setting('deefuseLinkMediaInWysiwyg_section', 'deefuseLinkMediaInWysiwyg_type', array(&$this,'sanitize_type_url'));

        }
        
        public function sanitize_type_url($input){
            $return = sanitize_text_field($input);
			if($return == "")
				$return  = "media_file";
			
			return $return;
        }
        
        public function field_type1_url_callback(){
			?>
            
			<?php
		}
        public function field_type2_url_callback(){
			?>
           
			<?php
		}
        public function description_likes_settingd_section_callback()
		{
            echo '<p>'.__("When you select a media file from the editor, select the url type Wordpress must return:", "deefuseLinkMediaInWysiwyg").'</p>';
			 
		}
        /**
		 * Setting page output
		 */
		public function printAdminPage(){
			?>
			<div class=wrap>
				<h2><?php _e('Link media from TinyMCE', 'deefuseLinkMediaInWysiwyg') ?></h2>
				  
				<form method="post" action="options.php">  
					<?php settings_fields( 'deefuseLinkMediaInWysiwyg_section' ); ?>  
					<?php do_settings_sections( $this->settingOptionPage ); ?>             
					<?php submit_button(); ?> 
				</form>
			</div>
			<?php
		}
    }
}