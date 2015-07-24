#!/bin/bash

output=insert_latlng.sql

for f in google_geolocate/locate_*
do
	nome_ateneo=$( basename $f | cut -d '_' -f2 )
	
	if grep -q '<lat' $f
	then
		lat=$( grep '<lat' $f | head -n1 | cut -d '>' -f2 | cut -d '<' -f1 )
		lng=$( grep '<lng' $f | head -n1 | cut -d '>' -f2 | cut -d '<' -f1 )
		echo "UPDATE atenei SET latitudine=$lat, longitudine=$lng where id=\""$nome_ateneo"\";" >> $output
	else
		echo "query su $f non riuscita" >&2
	fi
	
done