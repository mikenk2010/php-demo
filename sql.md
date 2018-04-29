# Q1 Find the cancellation rate of requests made by unbanned users between Oct 1, 2013 and Oct 3, 2013

### Step 1: Create VIEW (`trip_cancelled`) to collect Banned user and date between `Oct 1, 2013` and `Oct 3, 2013`

```
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
```

### Step 2: Calculate data

```
SELECT
    Request_at AS 'Day',
    ROUND(SUM(IF(status LIKE 'cancelled%', 1, 0)) / COUNT(*), 2) AS 'Cancellation Rate'
FROM
  trip_cancelled
GROUP BY
  Request_at;
```

### Result:

```
Day         Cancellation Rate
2013-10-01	0.33
2013-10-02	0.00
2013-10-03	0.50
```

# Q2 print the node id and the type of the node.
### Step 1: Create VIEWS
- `tree_distinct_id`: To collect distinct id
```
CREATE VIEW `tree_distinct_id`
AS
  SELECT
    DISTINCT p_id 
  FROM 
    tree 
  WHERE 
    p_id IS NOT NULL;
```

- `tree_root`: Collect Root Id based on VIEW `tree_distinct_id`
```
CREATE VIEW `tree_root`
AS
  SELECT
    id, p_id, 'Root' AS Type
  FROM
      tree
  WHERE
      p_id IS NULL;

```

- `tree_leaf`: Collect Leaf Id based on VIEW `tree_distinct_id`
```
CREATE VIEW `tree_leaf`
AS
  SELECT
    id, p_id, 'Leaf' AS Type
  FROM
    tree
  WHERE
    id NOT IN (SELECT * FROM `tree_distinct_id`)
    AND p_id IS NOT NULL;
```

- `tree_inner`: Collect Inner Id based on VIEW `tree_distinct_id`
```
CREATE VIEW `tree_inner`
AS
  SELECT
    id, p_id, 'Inner' AS Type
  FROM
    tree
  WHERE
    id IN (SELECT * FROM `tree_distinct_id`)
    AND p_id IS NOT NULL;
```

### Step 2: Calculate data
#### Using `UNION` to connect `VIEWS`

```
SELECT * FROM `tree_root`
UNION
SELECT * FROM `tree_leaf`
UNION SELECT * FROM `tree_inner`
ORDER BY
  p_id
```

# SQL Query file
[queries_q1-q2.sql](./queries_q1-q2.sql)

# Demonstrate SQL result

![Image](https://i.imgur.com/G00rHlS.png)
