<?PHP

	/**
	 * 
	 * parametri_miur.php
	 * 
	 * Genera gli elementi HTML necessari per eseguire una ricerca sul database del miur:
	 * 
	 * A seconda dei parametri passati con il metodo POST, restituisce:
	 *  - una checkbox per ogni fascia di abilitazione presente nel db, oppure
	 *  - una checkbox per ogni superarea presente nel db, oppure
	 *  - un range i cui estremi inferiore e superiore sono rispettivamente gli anni minimo e massimo per i quali sono presenti dati nel database  
	 *  - un range i cui estremi inferiore e superiore sono rispettivamente la dimensione minima e massima degli atenei presenti nel database  
	 *  - un array con le latitudini e longitudini di ogni ateneo, codificato in formato JSON  
	 * 
	 * */
	 
	header('Content-Type: application/json');
	require('../php/config_miur.php');
		
	if ( isset($_REQUEST["id"]) )
	{
		switch($_REQUEST["id"]){
			
			case "superaree":
			{
				$r=select($mysqli, "SELECT distinct superarea FROM ssd ORDER BY superarea");
				$s='<label id="label_settore">Seleziona il settore scientifico disciplinare:</label><br/>';
				
				for($i = 0; $i < count($r); $i++) 
				{
					$s=$s.'<input type="checkbox" name="superaree" id="'.$r[$i]['superarea'].'">'.$r[$i]['superarea'].'</input>';
				};
				echo $s;
				break;
			}
			case "popolazione":
			{
				$r=select($mysqli, "SELECT min(dimensione) as min, max(dimensione) as max FROM atenei");
				$s='<label id="label_popolazione">Quanti studenti?</label><form oninput="popolazioneMinout.value=popolazioneMin.value"><input type="range" name="popolazioneMin" min="'.$r[0]['min'].'" max="'.$r[0]['max'].'" step="1" value="'.$r[0]['max'].'"><output name="popolazioneMinout" for="popolazioneMin"></output>
    </form><form oninput="popolazioneMaxout.value=popolazioneMax.value"><input type="range" name="popolazioneMax" min="'.$r[0]['min'].'" max="'.$r[0]['max'].'" step="1" value="'.$r[0]['min'].'"><output name="popolazioneMaxout" for="popolazioneMax"></output>
    </form>';
				
				
				
				echo $s;
				break;
			}
			case "fascia":
			{
				$r=select($mysqli, "SELECT distinct fascia FROM fascia");
				$s='<label id="label_fascia">Seleziona la fascia di appartenenza:</label><br/>';
				
				for($i = 0; $i < count($r); $i++) 
				{
					$s=$s.'<input type="checkbox" name="fasce" id="'.$r[$i]['fascia'].'">'.$r[$i]['fascia'].'</input>';
				}
				echo $s;
				break;
			}
			case "latlng":
			{
				$r=select($mysqli, "SELECT id, nome, latitudine, longitudine FROM atenei");
				
				for($i = 0; $i < count($r); $i++) 
				{
					$r[$i]['latitudine']=floatval($r[$i]['latitudine']);
					$r[$i]['longitudine']=floatval($r[$i]['longitudine']);
				}
				echo json_encode($r);
				break;
			}
			
			case "anno":
			{
				$r=select($mysqli, "SELECT min(anno_minimo) as min, max(anno_massimo) as max FROM fascia");
				$s='<label id="label_anni">Seleziona il periodo di riferimento:</label><form oninput="AnnoMinout.value=AnnoMin.value"><input type="range" name="AnnoMin" min="'.$r[0]['min'].'" max="'.$r[0]['max'].'" step="1" value="'.$r[0]['max'].'"><output name="AnnoMinout" for="AnnoMin"></output>
    </form><form oninput="AnnoMaxout.value=AnnoMax.value"><input type="range" name="AnnoMax" min="'.$r[0]['min'].'" max="'.$r[0]['max'].'" step="1" value="'.$r[0]['min'].'"><output name="AnnoMaxout" for="AnnoMax"></output>
    </form>';
				
				echo $s;
				break;
			}
			
			default:
			{
				echo "undefined";
			}
		}
	}
	else
	{
		echo "undefined";
	}
	
?>
