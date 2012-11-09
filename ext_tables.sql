#
# Table structure for table 'tx_ioceancomment_domain_model_comment'
#
CREATE TABLE tx_ioceancomment_domain_model_comment (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_user int(11) DEFAULT '0' NOT NULL,
	table_ref tinytext,
	id_content tinytext,
	comment text,
	name tinytext,
	email tinytext,
	validation tinytext,
	moderate tinyint(4) DEFAULT '0' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tt_content (
	tx_ioceancomment_active tinyint(4) DEFAULT '0' NOT NULL,
);

CREATE TABLE pages (
	tx_ioceancomment_active tinyint(4) DEFAULT '0' NOT NULL,
);