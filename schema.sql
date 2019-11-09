CREATE DATABASE task_force CHARACTER SET 'utf8';

-- **

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(32),
	css_class VARCHAR(16)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

CREATE TABLE quest (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(32),
	description TEXT(4096),
	category TEXT(32),
	file_name VARCHAR(255),
	location TEXT(64),
	price VARCHAR(8),
	deadline DATETIME,
	date_create DATE,
	time_create TIME,

	category_id INT(8),
	status_id INT(8),
	rating_id INT(8),
	image_id INT(8)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

CREATE TABLE task_image (
	id INT AUTO_INCREMENT PRIMARY KEY,
	image_path VARCHAR(45),
	task_id INT(8)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

CREATE TABLE status (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title TEXT(32)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

CREATE TABLE rating (
	id INT AUTO_INCREMENT PRIMARY KEY,
	stars INT(4),
	rating FLOAT(3) DEFAULT 0
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

CREATE TABLE comment (
  id INT AUTO_INCREMENT PRIMARY KEY,
	author TEXT(32),

	ststus_id INT(8),
	rating_id INT(8),
	quest_id INT(8)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- **

ALTER TABLE quest ADD FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE quest ADD FOREIGN KEY (rating_id) REFERENCES rating(id);
ALTER TABLE comment ADD FOREIGN KEY (rating_id) REFERENCES rating(id);
ALTER TABLE comment ADD FOREIGN KEY (quest_id) REFERENCES quest(id);
ALTER TABLE comment ADD FOREIGN KEY (ststus_id) REFERENCES status(id);
ALTER TABLE quest ADD FOREIGN KEY (status_id) REFERENCES status(id);
ALTER TABLE task_image ADD FOREIGN KEY (task_id) REFERENCES quest(id);