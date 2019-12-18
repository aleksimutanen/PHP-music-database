SELECT name, website, info, country
FROM artist
ORDER BY country;

SELECT *
FROM album
WHERE album.length > '00:45:00' AND publishdate > '2010-01-01';

SELECT name, length
FROM kappale
WHERE length > '00:06:00' OR name LIKE '%$%';

SELECT COUNT(*)
FROM genre;

SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(length))) AS totallength
FROM album;

SELECT firstname, lastname
FROM member
GROUP BY firstname;

SELECT name
FROM track
HAVING MIN(length) < '00:06:00';

SELECT firstname, lastname, artist.name
FROM member
INNER JOIN artist ON member.teamid = artist.teamid
WHERE member.teamid = 3;

SELECT track.name, album.publishdate as date
FROM track
LEFT OUTER JOIN album ON track.albumid = album.albumid
ORDER BY date;

SELECT genre.name, artist.name
FROM genre
INNER JOIN artist ON genre.genreid = artist.genreid;

SELECT album.name, artist.name, recordlabel.name
FROM (album INNER JOIN artist ON album.artistid = artist.artistid)
INNER JOIN recordlabel ON album.recordlabelid = recordlabel.recordlabelid;

SELECT * 
FROM member
INNER JOIN artist ON member.ArtistID = artist.ArtistID
WHERE artist.name = "Muse";