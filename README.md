# Basic User login & signup in php

 Basic User login & signup in php  with JavaScript form validations


Import sql file "sz_phptutorial"

#########################

-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


##########################
