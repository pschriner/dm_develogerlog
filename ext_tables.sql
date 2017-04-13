#
# Table structure for table 'tx_dmdeveloperlog_domain_model_logentry'
#
CREATE TABLE tx_dmdeveloperlog_domain_model_logentry (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	crdate varchar(20) DEFAULT '0' NOT NULL,
	request_id varchar(40) DEFAULT '' NOT NULL,
	request_type int(11) unsigned DEFAULT '0' NOT NULL,
	be_user int(11) unsigned DEFAULT '0' NOT NULL,
	fe_user int(11) unsigned DEFAULT '0' NOT NULL,
	severity int(4) DEFAULT '0' NOT NULL,
	extkey varchar(100) DEFAULT '' NOT NULL,
	system int(4) DEFAULT '0' NOT NULL,
	message text NOT NULL,
	location varchar(255) DEFAULT '' NOT NULL,
	line int(11) DEFAULT '0' NOT NULL,
	data_var text,
	workspace_uid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY crdate (crdate),
	KEY severity (severity)
);
