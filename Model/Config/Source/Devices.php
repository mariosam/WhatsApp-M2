<?php
/**
 * Class Devices
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/11
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
namespace MarioSAM\WhatsApp\Model\Config\Source;

class Devices implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            'all'       => __('Desktop/Mobile'),
            'desktop'   => __('Desktop Only'),
            'mobile'    => __('Mobile Only')
        ];
    }
}
