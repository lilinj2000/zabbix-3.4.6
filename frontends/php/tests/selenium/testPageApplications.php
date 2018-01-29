<?php
/*
** Zabbix
** Copyright (C) 2001-2018 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

require_once dirname(__FILE__) . '/../include/class.cwebtest.php';

class testPageApplications extends CWebTest {

	public static function allHosts() {
		return [
			[
				[
					// "Template OS Linux"
					'hostid' => 10001,
					'status' => HOST_STATUS_TEMPLATE
				]
			],
			[
				[
					// "Test host" ("Zabbix server")
					'hostid' => 10084,
					'status' => HOST_STATUS_MONITORED
				]
			]
		];
	}

	/**
	* @dataProvider allHosts
	*/
	public function testPageApplications_CheckLayout($data) {
		$this->zbxTestLogin('applications.php?groupid=0&hostid='.$data['hostid']);

		$this->zbxTestCheckTitle('Configuration of applications');
		$this->zbxTestCheckHeader('Applications');
		$this->zbxTestTextPresent('Displaying');
		$this->zbxTestTextPresent($data['status'] == HOST_STATUS_TEMPLATE ? 'All templates' : 'All hosts');

		$this->zbxTestTextPresent(['Applications', 'Items']);
		$this->zbxTestTextPresent(['Enable selected', 'Disable selected', 'Delete selected']);
		$this->zbxTestTextPresent(
				[
					'CPU',
					'Filesystems',
					'General',
					'Memory',
					'Network interfaces',
					'OS',
					'Performance',
					'Processes',
					'Security'
				]
		);
	}
}