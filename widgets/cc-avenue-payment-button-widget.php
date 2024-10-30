<?php
defined('ABSPATH') || exit;
if (!class_exists('Ele_Cc_Ave_Cc_Avenue_Payment_btn')) {
    class Ele_Cc_Ave_Cc_Avenue_Payment_btn extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'cc_avenue_payment_btn_widget';
        }

        public function get_title()
        {
            return esc_html__('CCAvenue Payment Button', 'ele_cc_ave');
        }

        public function get_icon()
        {
            return 'ele_cc_ave_icon';
        }

        public function get_categories()
        {
            return ['basic'];
        }

        public function get_keywords()
        {
            return ['cc', 'avenue', 'payment', 'button'];
        }

        // protected function get_currency_list()
        // {
        //     $currencies = get_woocommerce_currencies();

        //     foreach ($currencies as $code => &$currency) {
        //         $currencies[$code] = $currency . '(' . get_woocommerce_currency_symbol($code) . ')';
        //     }
        //     return $currencies;
        // }

        protected function get_pages_list()
        {
            $pages = get_pages();
            $pages_data = [];
            foreach ($pages as &$page) {
                $pages_data[] = $page->post_title;
            }
            return $pages_data;
        }

        protected function register_controls()
        {
            // Content Tab Start

            $this->start_controls_section(
                'section_title',
                [
                    'label' => esc_html__('Add Payment Information', 'ele_cc_ave'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'ele_cc_ave_amount',
                [
                    'label' => esc_html__('Amount (INR)', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => esc_html__('100', 'ele_cc_ave'),
                ]
            );

            $this->add_control(
                'ele_cc_ave_button_title',
                [
                    'label' => esc_html__('Button Title', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('Pay', 'ele_cc_ave'),
                    'ai' => [
                        'active' => false,
                    ],
                ]
            );
            $this->add_control(
                'ele_cc_ave_custom_css_class',
                [
                    'label' => esc_html__('Custom CSS Class', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('', 'ele_cc_ave'),
                    'ai' => [
                        'active' => false,
                    ],
                ]
            );

            $this->add_control(
                'ele_cc_ave_important_note',
                [
                    'label' => '',
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __(sprintf('<div class="ele_cc_ave_copy" style="margin-top: 50px;display: flex;width: 100%;justify-content: center;align-items: center;">
                            <b>Copyright by &nbsp;</b>
                            <a href="https://bluezeal.in" target="_blank">
                                <img src="%s/images/bluezeal_labs-copyright.png">
                            </a>
                        </div>', 'ele_cc_ave'), plugin_dir_url(ELE_CC_AVE_PLUGIN_FILE)),

                    // 'content_classes' => 'your-class',
                ]
            );

            $this->end_controls_section();

            // Content Tab End


            // Style Tab Start

            $this->start_controls_section(
                'section_title_style',
                [
                    'label' => esc_html__('Title', 'ele_cc_ave'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'background_color',
                [
                    'label' => esc_html__('Background Color', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cc_avenue_payment_button' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'label_color',
                [
                    'label' => esc_html__('Text Color', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cc_avenue_payment_button' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_radius',
                [
                    'label' => esc_html__('Border Radius', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'selectors' => [
                        '{{WRAPPER}} .cc_avenue_payment_button' => 'border-radius : {{VALUE}}px;',
                    ],
                ]
            );

            $this->add_control(
                'important_note',
                [
                    'label' => esc_html__('', 'ele_cc_ave'),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __(sprintf('<div class="ele_cc_ave_copy" style="margin-top: 50px;display: flex;width: 100%;justify-content: center;align-items: center;">
                        <b>Copyright by &nbsp;</b>
                        <a href="https://bluezeal.in" target="_blank">
                            <img src="%s/images/bluezeal_labs-copyright.png">
                        </a>
                    </div>', 'ele_cc_ave'), plugin_dir_url(ELE_CC_AVE_PLUGIN_FILE)),
                    // 'content_classes' => 'your-class',
                ]
            );

            $this->end_controls_section();

            // Style Tab End

        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
?>
            <form method="post" action="<?php echo esc_url(home_url('/') . '?payment-ccavenue=' . time()) ?>">
                <input type="hidden" name="ele_cc_ave_amount" value="<?php echo esc_attr($settings['ele_cc_ave_amount']) ?>">
                <input type="hidden" name="ele_cc_ave_language" value="<?php echo esc_attr($settings['ele_cc_ave_language']) ?>">
                <button class="cc_avenue_payment_button <?php echo esc_attr($settings['ele_cc_ave_custom_css_class']); ?>">
                    <?php echo esc_html($settings['ele_cc_ave_button_title']); ?>
                </button>
            </form>
<?php
        }
    }
}
