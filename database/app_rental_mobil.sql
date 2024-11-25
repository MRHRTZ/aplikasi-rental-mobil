CREATE TABLE mobil(
    id_mobil INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100),
    merk VARCHAR(100),
    warna VARCHAR(100),
    tahun_pembuatan INT,
    biaya_sewa INT,
    gambar VARCHAR(255)
);

CREATE TABLE pengguna(
    id_pengguna INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100),
    username VARCHAR(100),
    password VARCHAR(100),
    alamat VARCHAR(100),
    peran ENUM('petugas', 'anggota'),
    no_telp VARCHAR(100)
);

CREATE TABLE rental(
    id_rental INT PRIMARY KEY AUTO_INCREMENT,
    id_pengguna INT,
    id_mobil INT,
    tanggal_rental DATE,
    tanggal_kembali DATE,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna),
    FOREIGN KEY (id_mobil) REFERENCES mobil(id_mobil)
);

INSERT INTO mobil (nama, merk, warna, tahun_pembuatan, biaya_sewa, gambar) VALUES
('Avanza', 'Toyota', 'Hitam', 2018, 300000, 'mobil1.jpg'),
('Grand Max', 'Daihatsu', 'Silver', 2019, 280000, 'mobil2.jpg'),
('Civic', 'Honda', 'Merah', 2020, 350000, 'mobil3.jpg'),
('Fortuner', 'Toyota', 'Putih', 2021, 500000, 'mobil4.jpg'),
('Brio', 'Honda', 'Orange', 2022, 400000, 'mobil5.jpg');

INSERT INTO pengguna (nama, username, password, alamat, peran, no_telp) VALUES
('Budi', 'budi123', MD5('password1'), 'Jl. Merdeka No. 1', 'anggota', '081234567890'),
('Siti', 'siti456', MD5('password2'), 'Jl. Sudirman No. 2', 'anggota', '081234567891'),
('Andi', 'andi789', MD5('password3'), 'Jl. Thamrin No. 3', 'petugas', '081234567892'),
('Rina', 'rina012', MD5('password4'), 'Jl. Gatot Subroto No. 4', 'anggota', '081234567893'),
('Dewi', 'dewi345', MD5('password5'), 'Jl. Diponegoro No. 5', 'petugas', '081234567894');

INSERT INTO rental (id_pengguna, id_mobil, tanggal_rental, tanggal_kembali) VALUES
(1, 1, '2023-01-01', '2023-01-05'),
(2, 2, '2023-01-02', '2023-01-06'),
(3, 3, '2023-01-03', '2023-01-07'),
(4, 4, '2023-01-04', '2023-01-08'),
(5, 5, '2023-01-05', '2023-01-09');