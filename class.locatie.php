<?php
/*************************************
 * @version 1.6
 * @author Jaap Voets - Xperience Automatisering
 * locaties opvragen 
 ***********************************/
include_once("class.nbb.php");
 
class Locatie extends NBB {
    var $dispatcher;
    var $xml;
    var $filter;
    var $loc_ID;

    function Locatie( $loc_ID = 0) {
        /* constructor van de parent expliciet aanroepen */
        parent::NBB( 0 );
        $this->dispatcher = 'locaties.pl';
        
        $this->data   = '';
        $this->filter = '';
        $this->loc_ID = $loc_ID;
        return true;    
    }
    
    /* ophalen van xml en parsen */
    function data() {
        
        if (! $this->data ) {
            $url = parent::base_url() . $this->dispatcher . '?';
            $url .= $this->filter;
            if ($this->loc_ID > 0 ) {
                $url .= "&loc_ID=" . $this->loc_ID;
            }
            $xml_string = $this->get_xml( $url );
            $data = $this->parse( $xml_string );
            $this->data = $data;
        }
        return $this->data;     
    }
    
    function overzicht() {
        $data = $this->data(); 
        foreach( $data->locatie as $loc ) {
            $id = "" .$loc['id'];
            $lijst[ $id ]['naam']      = "" . $loc->naam;
            $lijst[ $id ]['adres']     = "" . $loc->adres;
            $lijst[ $id ]['postcode']  = "" . $loc->postcode;
            $lijst[ $id ]['plaats']    = "" . $loc->plaats;
            $lijst[ $id ]['longitude'] = "" . $loc->longitude;
            $lijst[ $id ]['latitude']  = "" . $loc->latitude;
        }
        return $lijst;  
    }
    
    // get details of single location
    function gegevens( $loc_ID = 0) {
       if ($loc_ID == 0 ) {
            $loc_ID = $this->loc_ID;
       }
       $lijst = $this->overzicht();
       if (count($lijst) > 0) {
          return $lijst[ $loc_ID ];
       } else {
          return array();
       }
    }

    /* filter for a specific clb_ID as specified in the NBB database */
    function clubid( $clb_ID = 0 ) {
        $this->filter .= "&clb_ID=$clb_ID"; 
    }

    /* filter on particular season */
    function seizoen( $seizoen = '' ) {
        $this->filter .= "&szn_Naam=$seizoen";   
    }
    
    /* filter on particular team */
    function team( $plg_ID  ) {
        $this->filter .= "&plg_ID=$plg_ID";   
    }
    /* filter for an organisation  as specified in the NBB database */
    function orgid( $org_ID = 0 ) {
        $this->filter .= "&org_ID=$org_ID"; 
    }
    
}
?>
