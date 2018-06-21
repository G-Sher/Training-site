DROP TABLE IF EXISTS `test_results`;
CREATE TABLE IF NOT EXISTS `test_results` (
`user_id` varchar(25) NOT NULL,
`A_result` tinyint(1) NOT NULL DEFAULT '0',
`B_result` tinyint(1) NOT NULL DEFAULT '0',
`C_result` tinyint(1) NOT NULL DEFAULT '0',
`D_result` tinyint(1) NOT NULL DEFAULT '0',
`E_result` tinyint(1) NOT NULL DEFAULT '0',
`F_result` tinyint(1) NOT NULL DEFAULT '0',
`G_result` tinyint(1) NOT NULL DEFAULT '0',
`H_result` tinyint(1) NOT NULL DEFAULT '0',
`I_result` tinyint(1) NOT NULL DEFAULT '0',
`J_result` tinyint(1) NOT NULL DEFAULT '0',
`K_result` tinyint(1) NOT NULL DEFAULT '0',
`L_result` tinyint(1) NOT NULL DEFAULT '0',
`M_result` tinyint(1) NOT NULL DEFAULT '0',
`N_result` tinyint(1) NOT NULL DEFAULT '0',
`O_result` tinyint(1) NOT NULL DEFAULT '0',
`P_result` tinyint(1) NOT NULL DEFAULT '0',
`FINAL_eligible` tinyint(1) NOT NULL DEFAULT '0',
`FINAL_passed` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;