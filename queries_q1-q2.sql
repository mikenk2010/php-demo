-- Q1
-- Create Trips table
CREATE TABLE `Trips` (
  `Id` int(11) DEFAULT NULL,
  `Client_Id` int(11) DEFAULT NULL,
  `Driver_Id` int(11) DEFAULT NULL,
  `City_Id` int(11) DEFAULT NULL,
  `Status` enum('completed','cancelled_by_driver','cancelled_by_client') DEFAULT NULL,
  `Request_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create Users table
CREATE TABLE `Users` (
  `Users_Id` int(11) DEFAULT NULL,
  `Banned` varchar(50) DEFAULT NULL,
  `Role` enum('client','driver','partner') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Insert data
-- Clear data
TRUNCATE TABLE Trips;

-- Insert
INSERT INTO Trips (Id, Client_Id, Driver_Id, City_Id, Status, Request_at)
  VALUES
  ('1', '1', '10', '1', 'completed', '2013-10-01'),
  ('2', '2', '11', '1', 'cancelled_by_driver', '2013-10-01'),
  ('3', '3', '12', '6', 'completed', '2013-10-01'),
  ('4', '4', '13', '6', 'cancelled_by_client', '2013-10-01'),
  ('5', '1', '10', '1', 'completed', '2013-10-02'),
  ('6', '2', '11', '6', 'completed', '2013-10-02'),
  ('7', '3', '12', '6', 'completed', '2013-10-02'),
  ('8', '2', '12', '12', 'completed', '2013-10-03'),
  ('9', '3', '10', '12', 'completed', '2013-10-03'),
  ('10', '4', '13', '12', 'cancelled_by_driver', '2013-10-03');

-- Clreate data
TRUNCATE TABLE Users;

-- Insert data
INSERT INTO Users (Users_Id, Banned, Role)
  VALUES 
  ('1', 'No', 'client'),
  ('2', 'Yes', 'client'),
  ('3', 'No', 'client'),
  ('4', 'No', 'client'),
  ('10', 'No', 'driver'),
  ('11', 'No', 'driver'),
  ('12', 'No', 'driver'),
  ('13', 'No', 'driver');

-- PROCESS
-- Step 1: Create VIEW (`trip_cancelled`) to collect Banned user and date between `Oct 1, 2013` and `Oct 3, 2013`

CREATE VIEW `trip_cancelled`
AS
  SELECT
    Request_at,
    Status
  FROM
    Trips
  INNER JOIN
    Users ON Trips.client_id = Users.users_id
  WHERE
    (Trips.Request_at BETWEEN '2013-10-01' AND '2013-10-03')
    AND Users.banned = 'No';

-- Step 2: Query data
SELECT
    Request_at AS 'Day',
    ROUND(SUM(IF(status LIKE 'cancelled%', 1, 0)) / COUNT(*), 2) AS 'Cancellation Rate'
FROM
  trip_cancelled
GROUP BY
  Request_at;


# ************************************************************ 
-- Q2
-- Create table tree
CREATE TABLE `tree` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Clear data
TRUNCATE TABLE tree;

-- Insert data
INSERT INTO tree (id, p_id) VALUES 
	('1',NULL), 
	('2',1), 
	('3',1), 
	('4',2), 
	('5',2);

-- Process data
# Mehod 1:	
-- Create view for distince
CREATE VIEW `tree_distinct_id`
AS
  SELECT
    DISTINCT p_id 
  FROM 
    tree 
  WHERE 
    p_id IS NOT NULL;

-- Create view for `Root`
CREATE VIEW `tree_root`
AS
  SELECT
    id, p_id, 'Root' AS Type
  FROM
      tree
  WHERE
      p_id IS NULL;

-- Create view for `Leaf`
CREATE VIEW `tree_leaf`
AS
  SELECT
    id, p_id, 'Leaf' AS Type
  FROM
    tree
  WHERE
    id NOT IN (SELECT * FROM `tree_distinct_id`)
    AND p_id IS NOT NULL;

-- Create view for `Inner`
CREATE VIEW `tree_inner`
AS
  SELECT
    id, p_id, 'Inner' AS Type
  FROM
    tree
  WHERE
    id IN (SELECT * FROM `tree_distinct_id`)
    AND p_id IS NOT NULL;

-- Method 1
SELECT 
  * 
FROM 
  `tree_root`

UNION

SELECT 
  *
FROM 
  `tree_leaf`

UNION

SELECT 
  *
FROM 
  `tree_inner`
ORDER BY 
  id;


-- Method 2
SELECT
  id,
  p_id,
  CASE
    WHEN p_id IS NULL THEN 'Root'
    WHEN id IN (SELECT p_id FROM tree) THEN 'Inner'
    ELSE 'Leaf'
  END AS `Type`
FROM 
  tree
ORDER BY 
  id;
