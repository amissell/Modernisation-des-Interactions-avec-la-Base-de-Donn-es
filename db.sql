create DATABASE persones;
use persones;
create Table player_profile(
  id int AUTO_INCREMENT PRIMARY key,
  name VARCHAR(20),
  position VARCHAR(3),
  nationality VARCHAR(30),
  rating int(10)
)

-- INSERT INTO player_profile(name, position, nationality, rating
-- )
-- VALUES('med', 'gk', 'morroco', 25),
-- ('ahmed', 'st', 'morroco', 58),
-- ('sami', 'rb', 'morroco', 25);

show tables;


SELECT * from player_profile;