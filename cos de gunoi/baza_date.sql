CREATE TABLE evenimente (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nume VARCHAR(100),
  data DATE,
  locatie VARCHAR(150),
  organizator VARCHAR(100),
  descriere TEXT
);

CREATE TABLE feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nume_utilizator VARCHAR(100),
  email VARCHAR(150),
  mesaj TEXT,
  data_submit DATETIME DEFAULT CURRENT_TIMESTAMP,
  eveniment_id INT
);
