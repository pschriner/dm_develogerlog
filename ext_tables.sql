#
# Table structure for table 'tx_dmdeveloperlog_domain_model_logentry'
#
CREATE TABLE tx_dmdeveloperlog_domain_model_logentry (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	request_id varchar(40) DEFAULT '' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	severity int(4) DEFAULT '0' NOT NULL,
	extkey varchar(100) DEFAULT '' NOT NULL,
	message text NOT NULL,
	location varchar(255) DEFAULT '' NOT NULL,
	line int(11) DEFAULT '0' NOT NULL,
	data_var text,
	workspace_uid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY crdate (crdate),
	KEY request_id (request_id)
);