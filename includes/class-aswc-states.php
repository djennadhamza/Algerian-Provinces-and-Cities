<?php
if (!defined('ABSPATH')) {
    exit;
}

class ASWC_States {
    public function __construct() {
        // add wooCommerce filters
        add_filter('woocommerce_states', array($this, 'add_algeria_states'));
    }

    
    public function add_algeria_states($states) {
        $states['DZ'] = array( 
            '1'  => __('Adrar', 'algeria-states-wc'),
            '2'  => __('Chlef', 'algeria-states-wc'),
            '3'  => __('Laghouat', 'algeria-states-wc'),
            '4'  => __('Oum El Bouaghi', 'algeria-states-wc'),
            '5'  => __('Batna', 'algeria-states-wc'),
            '6'  => __('Béjaïa', 'algeria-states-wc'),
            '7'  => __('Biskra', 'algeria-states-wc'),
            '8'  => __('Béchar', 'algeria-states-wc'),
            '9'  => __('Blida', 'algeria-states-wc'),
            '10' => __('Bouira', 'algeria-states-wc'),
            '11' => __('Tamanrasset', 'algeria-states-wc'),
            '12' => __('Tébessa', 'algeria-states-wc'),
            '13' => __('Tlemcen', 'algeria-states-wc'),
            '14' => __('Tiaret', 'algeria-states-wc'),
            '15' => __('Tizi Ouzou', 'algeria-states-wc'),
            '16' => __('Algiers', 'algeria-states-wc'),
            '17' => __('Djelfa', 'algeria-states-wc'),
            '18' => __('Jijel', 'algeria-states-wc'),
            '19' => __('Sétif', 'algeria-states-wc'),
            '20' => __('Saïda', 'algeria-states-wc'),
            '21' => __('Skikda', 'algeria-states-wc'),
            '22' => __('Sidi Bel Abbès', 'algeria-states-wc'),
            '23' => __('Annaba', 'algeria-states-wc'),
            '24' => __('Guelma', 'algeria-states-wc'),
            '25' => __('Constantine', 'algeria-states-wc'),
            '26' => __('Médéa', 'algeria-states-wc'),
            '27' => __('Mostaganem', 'algeria-states-wc'),
            '28' => __('MSila', 'algeria-states-wc'),
            '29' => __('Mascara', 'algeria-states-wc'),
            '30' => __('Ouargla', 'algeria-states-wc'),
            '31' => __('Oran', 'algeria-states-wc'),
            '32' => __('El Bayadh', 'algeria-states-wc'),
            '33' => __('Illizi', 'algeria-states-wc'),
            '34' => __('Bordj Bou Arréridj', 'algeria-states-wc'),
            '35' => __('Boumerdès', 'algeria-states-wc'),
            '36' => __('El Tarf', 'algeria-states-wc'),
            '37' => __('Tindouf', 'algeria-states-wc'),
            '38' => __('Tissemsilt', 'algeria-states-wc'),
            '39' => __('El Oued', 'algeria-states-wc'),
            '40' => __('Khenchela', 'algeria-states-wc'),
            '41' => __('Souk Ahras', 'algeria-states-wc'),
            '42' => __('Tipaza', 'algeria-states-wc'),
            '43' => __('Mila', 'algeria-states-wc'),
            '44' => __('Aïn Defla', 'algeria-states-wc'),
            '45' => __('Naâma', 'algeria-states-wc'),
            '46' => __('Aïn Témouchent', 'algeria-states-wc'),
            '47' => __('Ghardaïa', 'algeria-states-wc'),
            '48' => __('Relizane', 'algeria-states-wc'),
            '49' => __('Timimoun', 'algeria-states-wc'),
            '50' => __('Bordj Badji Mokhtar', 'algeria-states-wc'),
            '51' => __('Ouled Djellal', 'algeria-states-wc'),
            '52' => __('Béni Abbès', 'algeria-states-wc'),
            '53' => __('In Salah', 'algeria-states-wc'),
            '54' => __('In Guezzam', 'algeria-states-wc'),
            '55' => __('Touggourt', 'algeria-states-wc'),
            '56' => __('Djanet', 'algeria-states-wc'),
            '57' => __('El Meghaier', 'algeria-states-wc'),
            '58' => __('El Menia', 'algeria-states-wc'),
        );        
        return $states;
    }

}