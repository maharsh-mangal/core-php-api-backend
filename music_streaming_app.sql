
-- Create the database
CREATE DATABASE music_streaming_app;

-- Use the database
USE music_streaming_app;


-- Create music_category table
CREATE TABLE music_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    music_category_id INT NOT NULL,
    subscription_expiry DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (music_category_id) REFERENCES music_category(id)
);

-- Create the songs table
CREATE TABLE songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    album VARCHAR(100) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    release_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the playlists table
CREATE TABLE playlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the playlist_songs table
CREATE TABLE playlist_songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    playlist_id INT NOT NULL,
    song_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (playlist_id) REFERENCES playlists(id),
    FOREIGN KEY (song_id) REFERENCES songs(id)
);


-- Create music_category_songs table
CREATE TABLE music_category_songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    music_category_id INT NOT NULL,
    song_id INT NOT NULL,
    FOREIGN KEY (music_category_id) REFERENCES music_category(id),
    FOREIGN KEY (song_id) REFERENCES songs(id)
);

-- Insert music categories
INSERT INTO music_category (name) VALUES
('Rock'),
('Pop'),
('Jazz'),
('Classical'),
('Hip-Hop');



-- Insert sample users
INSERT INTO users (full_name, email, password, music_category_id, subscription_expiry) VALUES
('John Doe', 'john@example.com', 'hashed_password1', 2, '2024-12-31'),
('Jane Smith', 'jane@example.com', 'hashed_password2', 2, '2024-12-31'),
('Alice Johnson', 'alice@example.com', 'hashed_password3', 3, '2024-12-31'),
('Bob Brown', 'bob@example.com', 'hashed_password4', 1, '2024-12-31'),
('Charlie Davis', 'charlie@example.com', 'hashed_password5', 3, '2024-12-31'),
('Diana Evans', 'diana@example.com', 'hashed_password6', 4, '2024-12-31');

-- Insert sample songs
INSERT INTO songs (title, artist, album, genre, release_date) VALUES
('Bohemian Rhapsody', 'Queen', 'A Night at the Opera', 'Rock', '1975-10-31'),
('Shape of You', 'Ed Sheeran', 'Divide', 'Pop', '2017-01-06'),
('Smells Like Teen Spirit', 'Nirvana', 'Nevermind', 'Rock', '1991-09-10'),
('Blinding Lights', 'The Weeknd', 'After Hours', 'Pop', '2019-11-29'),
('Take Five', 'Dave Brubeck', 'Time Out', 'Jazz', '1959-09-21'),
('Fur Elise', 'Ludwig van Beethoven', 'Classical Masterpieces', 'Classical', '1810-04-27'),
('Lose Yourself', 'Eminem', '8 Mile', 'Hip-Hop', '2002-10-28'),
('Hotel California', 'Eagles', 'Hotel California', 'Rock', '1976-12-08'),
('Imagine', 'John Lennon', 'Imagine', 'Rock', '1971-09-09'),
('Thriller', 'Michael Jackson', 'Thriller', 'Pop', '1982-11-30'),
('Blue in Green', 'Miles Davis', 'Kind of Blue', 'Jazz', '1959-08-17'),
('The Four Seasons', 'Antonio Vivaldi', 'The Four Seasons', 'Classical', '1725-01-01'),
('Juicy', 'The Notorious B.I.G.', 'Ready to Die', 'Hip-Hop', '1994-08-09'),
('Like a Rolling Stone', 'Bob Dylan', 'Highway 61 Revisited', 'Rock', '1965-07-20'),
('Purple Haze', 'Jimi Hendrix', 'Are You Experienced', 'Rock', '1967-03-17');

-- Insert sample playlists
INSERT INTO playlists (user_id, name) VALUES
(1, 'Johns Rock Playlist'),
(2, 'Janes Pop Hits'),
(3, 'Alices Jazz Collection'),
(4, 'Bobs Classical Favorites'),
(5, 'Charlies Hip-Hop Beats'),
(6, 'Dianas Rock Anthems');

-- Insert sample playlist songs
INSERT INTO playlist_songs (playlist_id, song_id) VALUES
(1, 1),
(1, 3),
(1, 8),
(1, 9),
(2, 2),
(2, 4),
(2, 10),
(3, 5),
(3, 11),
(4, 6),
(4, 12),
(5, 7),
(5, 13),
(6, 1),
(6, 14),
(6, 15);

-- Insert music category songs
INSERT INTO music_category_songs (music_category_id, song_id) VALUES
(1, 1),
(1, 3),
(1, 8),
(1, 9),
(1, 14),
(1, 15),
(2, 2),
(2, 4),
(2, 10),
(2, 14),
(3, 5),
(3, 11),
(3, 14),
(3, 15),
(4, 6),
(4, 12),
(5, 7),
(5, 13);