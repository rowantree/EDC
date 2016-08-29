CREATE TABLE `edc_event` (
  `edc_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `eventCode` varchar(45) DEFAULT NULL,
  `amountDue` decimal(10,0) DEFAULT NULL,
  `firstName` varchar(128) DEFAULT NULL,
  `lastName` varchar(128) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `paymentType` varchar(45) DEFAULT NULL,
  `regDate` datetime DEFAULT NULL,
  PRIMARY KEY (`edc_event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
