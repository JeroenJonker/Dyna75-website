<?php
/*************************************
 * @version 1.8
 * @author Jaap Voets - Xperience Automatisering
 * uitslagen en schema via NBB interface 
 *
 * De data wordt opgevraagd aan 
 * http://db.basketball.nl/db/xml/wedstrijd.pl
 *   zorg wel dat er een cmp_ID is ingevuld anders 
 *   wordt de lijst gigantisch
 ***********************************/
include_once("class.nbb.php");
 
class Wedstrijd extends NBB {
    var $dispatcher;
    var $cmp_ID;
    var $sortering;
    var $filter;

    function Wedstrijd( $org_ID = 0, $cmp_ID = 0) {
        /* constructor van de parent expliciet aanroepen */
        parent::NBB( $org_ID );
        $this->dispatcher = 'wedstrijd.pl';
        $this->cmp_ID = $cmp_ID;
            
        $this->data = '';
        /* standaard op datum sorteren */
        $this->sortering = 'wed_Datum';
        $this->filter    = '';  
        $this->groepering = 1;  /* standaard wel op competitie nummer groeperen */
        return true;    
    }

    /* alleen schema tonen
     * als dagen gezet is, dan tot maximaal zoveel dagen vooruit
     */
    function filter_schema( $dagen = 0 ) {
        $this->filter .= '&schema=1';
        if ($dagen > 0) {
           $this->filter .= "&dagen=$dagen";
        }
    }   
    /* alleen uitslagen tonen
     * als dagen gezet is, dan tot maximaal zoveel dagen vooruit
     */
    function filter_uitslagen( $dagen = 0 ) {
        $this->filter .= '&uitslagen=1';
        if ($dagen > 0) {
             $this->filter .= "&dagen=$dagen";
        }
    }

    /* random een competitie kiezen (voor gegeven org_ID) 
     en daar alleen de uitslagen van tonen, dus geen 0-0
     */
    function random_uitslagen( $dagen = 7 ) {
        $this->filter .= '&randomcompetitie=1';
        if ($dagen > 0) {
             $this->filter .= "&dagen=$dagen";
        }

    }

    /* ophalen van xml en parsen */
    function data() {
        
        if (! $this->data ) {
            $url = parent::base_url() . $this->dispatcher . '?';
            if ($this->cmp_ID > 0 ) {
                $url .= '&cmp_ID=' . $this->cmp_ID;
            }
            if (parent::org_id() > 0 ) {
                $url .= '&org_ID=' . parent::org_id();
            }
            /* sortering */
            $url .= '&Sorteer=' . $this->sortering;
            $url .= $this->filter;

            $xml_string = $this->get_xml( $url );
            $data = $this->parse( $xml_string );
            $this->data = $data;
        }
        return $this->data;     
    }
    
    /* willen we sorteren op een veld */
    function sorteer( $veld ) {
        switch (strtolower($veld)) {
            case "datum" :
                $this->sortering = 'wed_Datum';
                break;
            case "nummer" :
                $this->sortering = 'wed_Nummer';
                break;
            default :
                $this->sortering = 'wed_Datum';
        }           
    }

    function competitie() {
        $data = $this->data();
        $competitie = $data->competitie[0];
        $nr   = "" . $competitie->nummer;
        $naam = "" . $competitie->naam;

        return array($nr, $naam);
    }
    
    function overzicht() {
        $data = $this->data(); 
        $competities = array();

        if ($this->groepering ) {
            foreach( $data->competitie as $competitie ) {
                $compID = "" . $competitie['id'];
                $competities[ $compID ]['naam']        = "" .$competitie->naam;
                $competities[ $compID ]['nummer']      = "" .$competitie->nummer;
                /* lijst van wedstrijden binnen deze competitie */
                $competities[ $compID ]['wedstrijden'] = $this->get_wedstrijden( $competitie );

            }
        } else {
            /* is alleen lijst met wedstrijden */
            $competities[0]['naam'] = "alle competities";
            $competities[0]['nummer'] = "0";
            $competities[0]['wedstrijden'] = $this->get_wedstrijden( $data );
        }
        $this->parsed_overzicht = $competities;
        return $competities;    
    }

    function get_wedstrijden( $top_element ) {       
        $lijst = array();
            
        foreach( $top_element->wedstrijd as $wedstrijd ) {
            $id = "" . $wedstrijd['id'];

            $lijst[ $id ]['nummer']      = "" . $wedstrijd->nummer;
            $lijst[ $id ]['datum']       = "" . $wedstrijd->datum;
            $lijst[ $id ]['tijd']        = "" . $wedstrijd->tijd;
            $lijst[ $id ]['thuisclub' ]  = "" . $wedstrijd->thuisploeg->club;
            $lijst[ $id ]['uitclub']     = "" . $wedstrijd->uitploeg->club;
            $lijst[ $id ]['thuisteam' ]  = "" . $wedstrijd->thuisploeg->naam;
            $lijst[ $id ]['uitteam']     = "" . $wedstrijd->uitploeg->naam;
            $lijst[ $id ]['thuisteamshirt' ]  = "" . $wedstrijd->thuisploeg->shirt;
            $lijst[ $id ]['uitteamshirt' ]    = "" . $wedstrijd->uitploeg->shirt;
            $lijst[ $id ]['thuisteamnr' ]  = "" . $wedstrijd->thuisploeg->teamnr;
            $lijst[ $id ]['uitteamnr']     = "" . $wedstrijd->uitploeg->teamnr;
            $lijst[ $id ]['thuisteamafko' ]  = "" . $wedstrijd->thuisploeg->teamafkorting;
            $lijst[ $id ]['uitteamafko']     = "" . $wedstrijd->uitploeg->teamafkorting;
            $lijst[ $id ]['thuisstats' ]   = "" . $wedstrijd->thuisstats;
            $lijst[ $id ]['uitstats']      = "" . $wedstrijd->uitstats;
            $uitslag = $wedstrijd->uitslag;
            $lijst[ $id ]['scorethuis']    = "" . $uitslag->scorethuis;
            $lijst[ $id ]['scoreuit']      = "" . $uitslag->scoreuit;
            $lijst[ $id ]['status']        = "" . $uitslag->status;
            $locatie = $wedstrijd->locatie;
            $lijst[ $id ]['loc_id']        = "" . $locatie['id'];
            $lijst[ $id ]['locatie']       = "" . $locatie->naam;
            $lijst[ $id ]['adres']         = "" . $locatie->adres;
            $lijst[ $id ]['postcode']      = "" . $locatie->postcode;
            $lijst[ $id ]['plaats']        = "" . $locatie->plaats;
            // toevoeging van Roy Kroeze om makkelijk te kunnen doorlinken
            $lijst[ $id ]['thuisid']       = "" . $wedstrijd->thuisploeg['id'];
            $lijst[ $id ]['uitid']         = "" . $wedstrijd->uitploeg['id'];
        }
        return $lijst;
    }
    
    /* hiermee haal je meteen de lijst met wedstrijden uit een competitie op, scheelt weer een foreach */
    function wedstrijden( $cmp_ID ) {
        if (! $this->parsed_overzicht) {
            $this->overzicht();
        }

        return $this->parsed_overzicht[ $cmp_ID ]['wedstrijden'];
    }

    /* extra filters */
    /* filter op eigen club door het opgeven van het ISS nummer van de club
      bijv. 3109 voor BAS Basketball */
    function club( $clb_ISSnum = 0 ) {
        $this->filter .= "&clb_ISSnum=$clb_ISSnum";
    }
   
    /* om eventueel een oud seizoen te kiezen. standaard is het het huidige seizoen, je kunt dit filter dus meestal weglaten */
    function seizoen( $seizoen = '' ) {
        $this->filter .= "&szn_Naam=$seizoen";
    }

    /* filter voor een specifiek clb_ID uit de NBB database, bijv clb_ID=132 voor BAS Basketball  */
    function clubid( $clb_ID = 0 ) {
        $this->filter .= "&clb_ID=$clb_ID";
    }
    
    /* filter voor een specifiek plg_ID uit de NBB database, bijv plg_ID=8591 voor Wildcats Meisjes U16 */
    function teamid( $plg_ID = 0 ) {
        $this->filter .= "&plg_ID=$plg_ID";
    }

    /* hiermee worden alleen de wedstrijden van de eigen club getoond, werkt alleen in combinatie met club() of clubid() filters */ 
    function alleen_club_gegevens() {
        $this->filter .= "&alleen_club=1";
    }

    /* om op datum te sorteren, ipv cmp_Nummer, wed_Datum, wed_Nummer */
    function sorteer_datum() {
        $this->filter .= "&sortering=datum";
    }
    
    /* om het groeperen per competitie nummer over slaan, je houdt dan alleen een lange lijst met wedstrijden over */
    function geen_groepering_competitie() {
        $this->groepering = 0;
        $this->filter .= "&geen_competitie_groepering=1";
    }

}
?>

