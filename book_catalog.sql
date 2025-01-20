CREATE DATABASE IF NOT EXISTS book_catalog;
USE book_catalog;

CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    year_published INT NOT NULL,
    category VARCHAR(100) NOT NULL
);

INSERT INTO books (title, isbn, author, publisher, year_published, category) VALUES
('To Kill a Mockingbird', '9780446310789', 'Harper Lee', 'Grand Central Publishing', 1960, 'Fiction'),
('1984', '9780451524935', 'George Orwell', 'Signet Classic', 1949, 'Science Fiction'),
('Pride and Prejudice', '9780141439518', 'Jane Austen', 'Penguin Classics', 1813, 'Romance');