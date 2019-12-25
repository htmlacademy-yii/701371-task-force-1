CREATE DATABASE task_force CHARACTER SET 'utf8';


-- NOTE: task -----------------------------------------------------------------

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(32) NOT NULL,
	css_class VARCHAR(16) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE task (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(64) NOT NULL,
	description TEXT NOT NULL,
	address VARCHAR(255) NOT NULL,
	latitude TEXT(16) NOT NULL,
	longitude TEXT(16) NOT NULL,
	price FLOAT(8) NOT NULL,
	deadline DATETIME NOT NULL,
    created DATETIME NOT NULL DEFAULT NOW(),

	-- image_id INT,
	city_id INT,
	executor_id INT,
	status_id INT,
	category_id INT
	-- rating_id INT,
	-- reviews_id INT,
	-- feedback_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE task_file (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45) NOT NULL,
	task_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- NOTE: статусы заданий
CREATE TABLE task_status (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title TEXT NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- NOTE: статусы откликов
CREATE TABLE feedback_status (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title TEXT NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- NOTE: отклики
CREATE TABLE feedback (
	id INT AUTO_INCREMENT PRIMARY KEY,

	rating_id INT,
	account_id INT,
	task_id INT,
	status_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- NOTE: отзывы
CREATE TABLE reviews (
	id INT AUTO_INCREMENT PRIMARY KEY,
	description TEXT NOT NULL,
	raiting TINYINT(1) NOT NULL,

	ststus_id INT,
	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- NOTE: users -----------------------------------------------------------------

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(64) NOT NULL,
	name VARCHAR(64) NOT NULL,
	password CHAR(64) NOT NULL,
	address TEXT NOT NULL,
	born DATETIME NOT NULL DEFAULT NOW(),
    create DATETIME NOT NULL DEFAULT NOW(),
	about TEXT NOT NULL,
	visit DATETIME NOT NULL DEFAULT NOW(),
	quest_completed INT(4) NOT NULL,
	views_counter INT NOT NULL,
	hide_account TINYINT(1) NOT NULL,
	show_contacts_to_customer TINYINT(1) NOT NULL,

	avatar_id INT,
	role_id INT,
	raiting_id INT,
	city_id INT,
	contacts_id INT,
	notification_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_favorites (
	id INT AUTO_INCREMENT PRIMARY KEY,

	favorites_account_id INT,
	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_contacts (
	id INT AUTO_INCREMENT PRIMARY KEY,
	phone INT(10) NOT NULL,
	skype VARCHAR(64) NOT NULL,
	messanger VARCHAR(64) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_image (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45) NOT NULL,

	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_avatar (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_category (
	id INT AUTO_INCREMENT PRIMARY KEY,

	account_id INT,
	category_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE users_roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32) NOT NULL,
	key_code VARCHAR(64) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE city (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32) NOT NULL,

	latitude VARCHAR(24) NOT NULL,
	longitude VARCHAR(24) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE notification (
	id INT AUTO_INCREMENT PRIMARY KEY,
	new_messages TINYINT(1) NOT NULL,
	task_actions TINYINT(1) NOT NULL,
	new_responds TINYINT(1) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE message (
	id INT AUTO_INCREMENT PRIMARY KEY,
	message TEXT NOT NULL,

	sender_id INT,
	reciever_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

# CREATE TABLE opinions (
#     id INT AUTO_INCREMENT PRIMARY KEY,
#     created DATETIME NOT NULL DEFAULT NOW(),
#     rate INT,
#     description TEXT NOT NULL
# )
# ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- **

CREATE INDEX index_category ON category(id);

ALTER TABLE task ADD FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE task ADD FOREIGN KEY (executor_id) REFERENCES users(id);
ALTER TABLE reviews ADD FOREIGN KEY (account_id) REFERENCES users(id);
ALTER TABLE feedback ADD FOREIGN KEY (task_id) REFERENCES task(id);
ALTER TABLE task ADD FOREIGN KEY (city_id) REFERENCES city(id);
ALTER TABLE feedback ADD FOREIGN KEY (account_id) REFERENCES users(id);
ALTER TABLE feedback ADD FOREIGN KEY (status_id) REFERENCES feedback_status(id);
ALTER TABLE task ADD FOREIGN KEY (status_id) REFERENCES task_status(id);
ALTER TABLE task_file ADD FOREIGN KEY (task_id) REFERENCES task(id);


-- **

ALTER TABLE message ADD FOREIGN KEY (sender_id) REFERENCES users(id);
ALTER TABLE message ADD FOREIGN KEY (reciever_id) REFERENCES users(id);
ALTER TABLE users ADD FOREIGN KEY (city_id) REFERENCES city(id);
ALTER TABLE users ADD FOREIGN KEY (contacts_id) REFERENCES users_contacts(id);
ALTER TABLE users ADD FOREIGN KEY (avatar_id) REFERENCES users_avatar(id);
ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES users_roles(id);
ALTER TABLE users ADD FOREIGN KEY (notification_id) REFERENCES notification(id);
ALTER TABLE users_category ADD FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE users_category ADD FOREIGN KEY (account_id) REFERENCES users(id);
ALTER TABLE users_favorites ADD FOREIGN KEY (favorites_account_id) REFERENCES users(id);
ALTER TABLE users_favorites ADD FOREIGN KEY (account_id) REFERENCES users(id);
ALTER TABLE users_image ADD FOREIGN KEY (account_id) REFERENCES users(id);
