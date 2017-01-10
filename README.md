ProjectGPX rühma liikmed: Mattias Blehner, Sten-Erik Tool, Eric Skripka
##ProjectGPX

![projectgpx](https://cloud.githubusercontent.com/assets/22025406/21789759/08c42b54-d6e0-11e6-9465-54c6f7992bbe.jpg)

Eesmärgid:
	Kuvada lehel Google Mapsi,
	Lugeda GPX faili ja tekitada kaardile trajektorijoon,
	Radade kommenteerimise võimalus. 

Kirjeldus: ProjectGPX on mõeldud kõikidele spordihuvilistele, kes soovivad oma läbitud 
jooksu- või matkaradu kaardi pealt vaadata ja neid teistega jagada. Sarnased lehed on 
endomondo.com, sports-tracker.com.

Funktsionaalsus:
	teha kasutaja ja sisselogida,
	laadida üles GPX fail,
	vaadata enda ja ka teiste läbitud radu,
	kommenteerida radasid,
	lisada oma kasutaja hobid,
	muuta oma kasutaja andmeid.

Tabelite loomise SQL laused:
	
	CREATE TABLE project_user(
		id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		username VARCHAR(50),
		password VARCHAR(255),
		email VARCHAR(50),
		firstname VARCHAR(50),
		lastname VARCHAR(50),
		gender VARCHAR(7)
	);

	CREATE TABLE project_user_interests(
		id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		user_id INT(11),
		interest_id(11),
		FOREIGN KEY(user_id) REFERENCES project_user(id),
		FOREIGN KEY(interest_id) REFERENCES project_interests(id)
	);

	CREATE TABLE project_interests(
		id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		interest VARCHAR(255)
	);

	CREATE TABLE project_kommentaar(
		id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
		user_id INT(11),
		mapname VARCHAR(120),
		comment TEXT,
		FOREIGN KEY(user_id) REFERENCES project_user(id)	
	);

![projectgpxdb](https://cloud.githubusercontent.com/assets/22025406/21789111/3b1e3900-d6db-11e6-8735-aeea25260ab0.jpg)

Kokkuvõtteks:

Mattias Blehner: Kuidas muutujaid kahe lehe vahel liigutada, natuke õppisin juurde, 
kuidas veebilehte kujundada ja faile üleslaadida. Mõne kohapeal ei näita välja errorid 
korralikult ja algselt oleks tahtnud saada .gpx failist ka teist infot, mitte ainult raja 
ning oleks tahtnud kasutada Google Maps-i asemel orienteerumiskaarti.
Minu jaoks oli kõige keerulisem osa .gpx fail kaustast väljalugemine ja saada see kaardil 
korralikult avanema. Algselt üritasin teha seda kõike sama lehe peal aga see osutus ülejõu käivaks.

Eric Skripka: Selle grupitöö käigus õppisin üldiselt paremini koodi mõistma ja ka seda, kui oluline on koodi
arusaadavalt üles ehitada, eriti grupitöö puhul, kus mitu inimest töötab sama punkti kallal. Algul 
tahtsime võimaldada lehel kahe raja võrdlemist, kuid selleni me ei jõudnud, kuna kaardi kuvamine 
lehel ei tulnud nii välja, nagu tahtsime. 

Sten-Erik Tool: Juurde õppisin väga palju, peamiselt just seda kuidas kood toimib ja millises 
järjekorras asju sisse loetakse. Samuti sain paremini selgeks kuidas andmeid massiividest 
välja lugeda. Ebaõnnestus koodi puhtana hoidmine, mis oli minu jaoks kõige raskem. Ridade 
vahel on igasuguseid ebavajalikke kommentaare ja treppimine on osades kohtades kohutav. 
Keeruline oli kõik kujundamisega seonduv, kuna ma polnud sellega varem väga kokku puutunud, 
siis ei osanud väga midagi tarka seal teha. Asi jäi ikkagi väga keeruliseks ja ega väga midagi 
targemaks selle koha pealt ei saanud.
