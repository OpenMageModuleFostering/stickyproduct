<?php

class ConversionBug_Stickyproductsidebar_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_CONFIG_PATH_PRODUCTSTICKYBAR_ENABLED = 'product_sticky_bar/general/status';
    const XML_CONFIG_PATH_PRODUCTSTICKYBAR_ENABLED_PRODUCT = 'product_sticky_bar/general/enable_product';
    const XML_CONFIG_PATH_PRODUCTSTICKYBAR_HEIGHT = 'product_sticky_bar/general/height';
    const PRODUCTSTICKYBAR_ENABLED = 1;

    public function isEnable()
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        if (self::PRODUCTSTICKYBAR_ENABLED == Mage::getStoreConfig(self::XML_CONFIG_PATH_PRODUCTSTICKYBAR_ENABLED, $storeId))
            return true;

        return false;
    }

    public function isEnableProduct()
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        if (((self::PRODUCTSTICKYBAR_ENABLED == Mage::getStoreConfig(self::XML_CONFIG_PATH_PRODUCTSTICKYBAR_ENABLED_PRODUCT, $storeId) && $this->isEnable()) || ($this->detectDevice() && $this->isEnable()))) {
            return true;
        }
        return false;
    }

    public function getHeight()
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        return Mage::getStoreConfig(self::XML_CONFIG_PATH_PRODUCTSTICKYBAR_HEIGHT, $storeId);
    }

    public function detectDevice()
    {

        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

       /* if ($tablet_browser > 0) {
            // do something for tablet devices
            print 'is tablet';
        } else*/ if ($mobile_browser > 0) {
            // do something for mobile devices
            return true;
        } /*else {
            // do something for everything else
            print 'is desktop';
        }*/

    }
}

?>
