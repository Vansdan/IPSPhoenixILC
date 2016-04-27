<?php
    // Klassendefinition
    class PhoenixILC extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
 
			$this->RegisterPropertyString("IP", "");
			$this->RegisterPropertyString("vName", "");
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
		public function SetValue()
		{
			$IP = $this->ReadPropertyString("IP");
			$sVariable = $this->ReadPropertyString("vName");
			$sValue = "1";
				
			$URL = "http://".$IP."/cgi-bin/writeVal.exe?" . $sVariable . "+" . $sValue;
			
			
			$ch = curl_init();
			
			
			// Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $URL,
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
			));
			// Send the request & save response to $resp
			curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
		}
    }
?>
