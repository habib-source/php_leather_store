CREATE TYPE sex AS enum ('F', 'M');

CREATE TABLE users (
  id serial PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  user_name varchar(100) UNIQUE NOT NULL,
  pwd varchar(255) NOT NULL,
  active boolean DEFAULT FALSE,
  admin boolean DEFAULT FALSE,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  user_sex sex,
  date_naiss date,
  img_path varchar(255)
);

CREATE TABLE categories (
  id serial PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
);

CREATE TABLE products (
  id serial PRIMARY KEY,
  sku VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(12, 2) NOT NULL,
  stock_quantity INTEGER DEFAULT 0,
  category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TYPE order_status AS ENUM ('pending', 'processing', 'shipped', 'delivered', 'cancelled');

CREATE TABLE orders (
  id serial PRIMARY KEY,
  total_amount DECIMAL(12, 2) NOT NULL,
  status order_status DEFAULT 'pending',
  shipping_address TEXT NOT NULL,
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
  id serial PRIMARY KEY,
  order_id INTEGER REFERENCES orders(id) ON DELETE CASCADE,
  product_id INTEGER REFERENCES products(id),
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  price_at_purchase DECIMAL(12, 2) NOT NULL
);

CREATE TABLE cart_items (
  id serial PRIMARY KEY,
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
  product_id INTEGER REFERENCES products(id) ON DELETE CASCADE,
  UNIQUE(user_id, product_id),
  quantity INTEGER DEFAULT 1
);
