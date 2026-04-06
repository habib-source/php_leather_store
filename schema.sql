CREATE TYPE sex AS enum ('F', 'M');

CREATE TABLE users (
  id bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  user_name varchar(100) UNIQUE NOT NULL,
  pwd varchar(255) NOT NULL,
  active boolean DEFAULT FALSE,
  activation_code   varchar(255),
  activation_expiry timestamp,
  admin boolean DEFAULT FALSE,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  user_sex sex,
  birthday date,
  img_path varchar(255)
);

CREATE TABLE categories (
  id bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT
);

CREATE TABLE products_categories (
  category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
  product_id INTEGER REFERENCES products(id) ON DELETE SET NULL,
  PRIMARY KEY(category_id, product_id)
);

CREATE TABLE products (
  id bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  sku VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(12, 2) NOT NULL,
  description TEXT,
  stock_quantity INTEGER DEFAULT 0,
  img_path varchar(255)
);

CREATE TYPE order_status AS ENUM ('pending', 'processing', 'shipped', 'delivered', 'cancelled');

CREATE TABLE orders (
  id bigint GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  total_amount DECIMAL(12, 2) NOT NULL,
  status order_status DEFAULT 'pending',
  shipping_address TEXT NOT NULL,
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
  order_id INTEGER REFERENCES orders(id) ON DELETE CASCADE,
  product_id INTEGER REFERENCES products(id),
  PRIMARY KEY(order_id, product_id),
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  price_at_purchase DECIMAL(12, 2) NOT NULL
);

CREATE TABLE cart_items (
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
  product_id INTEGER REFERENCES products(id) ON DELETE CASCADE,
  PRIMARY KEY(user_id, product_id),
  quantity INTEGER DEFAULT 1
);
