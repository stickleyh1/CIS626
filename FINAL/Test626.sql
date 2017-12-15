/*Create Global User*/
DROP USER IF EXISTS 'Admin626'@'localhost';
CREATE USER 'Admin626'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO 'Admin626'@'localhost' IDENTIFIED BY '';

DROP DATABASE IF EXISTS Test626;
/*Create DB*/
CREATE DATABASE Test626;

/*Add User to DB with all Privileges*/
GRANT ALL PRIVILEGES ON `Test626`.* TO 'Admin626'@'localhost' IDENTIFIED BY '';

/*Create Tables in DB*/
CREATE TABLE Customers
(
  CustomerID INT
  UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR
  (255) NOT NULL UNIQUE KEY,
  Email VARCHAR
  (255) NOT NULL UNIQUE KEY,
  Password VARCHAR
  (64) NOT NULL,
  Admin TINYINT UNSIGNED NOT NULL
);

  CREATE TABLE Books
  (
    ISBN VARCHAR(13) NOT NULL PRIMARY KEY,
    AuthorFirstName VARCHAR(50) NOT NULL,
    AuthorLastName VARCHAR(50) NOT NULL,
    Title VARCHAR(100) NOT NULL,
    Pages INT
    UNSIGNED NOT NULL,
  Publisher VARCHAR
    (100) NOT NULL,
  PublicationYear YEAR
    (4) NOT NULL,
  Topic VARCHAR
    (50) NOT NULL,
  Available TINYINT UNSIGNED NOT NULL
);

    CREATE TABLE CustomerBookListing
    (
      CustomerID INT
      UNSIGNED NOT NULL,
  ISBN VARCHAR
      (13) NOT NULL,
  CheckedOut TINYINT UNSIGNED NOT NULL,
  Favorite TINYINT UNSIGNED NOT NULL,

  PRIMARY KEY
      (CustomerID, ISBN),
  FOREIGN KEY
      (CustomerID) REFERENCES Customers
      (CustomerID),
  FOREIGN KEY
      (ISBN) REFERENCES Books
      (ISBN)
);

      DROP PROCEDURE IF EXISTS getAllBooks;
      CREATE PROCEDURE getAllBooks()
      SELECT
        ISBN, CONCAT(AuthorFirstName,' ',AuthorLastName) AS AuthorName, Title, Pages, Publisher, PublicationYear, Topic, Available
      FROM
        books b;

      DROP PROCEDURE IF EXISTS searchBooks;
      CREATE PROCEDURE searchBooks(IN filter varchar
      (50))
      SELECT
        ISBN, CONCAT(AuthorFirstName,' ',AuthorLastName) AS AuthorName, Title, Pages, Publisher, PublicationYear, Topic, Available
      FROM
        books b
      WHERE
        b.ISBN LIKE filter OR b.AuthorLastName LIKE filter OR b.Title LIKE filter OR b.Topic LIKE filter