-- Sdate and spage are for unambiguous, sortable date and tinyint types.
-- Date and page contain additional out of type text that should display
-- Sdate and spage are copies of date and page with the out of type
-- strings removed manually.  (oy!!)

CREATE TABLE IF NOT EXISTS `ncsi` (
  `headline` varchar(100) DEFAULT NULL,
  `newspaper` char(23) DEFAULT NULL,
  `date` char(18) DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `page` varchar(20) DEFAULT NULL,
  `spage` tinyint(4) DEFAULT NULL,
  `subject` varchar(75) DEFAULT NULL,
  `photo` char(3) DEFAULT NULL,
  `columntitle` varchar(40) DEFAULT NULL,
  `author` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

