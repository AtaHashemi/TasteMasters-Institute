-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2023 at 10:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `mypages`
--

CREATE TABLE `mypages` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `timee` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(50) NOT NULL,
  `image_filename` varchar(100) NOT NULL,
  `new_image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mypages`
--

INSERT INTO `mypages` (`id`, `title`, `content`, `timee`, `name`, `image_filename`, `new_image_path`) VALUES
(2, 'Rice Ingredient', '1 cup long-grain white rice\r\n2 cups water\r\n1 tablespoon butter or olive oil \r\n1 teaspoon Salt', '2023-12-31 08:33:12', 'Jack', 'rice.jpg', 'uploads\\rice.jpg'),
(40, 'Pizza Ingredient', 'For the Pizza Dough:\r\n2 1/4 teaspoons (1 packet) active dry yeast\r\n1 teaspoon sugar\r\n1 cup warm water (110&deg;F/43&deg;C)\r\n3 cups all-purpose flour\r\n1 teaspoon salt\r\n1 tablespoon olive oil\r\nFor the Pizza Sauce:\r\n1 can (14 ounces) crushed tomatoes\r\n2 cloves garlic, minced\r\n1 teaspoon dried oregano\r\n1 teaspoon dried basil\r\nSalt and pepper to taste\r\nFor Toppings:\r\nShredded mozzarella cheese', '2023-12-31 08:40:21', 'Tom', 'pizza.jpg', 'uploads\\pizza.jpg'),
(41, 'Kebab Ingredient', '700g of your choice of meat\r\n1/4 cup plain yogurt\r\n3 tablespoons olive oil\r\n2 tablespoons lemon juice\r\n2 teaspoons ground cumin\r\n2 teaspoons ground coriander\r\n1 teaspoon paprika\r\n1 teaspoon ground turmeric\r\n1 tablespoon grated ginger\r\nSalt and pepper to taste', '2023-12-31 08:35:41', 'Steve', 'Kebab.jpg', 'uploads\\Kebab.jpg'),
(42, 'Fish Ingredient', '4 fish fillets\r\n2 tablespoons olive oil\r\n2 tablespoons lemon juice\r\n1 teaspoon dried oregano\r\n1 teaspoon paprika\r\nSalt and pepper to taste\r\nLemon wedges for serving\r\nFresh herbs', '2023-12-31 08:40:43', 'Oliver', 'fish.jpg', 'uploads\\fish.jpg'),
(43, 'Pasta Ingredient', '8 ounces (about 225g) of your favorite pasta \r\n2 tablespoons olive oil\r\n3 cloves garlic, minced\r\n1 can (14 ounces) crushed tomatoes\r\n1 teaspoon dried oregano\r\n1 teaspoon dried basil\r\nSalt and pepper to taste\r\nRed pepper flakes (optional, for heat)\r\nGrated Parmesan cheese for serving\r\nFresh basil or parsley for garnish', '2023-12-31 08:43:01', 'Sam', 'pasta.jpg', 'uploads\\pasta.jpg'),
(44, 'Omelette Ingredient', '3 large eggs\r\nSalt and pepper to taste\r\n1 tablespoon butter or cooking oil\r\nFillings (choose a combination based on your liking):\r\n1/4 cup diced bell peppers (any color)\r\n1/4 cup diced onions\r\n1/4 cup diced tomatoes\r\n1/4 cup shredded cheese\r\n1/4 cup diced ham, cooked bacon, or cooked sausage\r\nFresh herbs', '2023-12-31 08:42:40', 'Ivy', 'omelette.jpg', 'uploads\\omelette.jpg'),
(45, 'Ice cream Ingredient', '2 cups heavy cream\r\n1 cup whole milk\r\n3/4 cup granulated sugar\r\n1 tablespoon pure vanilla extract\r\nPinch of salt', '2023-12-31 08:42:14', 'Olive', 'ice cream.jpg', 'uploads\\ice cream.jpg'),
(46, 'Bread Ingredient', '4 cups all-purpose flour\r\n1 tablespoon sugar\r\n1 tablespoon active dry yeast\r\n1 1/2 teaspoons salt\r\n1 1/4 cups warm water (about 110&deg;F or 43&deg;C)\r\n2 tablespoons olive oil or melted butter ', '2023-12-31 08:41:49', 'Tom', 'bread.jpg', 'uploads\\bread.jpg'),
(47, 'Burger Ingredient', '450g ground beef\r\nSalt and pepper to taste\r\n1 teaspoon Worcestershire sauce (optional)\r\n1/2 teaspoon garlic powder ', '2023-12-31 08:41:24', 'Emily', 'burger.jpg', 'uploads\\burger.jpg'),
(48, 'Soup Ingredient', '1 tablespoon olive oil\r\n1 onion, finely chopped\r\n2 carrots, peeled and sliced\r\n2 celery stalks, sliced\r\n3 cloves garlic, minced\r\n8 cups chicken broth\r\n1 bay leaf\r\n1 teaspoon dried thyme\r\nSalt and pepper to taste\r\n1 cup cooked chicken, shredded or diced\r\n2 cups egg noodles\r\nFresh parsley, chopped \r\nLemon wedges ', '2023-12-31 08:31:21', 'Sam', 'soup.jpg', 'uploads\\soup.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mypages`
--
ALTER TABLE `mypages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mypages`
--
ALTER TABLE `mypages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
