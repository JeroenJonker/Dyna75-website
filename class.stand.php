<?php
/*************************************
 * @version 1.3
 * @author Jaap Voets - Xperience Automatisering
 * NBB interface - standen van een competitie 
 ***********************************/
include_once("class.nbb.php");
 
class Stand extends NBB {
    var $dispatcher;
    var $cmp_ID;
    
    function Stand( $cmp_ID = 0 ) {
        /* constructor van de parent expliciet aanroepen */
        parent::NBB( 0 );
        $this->dispatcher = 'stand.pl';
        $this->cmp_ID = $cmp_ID;
        
        $this->data = '';
        return true;    
    }
    
    /* ophalen van xml en parsen */
    function data() {
        if (! $this->data ) {
            $url = parent::base_url() . $this->dispatcher . '?cmp_ID=' . $this->cmp_ID;
            
            $xml_string = $this->get_xml( $url );
            $data = $this->parse( $xml_string );
            $this->data = $data;
        }
        return $this->data;     
    }
    
    function competitie() {
        $data = $this->data();
        $competitie = $data->competitie[0];
        $nr   = "" . $competitie->nummer;
        $naam = "" . $competitie->naam;
        
        return array($nr, $naam);
    }
    
    /* array met standen info maken */
    function overzicht() {
        $data = $this->data(); 
        
        foreach( $data->competitie[0] as $rang ) {
            $nr = "" . $rang['nr'];
            if ($nr) {
            $lijst[ $nr ]['team']        = "" . $rang->team;
            $lijst[ $nr ]['teamid']      = "" . $rang->team['id'];
            $lijst[ $nr ]['gespeeld']    = "" . $rang->gespeeld;
            $lijst[ $nr ]['punten']      = "" . $rang->punten;
            $lijst[ $nr ]['saldo']       = "" . $rang->saldo;
            $lijst[ $nr ]['eigenscore']  = "" . $rang->eigenscore;
            $lijst[ $nr ]['tegenscore']  = "" . $rang->tegenscore;
            $lijst[ $nr ]['percentage']  = "" . $rang->percentage;
            }
        }
        return $lijst;      
    }
}
?>
