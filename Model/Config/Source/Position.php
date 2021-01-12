<?php
/**
 * Class Position
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/11
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
namespace MarioSAM\WhatsApp\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            'bottom-left'   => __('Bottom Left'),
            'bottom-right'  => __('Bottom Right'),
            'top-left'      => __('Top Left'),
            'top-right'     => __('Top Right'),
            'left'          => __('Center Left'),
            'right'         => __('Center Right')
        ];
    }
}
