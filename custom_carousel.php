<?php
namespace WPC\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use PremiumAddons\Includes;
use TheplusAddons\Theplus_Element_Load;

if(!defined('ABSPATH'))exit;
class Custom_Carousel extends Widget_Base{
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script( 'custom_carousel_script',get_template_directory_uri().'/assets/js/custom_carousel.js');
        wp_register_style( 'custom_carousel_style', get_template_directory_uri().'/assets/css/custom_carousel.css');
     }
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\premium_Template_Tags::getInstance();
	}
    public function get_name(){
        return 'Custom Carousel';
    }
    public function get_title(){
        return 'Custom Carousel';
    }
    public function get_icon(){
        return 'fa fa-play-circle-o';
    }
    public function get_categories(){
        return ['general'];
    }
    public function _register_controls(){
        $repeater = new \Elementor\Repeater();
        $this->start_controls_section(
            'section_content',
            ['label' => 'settings']
        ); 
      
        /* $repeater->add_control(
			'show_elements',
			[
				'label' => __( 'Show Elements', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'title'  => __( 'Title', 'plugin-domain' ),
					'description' => __( 'Description', 'plugin-domain' ),
					'button' => __( 'Button', 'plugin-domain' ),
				],
				'default' => [ 'title', 'description' ],
			]
		);*/
        //$repeater = new \Elementor\Repeater();
       // $templateObj = new TheplusAddons\Theplus_Element_Load();
        $repeater->add_control(
            'title', [
                'label' => __( 'Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'title' , 'plugin-domain' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'subtitle', [
                'label' => __( 'Sub Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'subtitle' , 'plugin-domain' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'description',
			[
				'label' => __( 'Description', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'description', 'plugin-domain' ),
				'placeholder' => __( 'Type your description here', 'plugin-domain' ),
			]
        );
        $repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Background Image', 'elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );
        $repeater->add_control(
			'anchor_id', [
				'label' => __( 'Anchor ID', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'anchor_id' , 'plugin-domain' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'list', 
			[
				'label' => __( 'Carousel Slide List', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[	
                        'title' => __( 'add title', 'plugin-domain' ),
                        'subtitle' => __( 'add subtitle', 'plugin-domain' ),
                        'description' => __( 'add description', 'plugin-domain' ),
                        'image' => __( '', 'plugin-domain' ),
                        'anchor_id' => __( 'Anchor_#1', 'plugin-domain' ),
                    ],
                    [	
                        'title' => __( 'add title', 'plugin-domain' ),
                        'subtitle' => __( 'add subtitle', 'plugin-domain' ),
                        'description' => __( 'add description', 'plugin-domain' ),
                        'image' => __( '', 'plugin-domain' ),
                        'anchor_id' => __( 'Anchor_#2', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ anchor_id }}}',
			]
        );
        $this->end_controls_section();

    }   
    public function get_script_depends() {
        return [ 'script-handle',
                'custom_carousel_script'
                ];
    }
    public function get_style_depends(){
        return ['style-handle',
                'custom_carousel_style'];
    }
    //PHP render
    public function render(){
          $settings = $this->get_settings_for_display();
        ?>
                <div class="fp-slides">
                    <div class="fp-slidesContainer" style="width: 400%; display: block; transition: all 0ms ease 0s; transform: translate3d(0px, 0px, 0px);">
                        <?php 
                            $count = 1;
                            foreach($settings['list'] as $index=>$item){
                                ?>
                                    <div class="slide fp-slide <?php
                                        if($count == 1){
                                            echo " active";
                                        }
                                     ?>" id="slide<?php echo $count;?>" data-anchor="<?php echo $item['anchor_id'];?>" style="height: 657px; width: 25%; background-image: url(<?php echo $item['image']['url']; ?>);">        
                                        <div class="right-colmn">    
                                            <div class="title"><?php echo $item['title'] ?></div>
                                            <div class="numimg">
                                                <div class="number sp_number_desktop" id="sp_number"> <?php if($count < 10){echo 0;} echo $count; ?> </div>
                                                <img src="<?php echo $item['image']['url']; ?>" alt="canvas print shop in melbourne australia" title="canvas print shop in melbourne australia">
                                            </div>
                                            <div class="description">
                                                <div class="text-head" id="sp-subhead"><div class="number sp_number_mobile" id="sp_number"> <?php if($count < 10){echo 0;} echo $count; ?> </div><?php echo $item['subtitle']; ?></div>
                                                <div class="dist_from_arr"><?php echo $item['description']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $count++;
                            }
                        ?>
                    </div>
                </div>
               <!-- <div class="fp-slides">
                    <div class="fp-slidesContainer" style="width: 400%; display: block; transition: all 0ms ease 0s; transform: translate3d(0px, 0px, 0px);">
                        <div class="slide fp-slide active" id="slide1" data-anchor="digitally-preparing-images" style="height: 657px; width: 25%; background-image: url(http://canvasprintstudio.com.au/img/bd-slider1.jpg);">
                            <div class="right-colmn">
                                <div class="title"> How is our quality achieved?
                                </div>
                                <div class="numimg">
                                    <div class="number"> 01 </div>
                                    <img src="https://develop.canvasprintstudio.com.au/img/bd-slider-mob/bd-slider1.jpg" alt="canvas print shop in melbourne australia" title="canvas print shop in melbourne australia">
                                </div>
                                <div class="description">
                                    <div class="text-head">Digitally Preparing Images</div>
                                    <div class="dist_from_arr">We review and digitally prepare each image to guarantee you receive the best result. At no extra cost we can improve image resolution, colour, contrast and provide basic retouching.</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide fp-slide" id="slide2" data-anchor="premium-materials" style="height: 657px; width: 25%;">
                            <div class="right-colmn">
                                <div class="title"> How is our quality achieved? </div>
                                <div class="numimg">
                                    <div class="number"> 02 </div>
                                    <img src="https://develop.canvasprintstudio.com.au/img/bd-slider-mob/bd-slider2.jpg" alt="framing large custom canvas in print workshop" title="framing large custom canvas in print workshop">
                                </div>
                                <div class="description">
                                    <div class="text-head">Premium Materials</div>
                                    <div class="dist_from_arr">Our premium archival canvas and genuine Canon inks will ensure your print is visually superior to other canvas prints.</div>
                                </div>
                            </div>
                        </div>
                 </div>
            </div> -->
        <?php
       /*
            $settings = $this->get_settings_for_display();
          echo "<div class='sfull-section'>"; //full section start
                foreach($settings['list'] as $index => $item ){   
                    //check for mobile and desktop
                    echo "<div class='";    //single full page start
                    if($item['show_in_Desktop'] === 'Yes'){
                        echo " desktop_show";
                    }else{
                        echo " desktop_hide";
                    }
                    if($item['show_in_tablet'] === 'Yes'){
                        echo " tablet_show";
                    }else{
                        echo " tablet_hide";
                    }
                    if($item['show_in_mobile'] === 'Yes'){
                        echo " mobile_show";
                    }else{
                        echo " mobile_hide";
                    }
                    
                    echo " section fullpagesection'";
                    echo " anchor_id = '".$item['anchor_id']."'>";
                    //get template
                    $template_title = $item['template'];
                    echo $this->getTemplateInstance()->get_template_content( $template_title );
                    echo "</div>";
                }
            echo "</div>" ; //full section end*/
    }
    //JS Render
    protected function _content_template(){
    
    }
}
?>