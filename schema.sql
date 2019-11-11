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
	latitude TEXT(16) NOT NULL,
	longitude TEXT(16) NOT NULL,
	price FLOAT(8) NOT NULL,
	deadline DATETIME NOT NULL,
	created DATETIME NOT NULL DEFAULT NOW(),

	category_id INT,
	status_id INT,
	rating_id INT,
	reviews_id INT,
	feedback_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE task_image (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45) NOT NULL,
	task_id INT NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE status (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title TEXT NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE rating (
	id INT AUTO_INCREMENT PRIMARY KEY,
	stars TINYINT(1) NOT NULL,
	rating FLOAT(3) NOT NULL DEFAULT 0
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE feedback (
	id INT AUTO_INCREMENT PRIMARY KEY,

	ststus_id INT,
	rating_id INT,
	task_id INT,
	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE reviews (
	id INT AUTO_INCREMENT PRIMARY KEY,
	description TEXT NOT NULL,

	ststus_id INT,
	raiting_id INT,
	task_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- NOTE: user -----------------------------------------------------------------

CREATE TABLE account (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(64) NOT NULL,
	name VARCHAR(64) NOT NULL,
	password CHAR(64) NOT NULL,
	address TEXT NOT NULL,
	born DATETIME NOT NULL DEFAULT NOW(),
	about TEXT NOT NULL,
	visit DATETIME NOT NULL DEFAULT NOW(),
	quest_completed INT(4) NOT NULL,

	city_id INT,
	contacts_id INT,
	specialization_id INT,
	notification_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE city (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE user_contacts (
	id INT AUTO_INCREMENT PRIMARY KEY,
	phone INT,
	skype VARCHAR(64),
	messanger VARCHAR(64)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE user_image (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45) NOT NULL,

	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


CREATE TABLE specialization (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE notification (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE message (
	id INT AUTO_INCREMENT PRIMARY KEY,
	message TEXT NOT NULL,

	account_id INT
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


-- **

CREATE INDEX index_category ON category(id);

ALTER TABLE task ADD FOREIGN KEY (rating_id) REFERENCES rating(id);
ALTER TABLE task ADD FOREIGN KEY (status_id) REFERENCES status(id);
ALTER TABLE task ADD FOREIGN KEY (reviews_id) REFERENCES reviews(id);
ALTER TABLE task ADD FOREIGN KEY (feedback_id) REFERENCES feedback(id);

ALTER TABLE feedback ADD FOREIGN KEY (rating_id) REFERENCES rating(id);
ALTER TABLE feedback ADD FOREIGN KEY (task_id) REFERENCES task(id);
ALTER TABLE feedback ADD FOREIGN KEY (ststus_id) REFERENCES status(id);
ALTER TABLE feedback ADD FOREIGN KEY (account_id) REFERENCES account(id);

ALTER TABLE reviews ADD FOREIGN KEY (ststus_id) REFERENCES status(id);
ALTER TABLE reviews ADD FOREIGN KEY (task_id) REFERENCES task(id);
ALTER TABLE reviews ADD FOREIGN KEY (raiting_id) REFERENCES rating(id);

ALTER TABLE task_image ADD FOREIGN KEY (task_id) REFERENCES task(id);

-- **

ALTER TABLE message ADD FOREIGN KEY (account_id) REFERENCES account(id);
ALTER TABLE feedback ADD FOREIGN KEY (account_id) REFERENCES account(id);

ALTER TABLE account ADD FOREIGN KEY (city_id) REFERENCES city(id);
ALTER TABLE account ADD FOREIGN KEY (contacts_id) REFERENCES user_contacts(id);
ALTER TABLE account ADD FOREIGN KEY (specialization_id) REFERENCES specialization(id);
ALTER TABLE account ADD FOREIGN KEY (notification_id) REFERENCES notification(id);

ALTER TABLE user_image ADD FOREIGN KEY (account_id) REFERENCES account(id);