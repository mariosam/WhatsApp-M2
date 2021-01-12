<?php
/**
 * Class WhatsAppViewModel
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/10
 * @copyright   Blog do Mario SAM
 * 
 * This class collect the data to show them in frontend.
 */
namespace MarioSAM\WhatsApp\ViewModel;

class WhatsAppViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $_scopeConfig;
    protected $_store;
    
    /**
     * WhatsAppViewModel constructor.
     *
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Api\Data\StoreInterface $store,
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_store = $store;

        //parent::__construct($context);
    }

    /**
     * Check if this module is active or not.
     * 
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_config/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get the phone number of whatsapp support.
     * 
     * @return int
     */
    public function getPhone()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_config/phone', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get the helper message to show next the button on frontend.
     * 
     * @return text
     */
    public function getButtonMessage()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_config/button', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get the welcome message when client open whatsapp chat conversation.
     * 
     * @return text
     */
    public function getWelcome()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_config/welcome', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get the complete whatsapp url to link on frontend button. 
     * 
     * @return url
     */
    public function getUrl()
    {
        $url    = "https://web.whatsapp.com/";
        $phone  = $this->getPhone();
        $text   = $this->getWelcome();
        $browser= $this->getDeviceType();
        $isoCode= substr($this->_store->getLocaleCode(), 0, 2);

        //verificar o device
        if ($browser=="mobile")
        {
            return 'intent://send/'.($phone ? '&phone='.$phone : '').'#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end';
        }

        //se foi configurado para exibir url da pagina junto
        $show = $this->_scopeConfig->getValue('whatsapp/whats_config/url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($show) 
        {
            $text .= " - ".$this->_store->getCurrentUrl(); //junta a msg de boas vindas com a url da pagina navegada.
        }
        
        return $url.'send?l='.$isoCode.($phone ? '&phone='.$phone : '').($text ? '&text='.$text : '');
    }
    
    /**
     * Get top, left, right of the position of button on frontend.
     * 
     * @return text
     */
    public function getPosition()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_display/position', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get types of device this module must show up.
     * 
     * @return boolean
     */
    public function getDevice()
    {
        //le a configuracao para saber em quais dispositivos exibir o botao
        $device = $this->_scopeConfig->getValue('whatsapp/whats_display/device', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        //se for para todos os dispostivos, da ok (true)
        if ($device == "all")
        {
            return true;
        }

        //se a configuracao bate com o tipo de acesso entao da ok (true)
        $browser = $this->getDeviceType();
        if ($device == $browser) 
        {
            return true;
        }
        //nao exibe o botao
        return false;
    }

    /**
     * Get type of device user access
     * 
     * @return text
     */
    public function getDeviceType()
    {
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])
                ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4))) 
        {
            return "mobile";
        } else {
            return "desktop";
        }
    }

    /**
     * Get custom button color for whatsapp button frontend. 
     * 
     * @return int
     */
    public function getButtonColor()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_display/button', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get custom css code to improve frontend.
     * 
     * @return textarea
     */
    public function getCssCustom()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_display/css', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get custom javascript code to improve frontend.
     * 
     * @return textarea
     */
    public function getJsCustom()
    {
        return $this->_scopeConfig->getValue('whatsapp/whats_display/js', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
