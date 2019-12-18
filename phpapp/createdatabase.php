<?php

    require_once "config.php";

    $sql = "

            CREATE TABLE Genre (
	                GenreID int UNIQUE AUTO_INCREMENT,
	                name varchar(64),
	                image varchar(2000),
    
    	            PRIMARY KEY (GenreID)
            );

            CREATE TABLE Role (
	                RoleID int UNIQUE AUTO_INCREMENT,
	                name varchar(32),
    
   	                PRIMARY KEY (RoleID)
            );

            CREATE TABLE Artist (
	                ArtistID int UNIQUE AUTO_INCREMENT, 
	                GenreID int,
	                name varchar(100),
    	            website varchar(200),
	                info varchar(2000),
    	            country varchar(3),
	                logo varchar(2000),
	                image varchar(2000),
    
    	            PRIMARY KEY (ArtistID, GenreID)
            );

            CREATE TABLE Member (
	                MemberID int UNIQUE AUTO_INCREMENT,
	                RoleID int,
    	            ArtistID int,
    	            name varchar(100),
	                image varchar(2000),
	
    	            PRIMARY KEY(MemberID, RoleID, ArtistID)
            );


            CREATE TABLE Album (
	                AlbumID int UNIQUE AUTO_INCREMENT,
    	            ArtistID int,
    	            GenreID int,
	                name varchar(64),
	                publishdate date,
	                length time,
	                image varchar(2000),
    
    	            PRIMARY KEY (AlbumID, ArtistID, GenreID)
            );

            CREATE TABLE Track (
	                TrackID int UNIQUE AUTO_INCREMENT,
    	            ArtistID int,
    	            AlbumID int,
	                name varchar(64),
	                length time,
	
    	            PRIMARY KEY (TrackID, ArtistID, AlbumID)
            );

            CREATE TABLE users (
    	            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    	            username VARCHAR(50) NOT NULL UNIQUE,
    	            password VARCHAR(255) NOT NULL,
    	            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );





            INSERT INTO Genre
            VALUES
            (1, 'Progressive Metal', 'https://www.guitarplayer.com/.image/t_share/MTUxNDE4MzAzNzYzMzI2MjA3/image-placeholder-title.jpg'),
            (2, 'Djent', 'https://58eca9fdf76150b92bfa-3586c28d09a33a8c605ed79290ca82aa.ssl.cf3.rackcdn.com/ibanez-rg9-bk-black-343626.jpg'),
            (3, 'House', 'http://laserpoint.fi/wp-content/uploads/sites/214/2017/06/8.jpg'),
            (4, 'Jazz', 'https://cdn11.bigcommerce.com/s-6412e/images/stencil/2048x2048/products/2505/23045/Piccolo-Berlin__23159.1558024278.jpg?c=2&imbypass=on'),
            (5, 'Alternative Rock', 'https://www.bassbuddha.com/app/uploads/2019/05/Dingwall-NG3-Darkglass-10th-Anniversary-Limited-Edition-1.jpg'),
            (6, 'Drum & Bass', 'https://fi.yamaha.com/fi/files/Image-main_Drums_1200x480_6449543b3b628c6a7c12c2c37fe49e89.jpg'),
            (7, 'Electronica', 'https://cdn.roland.com/products/system-1/features/images/system_1_detail_hero01.jpg')
            ;

            INSERT INTO Role
            VALUES
            (1, 'Singer'),
            (2, 'DJ'),
            (3, 'Trumpeter'),
            (4, 'Percussions'),
            (5, 'Guitarist'),
            (6, 'Bassist'),
            (7, 'Saxophonist'),
            (8, 'Keyboards'),
            (9, 'Drummer'),
            (10, 'Clarinetist'),
            (11, 'Violinist'),
            (12, 'Cellist'),
            (13, 'Mellotron'),
            (14, 'Synthesizer'),
            (15, 'Sampler'),
            (16, 'Turntables'),
            (17, 'Pianist')
            ;

            INSERT INTO Artist
            VALUES
            (1, 1, 'Animals As Leaders', 'https://www.animalsasleaders.org/', 'Instrumental jazz and fusion influenced progressive metal band', 'USA', 'https://www.emp.fi/dw/image/v2/BBQV_PRD/on/demandware.static/-/Sites-master-emp/default/dwa20f4a52/images/4/6/1/8/461844a.jpg?sfrm=png', 'https://dynamicmedia.livenationinternational.com/Media/n/u/b/17d1e4f7-7cde-49e5-b3af-fb38d9a144f0.jpg'),
            (2, 2, 'TesseracT', 'https://www.tesseractband.co.uk/', 'Djent style progressive metal band with futuristic sounds and lyrics', 'GBR', 'https://i1.sndcdn.com/avatars-000039136940-2got09-t500x500.jpg', 'https://www.nme.com/wp-content/uploads/2018/04/TesseracT-photos-by-Steve-Brown-0B4A7352-696x442.jpg'),
            (3, 3, 'Zhu', 'https://zhumusic.com/', 'Zhu is a house music producer and singer', 'CN', 'https://direct.rhapsody.com/imageserver/images/alb.143029459/500x500.jpg', 'https://upload.wikimedia.org/wikipedia/commons/7/70/ZHU_%2829357096668%29_%28cropped%29.jpg'),
            (4, 4, 'Art Ensemble of Chicago', 'http://www.akamu.net/aeoc.htm', 'Art Ensemble of Chicago is a jazz group from the late 1960s', 'USA', 'https://www.levykauppax.fi/cover/normal/2/28/284560.jpg?lp', 'http://www.vilniusjazz.lt/Files/performers_img/b_29e4399f04bd5fabfd530044ac4383fd.jpg'),
            (5, 5, 'Muse', 'https://www.muse.mu/', 'Muse is an alternative rock band with very varying styles from album to album', 'GBR', 'https://i.pinimg.com/originals/dc/c5/5d/dcc55d5aa4fc25cd54bd9f7a2f325976.jpg', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Muse_Promo_2017.tif/lossy-page1-1200px-Muse_Promo_2017.tif.jpg'),
            (6, 6, 'Pendulum', 'https://pendulum.com/', 'Pendulum is a drum and bass band with an electronic rock twist', 'AU', 'https://blenderartists.org/uploads/default/original/3X/a/6/a680cef66993cfb238d09f6b81af748113bc4915.jpg', 'https://djmag.com/sites/default/files/styles/djmag_landscape__691x372_/public/article/image/PENDULUM-2018-billboard-1548.jpeg?itok=3Rm42NsX'),
            (7, 7, 'Moderat', 'https://moderat.fm/', 'Moderat is an electronic music group formed out of 2 artists', 'GER', 'https://i.pinimg.com/originals/cd/c6/00/cdc60073defc3fca529d7ce87fc1ab65.jpg', 'http://stoneyroads.com/wp-content/uploads/2017/08/moderat-480x320.jpg')
            ;

            INSERT INTO Member
            VALUES
            (1, 5, 1, 'Tosin Abasi', 'https://i.pinimg.com/originals/d6/9c/1d/d69c1d82cf90eab8f96d19f77d0aae28.jpg'),
            (2, 5, 1, 'Javier Reyes', 'https://l6c-acdn2.line6.net/data/6/0a06438950e056a7c9c732d55/image/png/file.png'),
            (3, 9, 1, 'Matt Garstka', 'https://i0.wp.com/www.moderndrummer.com/wp-content/uploads/2016/06/Matt-Garstka-060-Playing-right.png?resize=720%2C481&ssl=1'),
            (4, 1, 5, 'Matthew Bellamy', 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Flickr_-_moses_namkung_-_Muse-2.jpg'),
            (5, 6, 5, 'Chris Wolstenholme', 'https://img.discogs.com/0CWtY2yigkVWw9875dZG5QpujY4=/600x398/smart/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/A-382230-1435370367-7013.jpeg.jpg'),
            (6, 9, 5, 'Dominic Howard', 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Dominic_Howard_of_Muse_at_Air_Canada_Centre%2C_Toronto_on_April_10%2C_2013_as_part_of_The_2nd_Law_tour.jpg'),
            (7, 2, 3, 'Steven Zhu', 'http://s3.amazonaws.com/sfc-datebook-wordpress/wp-content/uploads/sites/2/2018/09/59723412_DATEBOOK_kost0907_zhu.jpg'),
            (8, 1, 2, 'Daniel Tompkins', 'https://i.pinimg.com/474x/a1/7d/93/a17d937829a434b7de68dfc3f7b91ad5--daniel-oconnell.jpg'),
            (9, 5, 2, 'Alec Kahney', 'https://pm1.narvii.com/6093/d1a312aa719da5181e4c41293350139dd18f5f14_hq.jpg'),
            (10, 5, 2, 'James Monteith', 'https://i.ytimg.com/vi/gGOlnCg1bzo/maxresdefault.jpg'),
            (11, 6, 2, 'Amos Williams', 'https://i.ytimg.com/vi/5B_uyBsZ87Y/maxresdefault.jpg'),
            (12, 9, 2, 'Jay Postones', 'https://pbs.twimg.com/profile_images/1163800400178425857/OCb76vj4_400x400.jpg'),
            (13, 1, 6, 'Rob Swire', 'https://famousbirthday.today/webp/38127-Rob-Swire.webp'),
            (14, 1, 6, 'Ben Mount', 'https://live.staticflickr.com/4074/4865195121_e4d068973e_z.jpg'),
            (15, 5, 6, 'Peredur ap Gwynedd', 'https://upload.wikimedia.org/wikipedia/commons/e/e1/Peredur_ap_Gwynedd.jpeg'),
            (16, 6, 6, 'Gareth McGrillen', 'https://media.gettyimages.com/photos/gareth-mcgrillen-of-dance-rock-group-pendulum-performing-live-on-at-picture-id136410166'),
            (17, 9, 6, 'KJ Sawka', 'https://i.ytimg.com/vi/H2mJy_DR7GY/maxresdefault.jpg'),
            (18, 2, 7, 'Gernot Bronsert', 'https://c8.alamy.com/comp/KWD6AA/the-electronic-music-project-moderat-originates-from-berlin-in-germany-KWD6AA.jpg'),
            (19, 8, 7, 'Sascha Ring', 'https://thumbnailer.mixcloud.com/unsafe/300x300/extaudio/d/3/2/5/b127-3dff-47aa-8c24-211a02f63a80'),
            (20, 2, 7, 'Sebastian Szary', 'https://muno.pl/wp-content/uploads/2015/10/szaryklang658-1-850x570.jpg'),
            (21, 3, 4, 'Lester Bowie', 'https://alchetron.com/cdn/lester-bowie-5963bb66-e2b7-414f-a497-7d53dc21024-resize-750.jpeg'),
            (22, 6, 4, 'Malachi Favors', 'https://pbs.twimg.com/media/D-JmiuXWwAASdT7.jpg'),
            (23, 7, 4, 'Joseph Jarman', 'https://static01.nyt.com/images/2019/01/12/obituaries/12JARMAN-OBIT1/12JARMAN-OBIT1-articleLarge-v2.jpg?quality=75&auto=webp&disable=upscale'),
            (24, 10, 4, 'Roscoe Mitchell', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Roscoe_Mitchell_Kongsberg_Jazzfestival_2017_%28000731%29.jpg/220px-Roscoe_Mitchell_Kongsberg_Jazzfestival_2017_%28000731%29.jpg'),
            (25, 9, 4, 'Don Moye', 'https://www.drummerworld.com/drummerworld1/donmoye840.jpg'),
            (26, 8, 4, 'Bahnamous Lee Bowie', 'http://www.brookenstein.com/KellieSae4/bahna3.jpg')
            ;

            INSERT INTO Album
            VALUES
            (1, 7, 7, 'III', '2016-04-01', '00:42:47', 'http://spillmagazine.com/wp-content/uploads/2016/01/Moderat.jpg'),
            (2, 3, 3, 'Generationwhy', '2016-07-29', '00:59:00', 'https://cdn-s3.allmusic.com/release-covers/500/0004/585/0004585430.jpg'),
            (3, 5, 5, 'The 2nd Law', '2012-09-28', '00:53:49', 'https://upload.wikimedia.org/wikipedia/fi/thumb/3/35/Muse_2nd_law.jpg/250px-Muse_2nd_law.jpg'),
            (4, 1, 1, 'The Joy of Motion', '2014-03-24', '00:54:23', 'http://feckingbahamas.com/wp-content/uploads/2014/04/Animals-As-Leaders-The-Joy-of-Motion-600x600.jpg'),
            (5, 6, 6, 'Immersion', '2010-05-21', '01:07:14', 'https://img.discogs.com/aAu0LdOApgTaxCd1aq28KXUcGUE=/fit-in/600x590/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/R-2279175-1558846700-3586.jpeg.jpg'),
            (6, 4, 4, 'Ancient to the Future', '1987-01-01', '00:47:34', 'https://images-na.ssl-images-amazon.com/images/I/41W7Q25X86L.jpg'),
            (7, 2, 2, 'One', '2011-03-22', '00:54:31', 'https://www.swampmusic.com/graphics/products/tesseract_one_b4178a04.jpg'),
            (8, 2, 2, 'Polaris', '2015-09-18', '00:46:45', 'https://upload.wikimedia.org/wikipedia/en/2/26/Album_cover_for_Polaris_%28Tesseract_album%29.jpg')
            ;

            INSERT INTO Track
            VALUES
            (1, 7, 1, 'Intruder', '00:04:38'),
            (2, 7, 1, 'Ghostmother', '00:05:57'),
            (3, 3, 2, 'One Minute to Midnight', '00:04:15'),
            (4, 3, 2, 'Secret Weapon', '00:04:03'),
            (5, 5, 3, 'Survival', '00:04:17'),
            (6, 5, 3, 'The 2nd Law: Isolated System', '00:04:59'),
            (7, 1, 4, 'KaScade', '00:05:23'),
            (8, 1, 4, 'The Woven Web', '00:04:07'),
            (9, 6, 5, 'Encoder', '00:05:21'),
            (10, 6, 5, 'Witchcraft', '00:04:12'),
            (11, 4, 6, 'These Arms of Mine', '00:05:12'),
            (12, 4, 6, 'Creole Love Call', '00:05:55'),
            (13, 2, 7, 'Eden', '00:09:08'),
            (14, 2, 7, 'Lament', '00:04:53'),
            (15, 2, 8, 'Dystopia', '00:06:51'),
            (16, 2, 8, 'Utopia', '00:05:34')
            ;
           ";

    if ($result = $link->query($sql)) {
        echo "SUCCESFULL";
    } else {
        echo "FAILED TO CREATE DATABASE";
    }

?>