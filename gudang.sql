-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 08. Desember 2016 jam 09:19
-- Versi Server: 5.0.27
-- Versi PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_customers`
--

CREATE TABLE IF NOT EXISTS `mst_customers` (
  `id` varchar(100) NOT NULL,
  `nama` varchar(100) default NULL,
  `alamat` varchar(100) default NULL,
  `handphone` varchar(15) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_customers`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_stocks`
--

CREATE TABLE IF NOT EXISTS `mst_stocks` (
  `id` varchar(10) NOT NULL,
  `namabarang` varchar(30) NOT NULL,
  `hpp` int(11) NOT NULL,
  `het` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_stocks`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `operator`
--

CREATE TABLE IF NOT EXISTS `operator` (
  `user` varchar(10) NOT NULL,
  `password` varchar(30) default NULL,
  `c_time` datetime default NULL,
  `m_time` datetime default NULL,
  `last_login` datetime default NULL,
  PRIMARY KEY  (`user`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `operator`
--

INSERT INTO `operator` (`user`, `password`, `c_time`, `m_time`, `last_login`) VALUES
('kevin', 'terserah', '2016-12-03 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
  `nama` varchar(100) default NULL,
  `qty` int(11) default NULL,
  `id` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian`
--