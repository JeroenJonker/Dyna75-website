<?php
/*************************************
 * @version 1.6
 * @author Jaap Voets - Xperience Automatisering
 * competitie lijst opvragen 
 ***********************************/
include_once("class.nbb.php");
 
class Competitie extends NBB {
    var $dispatcher;
    var $xml;
    var $filter;

    function Competitie( $org_ID = 0) {
        /* constructor van de parent expliciet aanroepen */
        parent::NBB( $org_ID );
        $this->dispatcher = 'competities.pl';
        
        $this->data   = '';
        $this->filter = '';
        return true;    
    }
    
    /* ophalen van xml en parsen */
    function data() {
        
        if (! $this->data ) {
            $url = parent::base_url() . $this->dispatcher . '?org_ID=' . parent::org_id();
            $url .= $this->filter;

            $xml_string = $this->get_xml( $url );
            $data = $this->parse( $xml_string );
            $this->data = $data;
        }
        return $this->data;     
    }
    
    /* lijst met ID en naam genereren */
    function lijst() {
        $data = $this->data(); 
        //$lijst = array();
        foreach( $data->organisatie as $org ) {
            foreach ($org->competitie as $comp ) {
                $id = $comp['id'];
                $lijst[ "$id" ] = $comp->nummer . ' - ' . $comp->naam;
            }   
        }
        return $lijst;      
    }
    

    function links() {
        $data = $this->data(); 
        foreach( $data->organisatie as $org ) {
            foreach ($org->competitie as $comp ) {      
                $nr = "" . $comp->nummer;
                $lijst[ $nr ]['id']        = "" . $comp['id'];
                $lijst[ $nr ]['naam']      = "" . $comp->naam;
                $lijst[ $nr ]['standen']   = "" . $comp->standen;
                $lijst[ $nr ]['uitslagen'] = "" . $comp->uitslagen;
            }   
        }
        return $lijst;  
    }
        
    function standen_links() {
        $data = $this->data(); 
        foreach( $data->organisatie as $org ) {
            foreach ($org->competitie as $comp ) {      
                $lijst[ "" . $comp->nummer ] = "" . $comp->standen;
            }   
        }
        return $lijst;  
    }

    /* filter for a specific Club using the ISS number for that club*/
    function club( $clb_ISSnum = 0 ) {
        $this->filter .= "&clb_ISSnum=$clb_ISSnum"; 
    }

    /* filter for a specific clb_ID as specified in the NBB database */
    function clubid( $clb_ID = 0 ) {
        $this->filter .= "&clb_ID=$clb_ID"; 
    }

    /* filter on particular season */
    function seizoen( $seizoen = '' ) {
        $this->filter .= "&seizoen=$seizoen";   
    }
    
    /* filter on particular team */
    function team( $plg_ID  ) {
        $this->filter .= "&plg_ID=$plg_ID";   
    }
    
}
?>
