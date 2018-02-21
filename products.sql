--
-- Table structure for table `tbl_product`
--
CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`image` varchar(255) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `price` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`price` double(10,2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_product`
--
INSERT INTO `products` (`id`, `name`, `image`) VALUES
(1, 'Samsung J2 Pro', 'broccoli.jpg'),
(2, 'HP Notebook', 'carrot.jpg'),
(3, 'Panasonic T44 Lite', 'potato.jpg');

INSERT INTO `price` (`id`, `price`) VALUES
(1, 5),
(2, 10),
(3, 15);
