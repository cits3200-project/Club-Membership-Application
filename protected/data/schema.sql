-- NOTE: The following two tables may be superfluous. If we use them it would be easier for the client
-- to add new status's and payment methods in the future (just add a code and a display name to the database)
-- but if that's a really rare occurrence it may just be easier to streamline the database and store the 'code'
-- field in the membership table instead. On the other hand, if we got really ambitious, both ENUM fields in
-- the 'membership' and 'member' table could be replaced with similar tables to allow for more extensibility there also.

CREATE TABLE IF NOT EXISTS tbl_membership_status
(
	code 		varchar(15) NOT NULL PRIMARY KEY,
	display 	varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tbl_payment_method
(
	code 		varchar(15) NOT NULL PRIMARY KEY,
	display 	varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tbl_membership
(
	membershipId 		varchar(128) NOT NULL PRIMARY KEY, -- not sure on the format we'll be using for the membership id, so left it wide enough for a SHA512 hash.
	name 				varchar(100) NOT NULL,
	familyName			varchar(50)	 NOT NULL, -- again, confirm the width of this field.
	phoneNumber 		varchar(20), -- need to check that these 2 fields will be wide enough for valid numbers (thinking of swedish numbers here)
	alternatePhone 		varchar(20),
	emailAddress 		varchar(100) NOT NULL,
	alternateEmail 		varchar(100),
	type				ENUM('F','C','S','PC') NOT NULL, -- 'Family','Couple','Single','Pensioner Couple' respectively.
	expiryDate			DATE NOT NULL,
	payMethod			varchar(15), -- fk into the payment_method table
	status				varchar(15), -- fk into the membership_status table (may not be required)
	receiveGeneralNews 	enum('Y','N') NOT NULL DEFAULT 'N',
	receiveExpiryNotice enum('Y','N') NOT NULL DEFAULT 'N',
	receiveAdminEmail 	enum('Y','N') NOT NULL DEFAULT 'N',
	receiveEventInvites enum('Y','N') NOT NULL DEFAULT 'N',
	FOREIGN KEY (payMethod) REFERENCES tbl_payment_method(code) ON DELETE SET NULL,
	FOREIGN KEY (status) 	REFERENCES tbl_membership_status(code) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tbl_member
(
	memberId 		INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	firstName 		varchar(30) NOT NULL,
	dateOfBirth 	DATE NOT NULL,
	type 			ENUM('AM','AF','C'), -- 'Adult Male','Adult Female','Child' respectively 
	membershipId	varchar(128) NOT NULL,
	FOREIGN KEY (membershipId) REFERENCES tbl_membership(membershipId) ON DELETE CASCADE -- cascade the deletion because if a membership is removed, it stands to reason all the members are removed also.
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Login/Authentication supporting tables
CREATE TABLE IF NOT EXISTS tbl_user
(
	userId INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username varchar(128) NOT NULL UNIQUE,
	password varchar(128) -- SHA512 hash.
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tbl_user_role
(
	roleId INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	role varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- join table between users and their roles:
CREATE TABLE IF NOT EXISTS tbl_user_to_roles
(
	userId INT UNSIGNED NOT NULL,
	roleId INT UNSIGNED NOT NULL,
	CONSTRAINT tbl_user_to_roles_pk PRIMARY KEY(userId,roleId),
	FOREIGN KEY (userId) REFERENCES tbl_user(userId) ON DELETE CASCADE,
	FOREIGN KEY (roleId) REFERENCES tbl_user_role(roleId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;