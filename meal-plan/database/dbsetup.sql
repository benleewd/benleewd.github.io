drop database if exists weightwatcher;
create database  if not exists weightwatcher;
use weightwatcher;

CREATE TABLE  if not exists user(
  name  varchar(32)    NOT NULL,
  email varchar(32)  NOT NULL,
  password varchar(64)      NOT NULL,
  height int    NOT NULL,
  weight  int  NOT NULL,
  age int NOT NULL,
  gender varchar(32) NOT NULL,
  caloriesintake int  NOT NULL,
  dailycount int NOT NULL,
  primary key (email)
);


-- name   email                   password    height    weight    age   gender    caloriesintake    dailycount
-- Jack   jack@smu.edu.sg         apple123    180       60        25    male      2500              1500
-- Mary   mary@smu.edu.sg         orange123   160       40        20    female    2000              1000

INSERT INTO user (name, email, password, height, weight, age, gender, caloriesintake, dailycount) VALUES ('Jack', 'jack@smu.edu.sg', '$2y$10$8sUJ8Rx1touqj4544cF3peXdb4vETojPBD8CVP1XGNgNiUZlcCF/W', 180, 60, 25, 'male', 2500, 1500);
INSERT INTO user (name, email, password, height, weight, age, gender, caloriesintake, dailycount) VALUES ('Mary', 'mary@smu.edu.sg', '$2y$10$StCKah9A31H/tjHaAc3RdeYbcF9HkNP3nCupOSc4nalaRdAV1YSki', 160, 40, 20, 'female', 2000, 1000);

-- UPDATE user
-- SET dailycount = caloriesintake
-- WHERE ((TIMEDIFF(CONVERT(time, CURRENT_TIMESTAMP), '00:00:00') = TRUE)

CREATE EVENT reset_caloriesintake
ON SCHEDULE EVERY 1 DAY
DO
UPDATE user
SET dailycount = caloriesintake