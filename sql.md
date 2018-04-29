# Q1

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

# Q2
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
### Method 1
#### Using `UNION` to connect `VIEWS`

```
  SELECT * FROM `tree_root`
UNION
  SELECT * FROM `tree_leaf`
UNION 
  SELECT * FROM `tree_inner`
ORDER BY
  p_id
```

#### Result of Method 1

```
id	p_id	Type
1	NULL	Root
2	1	Inner
3	1	Leaf
4	2	Leaf
5	2	Leaf
```

### Method 2

```
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
  id
```

#### Result of Method 2

```
id	p_id	Type
1	NULL	Root
2	1	Inner
3	1	Leaf
4	2	Leaf
5	2	Leaf
```



# SQL Query file
[queries_q1-q2.sql](./queries_q1-q2.sql)

# Demonstrate SQL result

![Image](https://i.imgur.com/bkc8664.png)
