<?php

/*************************************
 * @version 1.4 
 * @author Jaap Voets - Xperience Automatisering
 * base class voor NBB interface 
 ***********************************/
class NBB {
	var $base_url;
	var $org_ID;
	
	/* constructor */
	function NBB( $org_ID = 0 ) {
		$this->base_url = 'http://db.basketball.nl/db/xml/';
		$this->org_ID   = $org_ID;
		$this->xml      = '';
		
		return true;
	}
	
	/* url waar we de data kunnen ophalen */
	function base_url() {
		return $this->base_url;
	}
	
	/* organisatie waar we naar willen kijken 
	* 0 = alles
	* 1 = NBB Landelijk
	* 2 = Rayon West
	* 3 = Rayon Oost
	* 4 = Rayon Zuid
	* 5 = Rayon Noord
	* 6 = Rayon Noord-Holland
	*/
	function org_id() {
		return $this->org_ID;	
	}
	
	/* XML ophalen vanaf de webserver */
	function get_xml( $url ) {
		$xml = '';
		$fh = fopen($url, "rb");
		$xml = stream_get_contents($fh);
		fclose($fh);
		$this->xml = $xml;
		
		return $xml;
	}
	
	/* parse de xml en geef */
	function parse( $xmlstr ) {
		$xml = new SimpleXMLElement($xmlstr);
		return $xml;
	}

	/* teruggeven van opgeslagen xml */
	function xml() {
		return $this->xml;	
	}
}

?>
