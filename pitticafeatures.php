<?php

/**
 * 2020 Pittica S.r.l.s.
 *
 * @author    Lucio Benini <info@pittica.com>
 * @copyright 2020 Pittica S.r.l.s.
 * @license   http://opensource.org/licenses/LGPL-3.0  The GNU Lesser General Public License, version 3.0 ( LGPL-3.0 )
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class PitticaFeatures extends Module
{
    protected $config_form = false;
    
    public function __construct()
    {
        $this->name          = 'pitticafeatures';
        $this->tab           = 'front_office_features';
        $this->version       = '1.0.0';
        $this->author        = 'Pittica';
        $this->need_instance = 1;
        
        parent::__construct();
        
        $this->displayName = $this->l('Features');
        $this->description = $this->l('Sort and organize product features.');
        
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
    }
    
    public function install()
    {
        return parent::install() && $this->registerHook('filterProductContent');
    }
    
    public function hookFilterProductContent($params)
    {
        $features = array();
        
        if (!empty($params['object']['features'])) {
            foreach ($params['object']['features'] as $feature) {
                if (empty($features[$feature['id_feature']])) {
                    $features[$feature['id_feature']] = $feature;
                } else {
                    $features[$feature['id_feature']]['value'] = implode(', ', array(
                        $features[$feature['id_feature']]['value'],
                        $feature['value']
                    ));
                }
            }
        }
        
        $params['object']['features'] = $features;
        
        return $params;
    }
}
