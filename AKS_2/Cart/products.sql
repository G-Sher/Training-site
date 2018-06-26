DROP TABLE IF EXISTS products;

CREATE TABLE IF NOT EXISTS products (
                id int(11) NOT NULL AUTO_INCREMENT, 
                name varchar(100) NOT NULL, 
                image varchar(100) NOT NULL, 
                price float NOT NULL, PRIMARY KEY (id)
                )ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO products(id, name, price, image) VALUES
				('2', 'Small Basket with Apples', '19.99', 'basket1.jpg'),
				('1', 'Small Basket', 18.99, 'basket4.jpg'),
				('4', 'Medium Basket with Apples', 24.99, 'basket1.jpg'),
				('3', 'Medium Basket', 23.99, 'basket4.jpg'),
				('6', 'Large Basket with Apples', 29.99, 'basket1.jpg'),
				('5', 'Large Basket', 28.99, 'basket4.jpg');