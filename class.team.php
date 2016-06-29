<?php
/*************************************
 * @version 1.0
 * @author Jaap Voets - Xperience Automatisering
 * teams opvragen 
 ***********************************/
include_once("class.nbb.php");
 
class Team extends NBB {
    var $dispatcher;
    var $xml;
    var $filter;
    var $clb_ID;

    function Team( $clb_ID = 0) {
        /* constructor van de parent expliciet aanroepen */
        parent::NBB( 0 );
        $this->dispatcher = 'teams.pl';
        
        $this->data   = '';
        $this->filter = '';
        $this->clb_ID = $clb_ID;
        return true;    
    }
    
    /* ophalen van xml en parsen */
    function data() {
        
        if (! $this->data ) {
            $url = parent::base_url() . $this->dispatcher . '?';
            $url .= $this->filter;
            if ($this->clb_ID > 0 ) {
                $url .= "&clb_ID=" . $this->clb_ID;
            }
            $xml_string = $this->get_xml( $url );
            $data = $this->parse( $xml_string );
            $this->data = $data;
        }
        return $this->data;     
    }
    
    function overzicht() {
        $data = $this->data(); 
        foreach( $data->team as $team ) {
            $id = "" .$team['id'];
            $lijst[ $id ]['naam']       = "" . $team->naam;
            $lijst[ $id ]['afkorting']  = "" . $team->afkorting;
            $lijst[ $id ]['team_id']    = "" . $team->team_id;
            $lijst[ $id ]['club_id']    = "" . $team->club_id;
            $comp = $team->competitie;
            $lijst[ $id ]['competitie'] = "" . $comp->naam;
            $lijst[ $id ]['comp_id'] = "" . $comp->id;
            $lijst[ $id ]['comp_nr'] = "" . $comp->nr;
            
        }
        return $lijst;  
    }
    
    /* filter for a specific ISS number for a club */
    function club_iss( $clb_ISS = '' ) {
        $this->clb_ID = 0;
        $this->filter .= "&clb_ISSnum=$clb_ISS"; 
    }

    /* filter on particular season */
    function seizoen( $seizoen = '' ) {
        $this->filter .= "&szn_Naam=$seizoen";   
    }
    
}
?>
