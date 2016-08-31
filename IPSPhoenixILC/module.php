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
 
			$this->RegisterPropertyString("IP", "192.168.178.152");
			$this->RegisterPropertyString("vName", "KIND1.KI1_LICHTV");
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
        * ILC_SetValue($id);
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
		
		public function Request($path) {
			$host = $this->ReadPropertyString('Host');
			if ($host == '') {
			$this->SetStatus(104);
			return false;
			}
			
			// Get cURL resource
			$client = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt($client, CURLOPT_URL, "http://{$host}$path");
			curl_setopt($client, CURLOPT_POST, false);
			curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($client, CURLOPT_USERAGENT, "IPS2ILC");
			curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($client, CURLOPT_TIMEOUT, 5);
			// Send the request & save response to $result
			$result = curl_exec($client);
			// Fehler-/Statusmeldungen
			$status = curl_getinfo($client, CURLINFO_HTTP_CODE);
			// Close request to clear up some resources
			curl_close($client);
				// Auswertung Fehler-/Statusbehandlung
				if ($status == '0') {
				$this->SetStatus(201);
				return false;
				} elseif ($status != '200') {
				$this->SetStatus(201);
				return false;
			} 	else {
				$this->SetStatus(102);
				return simplexml_load_string($result);
			}
		}
		
		
    }
?>
