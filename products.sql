--
-- Table structure for table `tbl_product`
--
CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`category` varchar(255) NOT NULL,
`stock` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

CREATE TABLE IF NOT EXISTS `price` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`price` double(10,2) NOT NULL,
PRIMARY KEY (`id`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `products` (`id`, `name`, `category`, `stock`) VALUES
(1, 'Broccoli', 'food', 10),
(2, 'Carrot', 'food', 10),
(3, 'Potato', 'food', 10),
(4, 'Fish', 'food', 10),
(5, 'Steak', 'food', 10),
(6, 'Mango', 'food', 10),
(7, 'Bread','food', 10),
(8, 'Computer', 'tech', 10),
(9, 'Power Cable', 'tech', 10),
(10, 'Case', 'tech', 10),
(11, 'Headphones', 'tech', 10),
(12, 'Printer', 'tech', 10),
(13, 'USB', 'tech', 10),
(14, 'Speaker','tech', 10),
(15, 'Pepe', 'meme', 10),
(16, 'Turtle Kid', 'meme', 10),
(17, 'Nick Cage', 'meme', 10),
(18, 'Knuckles', 'meme', 10),
(19, 'Dwight', 'meme', 10),
(20, 'Why you lyin', 'meme', 10),
(21, 'Arthur Fist','meme', 10);

INSERT INTO `price` (`id`, `price`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 8),
(5, 15),
(6, 2),
(7, 5),
(8, 1000),
(9, 50),
(10, 25),
(11, 30),
(12, 100),
(13, 5),
(14, 200),
(15, 100),
(16, 20),
(17, 50),
(18, 10),
(19, 200),
(20, 20),
(21, 100);


/*
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
