CREATE TABLE offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    price_per_click DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)

);

CREATE TABLE offer_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    offer_id INT,
    topic VARCHAR(255) NOT NULL,
    FOREIGN KEY (offer_id) REFERENCES offers(id) ON DELETE CASCADE
);

CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unique_url VARCHAR(255) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    offer_id INT NOT NULL,
    clicks INT,
    UNIQUE KEY unique_subscription (user_id, offer_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (offer_id) REFERENCES offers(id)
);


-- помоги создать структуру  mysql.
-- есть пользователя с ролью рекламодатель и пользователь с ролью веб мастер. 

-- рекламодатель должен видеть список созданных заказов. каждый заказ содержит информацию:
-- Название, Темы (может быть несколько), url, количество веб мастеров подписанных на этот заказ (сумма подписанных веб мастеров ), цена за клик, количество кликов (сумма от всех кликов у всех веб-мастеров), расход. 
-- А  веб мастер должен видеть в своем кабинете список всех заказов, на которые он подписан с информацией: 
-- Название, Темы (может быть несколько), уникальный для себя url, цена за клик, количество кликов по его уникальной ссылке, доход. 