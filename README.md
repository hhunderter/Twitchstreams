# Twitchstreams
Ilch 2.0 Modul zur Verwaltung von Twitch-Streamern

# Twitch API
Dieses Modul basiert auf die offiziele API von Twitch: https://github.com/justintv/Twitch-API
Die aktuelle Version der Twitch API erfordert, dass bei einem Request eine Client-ID mitgelefiert wird. Diese ID
(bzw. der API-Key) bekommt man von Twitch selber. Dafür ist ein Account nötig. Um einen API-Key zu erhalten
muss direkt auf Twitch in den Settings -> Connections -> Developer Applications eine Application registriert werden.
Jede Application hat dabei eine eindeutige ID. Diese ID muss dann im Twitchstreams-Modul in der Adminstration unter
Settings eingetragen werden.

# Installation

alle Dateien, in ihrer Ordnerstrucktur hochladen (*Ilch2Root*/application/modules/twitchstreams/)

Nach Uploaden aller Datein muss das Modul im Backend bei der Module Übersicht unter Nicht installierte Module installiert werden.

Anschließend muss das Modul entsprechend im Menü verlinkt werden.

# Streamer-Daten updaten
Die Streamer lassen sich per Cronjob aktualisieren oder per Aufruf der Frontend-Seite. Dies ist in den Settings einstellbar.
Um die Streamer per Cronjob zu aktualisieren, muss der Job folgenden Link aufrufen: http://DOMAIN/index.php/twitchstreams/index/update

# Haftungsausschluss
Ich übernehme keine Haftung für Schäden, welche durch dieses Modul entstehen. 


