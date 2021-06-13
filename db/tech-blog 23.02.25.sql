SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `owner` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
);

INSERT INTO `comments` (`id`, `owner`, `comment`, `title`, `created_at`) VALUES
(15, 'abv', 'Very cool information presented in a very informal way of understanding. Appreciate the hard work you are putting into making all of this superb articles!', 'Top Cybersecurity Companies for 2021', '2021-06-12 10:31:03'),
(25, 'abv', 'This is such a good article!', 'Top 10 Programming Blogs in 2020', '2021-06-12 14:16:00'),
(27, 'GameOwner', 'Very good article. Thanks for the tremendous information!', 'What are the advantages of Ethereum?', '2021-06-13 19:42:07'),
(28, 'GameOwner', 'Great content! Keep the nice grind!', 'What are the advantages of Ethereum?', '2021-06-13 19:42:26');

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `owner` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL
);

INSERT INTO `posts` (`id`, `title`, `text`, `owner`, `image`, `created_at`) VALUES
(21, 'Bitcoin Definition: How Does Bitcoin Work?', 'Bitcoin is a digital currency that was created in January 2009. It follows the ideas set out in a whitepaper by the mysterious and pseudonymous Satoshi Nakamoto.1﻿ The identity of the person or persons who created the technology is still a mystery. Bitcoin offers the promise of lower transaction fees than traditional online payment mechanisms and, unlike government-issued currencies, it is operated by a decentralized authority.\r\n\r\nBitcoin is a type of cryptocurrency. There are no physical bitcoins, only balances kept on a public ledger that everyone has transparent access to. All bitcoin transactions are verified by a massive amount of computing power. Bitcoins are not issued or backed by any banks or governments, nor are individual bitcoins valuable as a commodity. Despite it not being legal tender, Bitcoin is very popular and has triggered the launch of hundreds of other cryptocurrencies, collectively referred to as altcoins. Bitcoin is commonly abbreviated as \"BTC.\"', 'GameOwner', '60c35e424a2862.20708812.jpg', '2021-06-11 12:06:55'),
(3, 'Is Learning How To Code Still Worth It For Millennials?', 'I’m starting up to solve a problem I care deeply about…. Should I learn how to code to build out a prototype? Should I outsource development initially? Should I study computer science? These are questions that every first-time entrepreneur asks. Back in 2014, my vehement answer in an article called “Should We Require Computer Science Classes?” was to learn computer science or at least be able to program yourself. The basic premise has been echoed throughout mass media with everyone from Bill Gates to the New York Times to the Estonian Government pushing more students to learn how to code.', 'GameOwner', '60c35e424a2862.20708813.jpg', '2021-06-08 22:58:00'),
(2, 'Top 10 Programming Blogs in 2020', 'Programming is an interesting field that gives us some superpowers to control the computer systems. It can be used in airplanes, traffic control, robots, self-driving cars, websites, mobile apps, and tons of other use cases.\r\n\r\nNow, the main thing is that software engineers have created several programming languages and each of them is suitable to solve different problems.\r\n\r\nToday, I’m gonna share with you some websites and blogs that write about different programming languages and the best practices to use them.\r\n\r\nThis list is in no particular order, all of them are great reads!', 'GameOwner', '60c35e424a2862.20708814.jpeg', '2021-06-08 00:00:00'),
(27, 'Top Cybersecurity Companies for 2021', 'As the demand for robust security defense grows by the day, the market for cybersecurity technology has exploded, as well as the number of available solutions.\r\n\r\nTo help you navigate this growing marketplace, we provide our recommendations for the world’s leading cybersecurity technology providers, based on user reviews, features and benefits, vendor information, analyst reports and use cases.', 'GameOwner', '60c38e4a238078.35686513.png', '2021-06-11 16:24:42'),
(23, 'What are the advantages of Ethereum?', 'Proponents of Ethereum believe its main advantage over Bitcoin is that it allows individuals and companies to do much more than just transfer money between entities leading Bloomberg to write it’s “the hottest platform in the world of cryptocurrencies and blockchains” and companies such as JPMorgan Chase, Intel and Microsoft to invest in it.', 'abv', '60c35e424a2862.20708811.jpg', '2021-06-11 12:14:16'),
(22, 'What is Ethereum? – A Beginner’s Guide', 'What is Ethereum?\r\nEthereum is an open-source software platform that developers can use to create cryptocurrencies and other digital applications. Ethereum is also the name used to describe the cryptocurrency, Ether.\r\n\r\nThis Beginner’s Guide will get you up to speed quickly on the background of Ethereum, its intended purpose, and how it is being used around the world.\r\n\r\nWho is behind Ethereum?\r\nMany programmers and entrepreneurs were instrumental in founding Ethereum, but most of the credit goes to Vitalik Buterin and Gavin Wood. However, if you are wondering who controls Ethereum, that’s a different matter. The Ethereum network is decentralised, which means that no one person or entity controls the platform.\r\n\r\nWhen was Ethereum created?\r\nEthereum moved relatively quickly from inception to creation.', 'abv', '60c35e424a2862.20708810.jpg', '2021-06-11 12:13:40');

CREATE TABLE `replies` (
  `id` int NOT NULL,
  `owner` varchar(255),
  `commentid` int NOT NULL,
  `comment` varchar(255),
  `created_at` datetime NOT NULL
);

INSERT INTO `replies` (`id`, `owner`, `commentid`, `comment`, `created_at`) VALUES
(13, 'GameOwner', 15, 'Thank you very much!', '2021-06-12 14:22:44'),
(14, 'abv', 15, 'No worries at all!', '2021-06-12 14:23:07'),
(15, 'GameOwner', 27, 'No worries at all!', '2021-06-13 19:42:14'),
(16, 'GameOwner', 27, 'Seems so nice of you!', '2021-06-13 19:42:43');

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'User',
  `ban` tinyint(1) NOT NULL DEFAULT '0'
);

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `ban`) VALUES
(11, 'abv', 'abv@abv.bg', 'aeee7f09a8ecd475a755407084f0e7c0', 'User', 0),
(14, 'admin', 'admin@admin.bg', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 0),
(9, 'GameOwner', 'svetlozar.01@abv.bg', '682efaabed7d9b78a486836597cd8da3', 'Admin', 0);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `comment` (`comment`),
  ADD KEY `title` (`title`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`title`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner` (`owner`);

ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `commentid` (`commentid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`title`) REFERENCES `posts` (`title`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`commentid`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;